<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Password Settings</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('settings/password/c'); ?>" method="POST">

                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="old">Old Password</label>
                                <input class="form-control" id="old" placeholder="Old Password" name="old" type="password">
                                <?= form_error('old', '<small class="fst-italic text-danger mx-2">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="new">New Password</label>
                                <input class="form-control" id="new" placeholder="New Password" name="new" type="password">
                                <?= form_error('new', '<small class="fst-italic text-danger mx-2">', '</small>'); ?>
                            </div>
                            <div class="col-md-12">
                                <label for="retype">Re-type New Password</label>
                                <input class="form-control" id="retype" placeholder="Re-type New Password" name="retype" type="password">
                                <?= form_error('retype', '<small class="fst-italic text-danger mx-2">', '</small>'); ?>
                            </div>
                        </div>
                        <button class="btn btn-primary mx-2">Change Password</button>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h5 class="m-0">Test</h5>
                </div>
                <div class="card-body">
                    ..
                </div>
            </div>
        </div>
    </div>
</div>