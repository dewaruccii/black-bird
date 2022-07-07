<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url(''); ?>" class="h1"><b><?= $name_bold; ?></b><?= $name_light; ?></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?= base_url(); ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
        </div>
        <!-- notif -->
        <div class="input-group">
        <?= form_error('email','<small class="fst-italic text-danger mx-2">','</small>'); ?>
        </div>
        <!-- end -->
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
           <!-- notif -->
        <div class="input-group">
        <?= form_error('password','<small class="fst-italic text-danger mx-2">','</small>'); ?>
        </div>
        <!-- end -->
        </div>
        <div class="row">
          <div class="col-8">
          
            <p class="mb-1">
              <a href="<?= base_url('auth/forgot'); ?>">I forgot my password</a>
            </p>
            <p class="mb-0">
              <a href="<?= base_url('auth/register'); ?>" class="text-center">Register a new membership</a>
            </p>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

   
      <!-- /.social-auth-links -->

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
