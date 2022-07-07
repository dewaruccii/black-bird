<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="<?= base_url(''); ?>" class="h1"><b><?= $name_bold; ?></b><?= $name_light; ?></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <form action="<?= $url; ?>" method="post">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="input-group mx-2">
                   
                   <?= form_error('password','<small class="text-danger fst-italic">','</small>'); ?>
               </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name="password2">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="input-group mx-2">
                   
                   <?= form_error('password2','<small class="text-danger fst-italic">','</small>'); ?>
               </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="login.html">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


