<?php $admin_status = isset($profile->admin_role) ? $profile->admin_role : ''; ?>
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.html">ADMIN PANEL</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

          <div class="input-group-append">

          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <?php if ($admin_status == 'SUPER ADMIN' || $admin_status == 'REGIONAL ADMIN'): ?>
              <a class="dropdown-item" href="<?php echo site_url('admin/Manage_Admins'); ?>">Admin Profile</a>
              <div class="dropdown-divider"></div>
            <?php endif; ?>
            <a class="dropdown-item" href="<?php echo site_url('admin/change_password'); ?>">Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo site_url('admin/Login/logout'); ?>">Logout</a>
          </div>
        </li>
      </ul>


    </nav>