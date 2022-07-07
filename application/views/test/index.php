<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Sign In to your account</p>
                  <form action="<?= base_url(); ?>" method="POST">
                  <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use href="<?= base_url('vendor/coreui/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
                      </svg></span>
                    <input class="form-control" type="text" placeholder="Email" name="email"  value="<?= set_value('email'); ?>">
                    <div class="input-group mx-2">

                    <?= form_error('email','<small class="text-dark">','</small>'); ?>
                    </div>
                </div>
                  <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use href="<?= base_url('vendor/coreui/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                      </svg></span>
                    <input class="form-control" type="password" placeholder="Password" name="password">
                    <div class="input-group mx-2">

                        <?= form_error('email','<small class="text-dark">','</small>'); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-primary px-4" type="submit">Login</button>
                    </div>
                    </form>
                    <div class="col-6 text-end">
                        <a class="btn btn-link px-0" href="#">Forgot password?</a>
                      <!-- <button class="btn btn-link px-0" type="button">Forgot password?</button> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="card col-md-5 text-white bg-primary py-5">
                <div class="card-body text-center">
                  <div>
                    <h2>Sign up</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <a class="btn btn-lg btn-outline-light mt-3" href="#">Register Now!</a>
                    <!-- <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>