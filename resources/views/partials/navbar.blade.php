<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <li class="nav-item dropdown user-menu show">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="{{ auth()->user()->getUserAvatar() }}" class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <!-- User image -->
        <li class="user-header bg-primary">
          <img src="{{ auth()->user()->getUserAvatar() }}" class="img-circle elevation-2" alt="User Image">

          <p>
            {{ auth()->user()->name }}
            <small><b>Member since:</b> {{ auth()->user()->created_at->format('d M Y') }}</small>
          </p>
        </li>

        <!-- Menu Body -->
<!--         <li class="user-body">
          <div class="row">
            <div class="col-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-4 text-center">
              <a href="#">Friends</a>
            </div>
          </div>
        </li> -->
        <!-- /.row -->

        <!-- Menu Footer-->
        <li class="user-footer">
          <a href="#" class="btn btn-default btn-flat">Profile</a>

          <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" 
            class="btn btn-default btn-flat float-right">Sign out</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>

        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li> -->

  </ul>
</nav>