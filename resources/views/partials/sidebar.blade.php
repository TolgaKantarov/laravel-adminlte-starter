<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light align-middle">{{ config('app.name', 'Laravel') }}</span>
</a>

<div class="sidebar">

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">

        <a class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>

      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Simple Link
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>

    @can('user_management_access')
      <li class="nav-header">ADMINISTRATION</li>

      @can('user_management_access')
      <li class="nav-item has-treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'menu-open' : '' }}">
        <a class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Manage users
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Roles</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Permissions</p>
            </a>
          </li>
        </ul>
      </li>
      @endcan
    @endcan

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>