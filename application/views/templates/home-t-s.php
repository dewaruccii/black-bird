<?php $cek = $this->uri->segment(1);
$cek1 = $this->uri->segment(2); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url(); ?>" class="brand-link">
    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $settings['logo_text']; ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('assets/'); ?>dist/img/<?= $profile['image']; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url(); ?>settings/profile" class="d-block"><?= $profile['nama']; ?></a>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <?php
        $role_id = $this->session->userdata('role_id');

        $query = "SELECT `user_menu`.`id`, `menu`
                      FROM `user_menu` JOIN `user_access_menu` 
                      ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                      WHERE `user_access_menu`.`role_id` = $role_id
                      ORDER BY `user_access_menu`.`menu_id` ASC";

        $menu = $this->db->query($query)->result_array();



        ?>

        <!-- Looping Menu -->
        <!-- Title -->
        <?php foreach ($menu as $m) : ?>

          <li class="nav-header"><?= $m['menu']; ?></li>

          <?php
          $query_sub_menu = "SELECT *
                                    FROM `sub_menu` JOIN `user_menu` 
                                    ON `sub_menu`.`menu_id` = `user_menu`.`id`
                                    WHERE `sub_menu`.`menu_id` = $m[id]
                                    AND `sub_menu`.`is_active` = 1
                                    ";
          $sub_menu = $this->db->query($query_sub_menu)->result_array();

          ?>
          <!-- end Title -->
          <!-- sub menu -->
          <?php foreach ($sub_menu as $sm) : ?>
            <li class="nav-item">
              <a href="<?= base_url(); ?><?= $sm['is_tree'] == 1 ? '#' : $sm['url']; ?>" class="nav-link <?= $cek == $sm['url'] ? 'active' : ''; ?>">
                <i class="nav-icon <?= $sm['icon']; ?>"></i>
                <p>
                  <?= $sm['title']; ?>
                  <?php if ($sm['is_badges'] == 1) {
                    $badges = "<span class='badge badge-info right'>2</span>";
                  } else {
                    $badges = "";
                  } ?>
                  <?= $sm['is_tree'] == 1 ? '<i class="fas fa-angle-left right"></i>' : $badges ?>

                </p>
              </a>
              <?php if ($sm['is_tree'] == 1) : ?>
                <?php $query_sub_menu_tree = "SELECT * FROM sub_menu_tree WHERE id_tree='$sm[id_tree]' And is_active=1";
                $submenu_tree = $this->db->query($query_sub_menu_tree)->result_array();
                // var_dump($submenu_tree);
                // die;
                ?>
                <ul class="nav nav-treeview">
                  <?php foreach ($submenu_tree as $sbt) : ?>
                    <li class="nav-item">
                      <a href="<?= base_url(); ?><?= $sbt['url']; ?>" class="nav-link <?php $as = explode('/', $sbt['url']);
                                                                                      echo $cek1 == $as[1] ? 'active' : '';  ?>">
                        <i class="<?= $sbt['icon']; ?> nav-icon"></i>
                        <p><?= $sbt['title']; ?></p>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
          <!-- end sub menu -->

        <?php endforeach; ?>


        <li class="nav-header">Exit</li>
        <li class="nav-item">
          <a href="<?= base_url(); ?>auth/logout" class="nav-link">
            <i class="nav-icon far fas fa-sign-out-alt"></i>
            <p>
              Logout

            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>