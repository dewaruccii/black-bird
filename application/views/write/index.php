<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">Add New Post</button>
        </div>
    </div>
</div>

<?php if ($post_detail) : ?>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">
                        #
                    </th>
                    <th style="width: 20%">
                        Post Name
                    </th>
                    <th style="width: 30%">
                        Author
                    </th>
                    <th>
                        Save to
                    </th>
                    <th style="width: 8%" class="text-center">
                        Password
                    </th>
                    <th style="width: 20%" class="text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($post_detail as $pd) : ?>
                    <tr>
                        <td>
                            <?= $i; ?>
                        </td>
                        <td>
                            <a>
                                <?= $pd['title']; ?>
                            </a>
                            <br />
                            <small>
                                <?= date('d F Y, h:i:s A', $pd['post_at']); ?>
                            </small>
                            <br />
                            <small><i class="fas fa-eye"></i> <?= $pd['watch']; ?></small>
                        </td>
                        <td>
                            <a><?= $pd['author']; ?></a>
                        </td>
                        <td class="project_progress">
                            <?php if ($pd['type'] == 1) {
                                $type = "Draft";
                            } else if ($pd['type'] == 2) {
                                $type = "Private";
                            } else if ($pd['type'] == 3) {
                                $type = "Public";
                            } else {
                                $type = "Not";
                            } ?>
                            <a><?= $type ?></a>
                        </td>
                        <td class="project-state">
                            <?php $badges = $pd['password'] == 1 ? 'success' : 'danger';
                            $text = $pd['password'] == 1 ? 'Yes' : 'No'; ?>
                            <span class="badge badge-<?= $badges; ?>"><?= $text; ?></span>
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="<?= base_url('v?r=') .
                                                                        $pd['link']; ?>">
                                <i class="far fa-eye"></i>
                                </i>
                                View
                            </a>
                            <a class="btn btn-info btn-sm" href="<?= base_url('write/e/') .
                                                                        $pd['id_post']; ?>">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a>
                            <a class="btn btn-warning btn-sm" href="#">
                                <i class="fas fa-cog"></i>
                                Post Settings
                            </a>

                            <a class="btn btn-danger btn-sm" href="<?= base_url('write/d/' . $pd['id_post']); ?>">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>

            </tbody>
        </table>
    </div>
<?php else : ?>


    <div class="col-md-12">
        <h1 class="text-center">Nothing</h1>
    </div>


<?php endif; ?>

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>write" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Title</label>
                                <input class="form-control name-input" id="title" name="title" type="text" placeholder="title of post">

                                <?= form_error('title', '<small id="notifa" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nameinput">Password</label>
                                <input class="form-control name-input" name="password" type="text" placeholder="if you don't use a password, leave it blank">
                                <?= form_error('password', '<small id="notifff" class="mx-2 text-danger"><cite>', '</cite></small>'); ?>
                            </div>
                        </div>



                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>