<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="<?= base_url(''); ?>" class="h1"><b><?= $name_bold; ?></b><?= $name_light; ?></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="<?= base_url('auth/register'); ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="name" value="<?= set_value('name'); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <div class="input-group mx-2">
                   
                   <?= form_error('name','<small class="text-danger fst-italic">','</small>'); ?>
               </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <div class="input-group mx-2">
                   
                   <?= form_error('email','<small class="text-danger fst-italic">','</small>'); ?>
               </div>
        </div>
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
          <input type="password" class="form-control" placeholder="Retype password" name="password2">
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
          <div class="col-8">
            <a href="<?= base_url(); ?>" class="text-center">I already have a membership</a>
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

   

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
