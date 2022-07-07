<?php // var_dump($data_user_menu);
//die;
?>

<div class="container-fluid">


    <button type="button" id="add_sub" class="btn btn-primary my-2" data-toggle="modal" data-target="#modal-lg">
        Add Sub Menu
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
                        <th>menu</th>
                        <th>Title</th>
                        <th>Url</th>
                        <th>Icon</th>
                        <th>Badges</th>
                        <th>Tree</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1;
                    foreach ($data_user_menu as $dum) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $dum['menu']; ?></td>
                            <td>
                                <?= $dum['title']; ?>
                            </td>
                            <td>
                                <?= $dum['url']; ?>
                            </td>
                            <td>
                                <i class="<?= $dum['icon']; ?>"></i>

                            </td>
                            <td>
                                <?= $dum['is_badges'] == 1 ? "<p class='text-success'>True</p>" : "<p class='text-danger'>False</p>"; ?>
                            </td>
                            <td>
                                <?= $dum['is_tree'] == 1 ? "<p class='text-success'>True</p>" : "<p class='text-danger'>False</p>"; ?>
                            </td>
                            <td>
                                <?= $dum['is_active'] == 1 ? "<p class='text-success'>True</p>" : "<p class='text-danger'>False</p>"; ?>
                            </td>
                            <td>
                                <div class="row">

                                    <div class="col-6">
                                        <button class="btn btn-success" id="edit_sub" data-id="<?= $dum['menu_id']; ?>" data-title="<?= $dum['title']; ?>" data-url="<?= $dum['url']; ?>" data-icon="<?= $dum['icon']; ?>" data-badges="<?= $dum['is_badges']; ?>" data-tree="<?= $dum['is_tree']; ?>" data-active="<?= $dum['is_active']; ?>" data-uniq="<?= $dum['uniq_key']; ?>" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-edit"></i></button>
                                    </div>
                                    <div class="col-6">

                                        <a href="<?= base_url(); ?>menu_management/sub_menu/del/<?= $dum['uniq_key']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                <label for="idinput">Menu Category</label>
                                <select class="form-control" name="menu_id" id="menu_id">
                                    <option value="">Select Category Menu</option>
                                    <?php foreach ($user_menu as $um) : ?>
                                        <option value="<?= $um['id']; ?>"><?= $um['menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('menu_id', '<small id="notifff" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Title</label>
                                <input class="form-control name-input" id="title" name="title" type="text" placeholder="User">
                                <input type="hidden" name="uniq_key" value="" id="uniq_key">
                                <?= form_error('title', '<small id="notifff" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Url</label>
                                <input class="form-control name-input" id="url" name="url" type="text" placeholder="user/home">
                                <?= form_error('url', '<small id="notifff" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Icon</label>
                                <input class="form-control name-input" id="icon" name="icon" type="text" placeholder="fas fa-example">
                                <?= form_error('icon', '<small id="notifff" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="nameinput1">Badges</label>
                                <div class="custom-control custom-switch custom-switch-off-ligth custom-switch-on-success">
                                    <input type="checkbox" name="badges" class="custom-control-input" id="badges">
                                    <label class="custom-control-label" for="badges">show badges next to text</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="nameinput2">Tree</label>
                                <div class="custom-control custom-switch custom-switch-off-ligth custom-switch-on-success">
                                    <input type="checkbox" name="tree" class="custom-control-input" id="tree">
                                    <label class="custom-control-label" for="tree">To Activate tree in SubMenu</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="nameinput3">Active</label>
                                <div class="custom-control custom-switch custom-switch-off-ligth custom-switch-on-success">
                                    <input type="checkbox" name="active" class="custom-control-input" id="activate">
                                    <label class="custom-control-label" for="activate">To Activate Sub Menu</label>
                                </div>
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