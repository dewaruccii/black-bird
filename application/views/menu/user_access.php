<div class="container-fluid">



    <div class="row">
        <div class="col-lg-6 offset-3">
            <button type="button" id="add_access" class="btn btn-primary my-2" data-toggle="modal" data-target="#modal-lg">
                Add Access User Menu
            </button>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Access User Menu Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>

                                <th>Role</th>
                                <th>Menu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;
                            foreach ($data_user_menu as $dum) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $dum['role_text']; ?></td>
                                    <td>
                                        <?= $dum['menu']; ?>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">

                                                <a href="<?= base_url(); ?>menu_management/user_access/del/<?= $dum['role_id']; ?>/<?= $dum['menu_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php $i++;
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="d-flex justify-content-center">

                <a href="<?= base_url(); ?>menu_management " class="btn btn-primary mb-4"><i class="fas fa-arrow-circle-left"></i></a href="<?= base_url(); ?>menu_management ">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Role Id</label>
                                <select class="form-control" name="role_id" id="role">
                                    <option value="">Choose Role Id</option>
                                    <?php foreach ($role_id as $rd) : ?>
                                        <option value="<?= $rd['id']; ?>"><?= $rd['menu']; ?></option>

                                    <?php endforeach; ?>

                                </select>

                                <?= form_error('role_id', '<small class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Menu</label>
                                <select class="form-control" name="menu" id="role">
                                    <option value="">Choose Menu</option>
                                    <?php foreach ($role_id as $rd) : ?>
                                        <option value="<?= $rd['id']; ?>"><?= $rd['menu']; ?></option>

                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('menu', '<small id="notiff" class="mx-2  text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>