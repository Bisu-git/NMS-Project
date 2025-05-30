<?php $admin_status = isset($profile->admin_role) ? $profile->admin_role : ''; ?>

<ul class="sidebar navbar-nav">
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo site_url('admin/Dashboard'); ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('admin/Manage_Users'); ?>">
      <i class="fas fa-fw fa-users"></i>
      <span>Manage Users</span></a>
  </li>

  <li class="nav-item ">
    <a class="nav-link" href="<?php echo site_url('admin/Fetch_serverdata'); ?>">
      <i class="fas fa-fw fa-cog"></i>
      <span>Fetch Server Data</span></a>
  </li>

  <?php if ($admin_status == 'SUPER ADMIN' || $admin_status == 'REGIONAL ADMIN'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('admin/Auser_signup'); ?>">
        <i class="fas fa-fw fa-user-plus"></i>
        <span>Create New Users</span></a>
    </li>
  <?php endif; ?>

  <?php if ($admin_status == 'SUPER ADMIN' || $admin_status == 'REGIONAL ADMIN'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('admin/Admin_signup'); ?>">
        <i class="fas fa-fw fa-user-tie"></i>
        <span>Register Admin</span></a>
    </li>
  <?php endif; ?>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('admin/Roals_scope'); ?>">
      <i class="fas fa-fw fa-user-tie"></i>
      <span>ROLES & SCOPE</span></a>
  </li>

</ul>