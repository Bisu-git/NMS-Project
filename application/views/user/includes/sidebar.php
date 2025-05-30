<?php $user_status = isset($profile->scope_id) ? $profile->scope_id : ''; ?>


<ul class="sidebar navbar-nav">
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo site_url('user/Dashboard'); ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('user/User_profile'); ?>">
      <i class="fas fa-fw fa-user"></i>
      <span>My Profile</span></a>
  </li>

  <?php if ($user_status == 'STATE' || $user_status == 'STATE & DISTRICT'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('user/Fetchuserdata'); ?>">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Fetch Data</span></a>
    </li>
  <?php endif; ?>

  <?php if ($user_status == 'ALL INDIA'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('user/Fetchallindata'); ?>">
        <i class="fas fa-fw fa-wrench"></i>
        <span>ALL INDIA USER</span></a>
    </li>
  <?php endif; ?>

  <?php if ($user_status == 'ALL INDIA'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('user/Fetchstatelist'); ?>">
        <i class="fas fa-fw fa-list"></i>
        <span>NMS REPORT</span></a>
    </li>
  <?php endif; ?>

  <?php if ($user_status == 'ALL INDIA'): ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('user/CO_Pilotgp_controller'); ?>">
        <i class="fas fa-fw fa-list"></i>
        <span>Pilot Projects GP Monitoring</span></a>
    </li>
  <?php endif; ?>


  <li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('user/Change_password'); ?>">
      <i class="fas fa-fw fa-table"></i>
      <span>Change Pasword</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('user/Login/logout'); ?>">
      <i class="fas fa-sign-out-alt"></i>
      <span>Log Out</span></a>
  </li>

</ul>