<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{   
        
    public function __construct()
    {
       $this->middleware(['can:user_management_access']);
    }

    public function index()
    {
        //abort_unless(auth()->user()->hasPermissionTo('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->latest()->paginate(10);
        $active_users = $users->whereNotNull('email_verified_at')->whereNull('banned_at')->count();
        $unconfirmed_users = $users->whereNull(['email_verified_at'])->whereNull(['banned_at'])->count();
        $banned_users = $users->whereNotNull('banned_at')->count();

        return view('admin.users.index')->with([
            'users' => $users, 
            'active_users' => $active_users,
            'unconfirmed_users' => $unconfirmed_users,
            'banned_users' => $banned_users,
        ]);
    }

    public function create()
    {
        $roles = Role::all()->pluck('name', 'id');

        return view('admin.users.create')->with([
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ]);

        $user = User::create(array_merge(
                $request->all(), 
                ['email_verified_at' => now()]
            )
        );

        $user->roles()->sync($request->input('roles', []));

        if ($request->input('send_welcome_email')) {
            Mail::to($user)->send(new WelcomeEmail($user));
        }

        return redirect()->route('admin.users.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show')->with(['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all()->pluck('name');

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }


    public function update_general(Request $request, $id)
    {

        $validated_data = $request->validate([
            'name' => 'min:3|max:255',
            'email' => 'email'
        ]);

        User::whereId($id)->update($validated_data);

        return redirect()->back()->with('status_general', 'Successfully updated information!');  

    }

    public function update_password(Request $request, $id)
    {

        $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => [Password::min(8)->numbers(), 'confirmed'],
        ]);

        User::whereId($id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->with('status_password', 'Successfully changed password!');  

    }

    public function update_status(Request $request, $id)
    {

        $request->validate([
            'status' => ['required', 'in:not_confirmed,active'],
        ]);

        if ($request->status == 'not_confirmed') {
            User::whereId($id)->update(['email_verified_at'=> null]);
        } else {
            User::whereId($id)->update(['email_verified_at'=> now()]);
        }

        return redirect()->back()->with('status', 'Successfully updated status!');  

    }

    public function update_role(Request $request, $id)
    {

        $request->validate([
            'role' => ['required'],
        ]);

        $user = User::find($id);
        $user->assignRole($request->role);

        return redirect()->back()->with('status', 'Successfully updated role!');  

    }

    public function ban_hammer(Request $request, User $user)
    {   
        if ($user->banned_at == null AND $request->input('action') == 1) {

            $user->banUser();
            return redirect()->back()->with('status', 'Successfully banned user!');

        } else if ($user->banned_at != null AND $request->input('action') == 0) {

            $user->unbanUser();
            return redirect()->back()->with('status', 'Successfully unbanned user!');

        }
    }

    public function update_avatar(Request $request, $id)
    {
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        
        $user = User::find($id);

        if ($user->avatar != 'default.png') {
            Storage::delete('uploads/avatars/' . $user->avatar);
        }
        
        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('uploads/avatars', $avatarName);

        //Storage::setVisibility('uploads/avatars/' . $avatarName, 'private');

        $user->avatar = $avatarName;
        $user->save();
        
        return redirect()->back()->with('status', 'Successfully updated profile picture!');  

    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Successfully deleted user!');
    }
}
