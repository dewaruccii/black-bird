  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019-2022 <a href="<?= base_url(); ?>"><?= $settings['copy']; ?></a>.</strong>
    All rights reserved.

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->

  <script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('assets/'); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('assets/'); ?>plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?= base_url('assets/'); ?>plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?= base_url('assets/'); ?>plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url('assets/'); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url('assets/'); ?>plugins/moment/moment.min.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url('assets/'); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= base_url('assets/'); ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('assets/'); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/'); ?>dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?= base_url('assets/'); ?>dist/js/pages/dashboard.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php $i = 1;
  if (isset($assets)) : ?>
    <?php while ($i < count($assets['script'])) : ?>
      <script src="<?= base_url('assets/'); ?><?= $assets['script']['link'][$i]; ?>"></script>
      <?php if (isset($assets['script']['func'])) : ?>
        <script>
          <?= $assets['script']['func'][0]; ?>
        </script>
      <?php endif; ?>
    <?php $i++;
    endwhile; ?>
  <?php endif; ?>
  <script>
    // Add
    $(document).ready(function() {
      $(document).on('click', '#edit_menu', function() {
        var id = $(this).data('id');
        var menu = $(this).data('menu');
        showModal("Edit User Menu", "menu_management/user/edit", "Save Changes")
        $(".modal-lg .id-input").val(id);
        $(".modal-lg .name-input").val(menu);


      });
      $(document).on('click', '#edit_sub', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var url = $(this).data('url');
        var icon = $(this).data('icon');
        var uniq = $(this).data('uniq');
        var is_badges = ($(this).data('badges') == 1) ? true : false;
        var is_tree = ($(this).data('tree') == 1) ? true : false;
        var is_active = ($(this).data('active') == 1 ? true : false);
        showModal("Edit Sub Menu", "menu_management/sub_menu/edit", "Save Changes")
        $(".modal-lg #menu_id").val(id);
        $(".modal-lg #title").val(title);
        $(".modal-lg #url").val(url);
        $(".modal-lg #icon").val(icon);
        $(".modal-lg #uniq_key").val(uniq);
        $(".modal-lg #badges").prop('checked', is_badges);
        $(".modal-lg #tree").prop('checked', is_tree);
        $(".modal-lg #activate").prop('checked', is_active);


      });
      $(document).on('click', '#edit_sub_tree', function() {
        var id = $(this).data('id');
        var id_tree = $(this).data('id_tree');

        var title = $(this).data('title');
        var url = $(this).data('url');
        var icon = $(this).data('icon');
        var uniq = $(this).data('uniq');
        var is_badges = ($(this).data('badges') == 1) ? true : false;

        var is_active = ($(this).data('active') == 1 ? true : false);
        showModal("Edit Sub Menu Tree", "menu_management/tree/edit", "Save Changes")
        $(".modal-lg #menu_id").val(id + ',' + id_tree).change();
        console.log(id + ',' + id_tree);
        $(".modal-lg #title").val(title);
        $(".modal-lg #url").val(url);
        $(".modal-lg #icon").val(icon);
        $(".modal-lg #uniq_key").val(uniq);
        $(".modal-lg #badges").prop('checked', is_badges);

        $(".modal-lg #activate").prop('checked', is_active);


      });
    });

    function showModal(title, url, btntxt) {

      $(".modal-lg .id-input").val("");
      $(".modal-lg .name-input").val("");
      $(".modal-lg .modal-title").text(title);
      $(".modal-lg form").attr('action', '<?= base_url(); ?>' + url);
      $(".modal-lg .modal-footer .btn-primary").text(btntxt);

      $("#modal-lg").modal('show');
    }
    // add
    $('#add_menu').on('click', function() {
      showModal('Add User Menu', 'menu_management/user/add', 'Add');
    });
    $('#add_access').on('click', function() {
      showModal('Add User Access Menu', 'menu_management/user_access/add', 'Add');
    });
    $('#add_sub').on('click', function() {
      $(".modal-lg #menu_id").val("");
      $(".modal-lg #title").val("");
      $(".modal-lg #url").val("url");
      $(".modal-lg #icon").val("");
      $(".modal-lg #uniq_key").val("");
      $(".modal-lg #badges").prop('checked', false);
      $(".modal-lg #tree").prop('checked', false);
      $(".modal-lg #activate").prop('checked', false);
      showModal('Add Sub Menu', 'menu_management/sub_menu/add', 'Add');
    });
    $('#add_sub_tree').on('click', function() {
      $(".modal-lg #menu_id").val("");
      $(".modal-lg #title").val("");
      $(".modal-lg #url").val("url");
      $(".modal-lg #icon").val("");
      $(".modal-lg #uniq_key").val("");
      $(".modal-lg #badges").prop('checked', false);

      $(".modal-lg #activate").prop('checked', false);
      showModal('Add Sub Menu Tree', 'menu_management/tree/add', 'Add');
    });
    // end add
    // role

    // end role

    //notif
    if ($('#notif').attr('id')) {
      $(document).ready(function() {
        showModal('Add User Menu', 'menu_management/user/add', 'Add');
      });
    } else if ($('#notiff').attr('id')) {
      $(document).ready(function() {
        showModal('Add User Access Menu', 'menu_management/user_access/add', 'Add');
      });
    } else if ($('#notifff').attr('id')) {
      $(document).ready(function() {
        showModal('Add Sub Menu', 'menu_management/sub_menu/add', 'Add');
      });
    } else if ($('#notiffff').attr('id')) {
      $(document).ready(function() {
        showModal('Add Sub Menu Tree', 'menu_management/tree/add', 'Add');
      });
    } else if ($('#notifa').attr('id')) {
      $(document).ready(function() {
        showModal('Add New Post', 'write', 'Add');
      });
    }
    //end notif

    $(document).load($(window).bind("resize", checkPosition));

    function checkPosition() {
      if ($(window).width() < 767) {
        $(".container-fluid .row .col-lg-6").attr('class', 'col-lg-6')
      } else {
        $(".container-fluid .row .col-lg-6").attr('class', 'col-lg-6 offset-3')
      }
    }
  </script>
  <?= $this->session->flashdata('message'); ?>
  <?php unset($_SESSION['message']); ?>
  <script>
    $("#phone").on("keypress", function(e) {
      $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });
    $("#idinput").on("keypress", function(e) {
      $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });
  </script>
  </body>

  </html>