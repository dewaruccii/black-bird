<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?= base_url(''); ?>" class="h1"><b><?= $name_bold; ?></b><?= $name_light; ?></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Password is required to open this document.</p>
            <form action="<?= base_url('v/password/' . $data['link']); ?>" method="post">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <div class="input-group mx-2">
                        <?= form_error('password', '<small class="text-danger fst-italic">', '</small>'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Unlock</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->




<!--  -->