  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
      <a href="./" class="brand-link">
        <?php if ($_SESSION['login_type'] == 1) : ?>
          <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
        <?php else : ?>
          <h3 class="text-center p-0 m-0"><b>USER</b></h3>
        <?php endif; ?>

      </a>

    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <!-- <a href="./index.php?page=dashboard" class="nav-link nav-dashboard"> -->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="./index.php?page=contoh" class="nav-link nav-task_contoh">
              <i class="fas fa-bookmark nav-icon"></i>
              <p>Contoh</p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Pekerjaan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($_SESSION['login_type'] != 3) : ?>
                <li class="nav-item">
                  <a href="./index.php?page=tambah_pekerjaan" class="nav-link nav-tambah_pekerjaan tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Tambah</p>
                  </a>
                </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=daftar_pekerjaan" class="nav-link nav-daftar_pekerjaan tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daftar</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="./index.php?page=rangkuman" class="nav-link nav-rangkuman">
              <i class="fa fa-list nav-icon"></i>
              <p>Rangkuman</p>
            </a>
          </li>

          <?php if ($_SESSION['login_type'] != 3) : ?>
            <li class="nav-item">
              <a href="./index.php?page=laporan" class="nav-link nav-laporan">
                <i class="fa fa-tasks nav-icon"></i>
                <p>Laporan</p>
              </a>
            </li>

          <?php endif; ?>
          <?php if ($_SESSION['login_type'] == 1) : ?>
            <li class="nav-item">
              <a href="#" class="nav-link nav-edit_user">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Pengguna
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.php?page=tambah_pengguna" class="nav-link nav-tambah_pengguna tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Tambah</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.php?page=daftar_pengguna" class="nav-link nav-daftar_pengguna tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Daftar</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
    $(document).ready(function() {
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if (s != '')
        page = page + '_' + s;
      if ($('.nav-link.nav-' + page).length > 0) {
        $('.nav-link.nav-' + page).addClass('active')
        if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
          $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
          $('.nav-link.nav-' + page).parent().addClass('menu-open')
        }

      }

    })
  </script>