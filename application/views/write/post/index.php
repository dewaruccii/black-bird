<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <form id="form" action="<?= base_url('write/e/' . $detail['id_post']); ?>" method="POST">
                <div class="row">

                    <div class="col-md-4 form-group">
                        <button type="submit" id="draft" class="btn btn-dark form-control"><i class="far fa-folder-open"></i> Save to Draft</button>
                    </div>
                    <div class="col-md-4 form-group">
                        <button type="submit" id="public" class="btn btn-success form-control"><i class="fab fa-telegram-plane"></i> Post to Public</button>
                    </div>
                    <div class="col-md-4 form-group">
                        <button type="submit" id="private" class="btn btn-info form-control"><i class="fas fa-user-lock"></i> Save as Private</button>
                    </div>
                </div>
                <textarea name="summernote" id="summernote" cols="30" rows="10">

                <?php if (isset($detail['content'])) {
                    echo $detail['content'];
                } ?>
                </textarea>

            </form>
        </div>
    </div>
</div>