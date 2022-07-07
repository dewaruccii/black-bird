<div class="container-fluid">



    <div class="row">
        <div class="col-lg-6 offset-3">
            <button type="button" id="add_menu" class="btn btn-primary my-2" data-toggle="modal" data-target="#modal-lg">
                Add User Menu
            </button>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Menu Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>id</th>
                                <th>User Menu Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 1;
                            foreach ($data_user_menu as $dum) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $dum['id']; ?></td>
                                    <td>
                                        <?= $dum['menu']; ?>
                                    </td>
                                    <td>
                                        <div class="row">

                                            <div class="col-6">
                                                <button class="btn btn-success" id="edit_menu" data-toggle="modal" data-target="#modal-lg" data-id="<?= $dum['id']; ?>" data-menu="<?= $dum['menu']; ?>"><i class="fas fa-edit"></i></button>
                                            </div>
                                            <div class="col-6">

                                                <a href="<?= base_url(); ?>menu_management/user/del/<?= $dum['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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

                <a href="<?= base_url(); ?>menu_management " class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i></a href="<?= base_url(); ?>menu_management ">
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
                                <label for="idinput">id User Menu</label>
                                <input class="form-control id-input" id="idinput" name="id" type="text" placeholder="sequentially">
                                <?= form_error('id', '<small class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Name User Menu</label>
                                <input class="form-control name-input" id="idinput" name="name" type="text" placeholder="User Menu Name">
                                <?= form_error('name', '<small id="notif" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
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