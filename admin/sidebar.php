<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= '../'; ?>" class="btn btn-icon text-primary "><i class="fas fa-arrow-left"></i></a>
      <a href="<?= asset('admin') ?>" class="mr-5 ">B l o o d X</a>
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?= asset('admin') ?>">BX</a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="dropdown <?= setActive(['admin/index.php']); ?> ">
        <a href="<?= asset('admin/index.php'); ?>" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a>
      </li>

      <li class="dropdown <?= setActive(['admin/profile/index.php']); ?> ">
        <a href="<?= asset('admin/profile/index.php'); ?>" class="nav-link"><i class="fas fa-user"></i><span>Profile</span></a>
      </li>
      <li class="dropdown <?= setActive(['admin/waiting-list/index.php']); ?>">
        <a href="<?= asset('admin/waiting-list/index.php'); ?>" class="nav-link"><i class="fas fa-clock"></i><span>Waiting List</span></a>
      </li>
      <li class="dropdown <?= setActive(['admin/manage-requests/', 'admin/manage-requests/index.php']); ?>">
        <a href="<?= asset('admin/manage-requests/index.php'); ?>" class="nav-link"><i class="fas fa-cogs"></i><span>Manage Requests</span></a>
      </li>


      <li class="dropdown <?= setActive([
                            'admin/donors/',
                            'admin/donors/index.php',
                            'admin/donors/edit.php',
                            'admin/recipients/',
                            'admin/recipients/index.php',
                            'admin/recipients/edit.php',
                            'admin/users/',
                            'admin/users/index.php',
                            'admin/users/create.php',
                            'admin/users/edit.php',
                          ]); ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>Manage Users</span></a>
        <ul class="dropdown-menu ">
          <li class="<?= setActive([
                        'admin/users/',
                        'admin/users/index.php',
                        'admin/users/create.php',
                        'admin/users/edit.php',
                      ]); ?>">
            <a class="nav-link " href="<?= asset('admin/users/index.php'); ?>">Users</a>
          </li>

          <li class="<?= setActive([
                        'admin/donors/',
                        'admin/donors/index.php',
                        'admin/donors/edit.php',
                      ]); ?>">
            <a class="nav-link" href="<?= asset('admin/donors/index.php'); ?>">Donors</a>
          </li>

          <li class="<?= setActive([
                        'admin/recipients/',
                        'admin/recipients/index.php',
                        'admin/recipients/edit.php',
                      ]); ?>">
            <a class="nav-link" href="<?= asset('admin/recipients/index.php'); ?>">Recipients</a>
          </li>
        </ul>
      </li>

      <li class="dropdown <?= setActive([
                            'admin/failed/',
                            'admin/failed/index.php',
                            'admin/completed/',
                            'admin/completed/index.php',
                          ]); ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-heartbeat"></i><span>Appointments</span></a>
        <ul class="dropdown-menu">

          <li class="<?= setActive([
                        'admin/completed/',
                        'admin/completed/index.php',
                      ]); ?>">
            <a class="nav-link" href="<?= asset('admin/completed/index.php'); ?>">Completed</a>
          </li>
          <li class="<?= setActive([
                        'admin/failed/',
                        'admin/failed/index.php',
                      ]); ?>">
            <a class="nav-link" href="<?= asset('admin/failed/index.php'); ?>">Failed</a>
          </li>
        </ul>
      </li>
      <li class="dropdown <?= setActive(['admin/reports/', 'admin/reports/index.php']); ?>">
        <a href="<?= asset('admin/reports/index.php?last=1'); ?>" class="nav-link"><i class="fas fa-file-alt"></i><span>Reports</span></a>
      </li>

      <li class="dropdown <?= setActive(['admin/settings/forget-password.php', 'admin/settings/change-password.php']); ?> ">
        <a href="<?= asset('admin/settings/change-password.php'); ?>" class="nav-link ">
          <i class="fas fa-cog"></i> <span> Settings</span>
        </a>
      </li>

      <li class="dropdown">
        <a href="<?= asset('auth/logout.php'); ?>" class="nav-link" data-toggle="tooltip" data-confirm="Are You Sure?|do you want to logout?" data-confirm-yes="logout('<?= $_SESSION['LAYOUT_PATH_FRONTEND'] . 'auth/logout.php'; ?>')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
      </li>
    </ul>
  </aside>
</div>

<script>
  function logout(href) {
    window.location.href = href;
  }
</script>