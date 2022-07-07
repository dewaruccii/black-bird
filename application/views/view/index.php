 <!-- Content Wrapper. Contains page content -->
 <div class="container-fluid mt-5 mb-5">

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="row bg-light">

                 <!-- /.col -->
                 <div class="col-md-12">
                     <div class="card card-primary card-outline">
                         <div class="card-header">
                             <h3 class="card-title">Book View</h3>
                             <div class="d-flex justify-content-end"><a href="<?= base_url('write'); ?>" class="btn btn-primary">Back to dashboard</a></div>
                         </div>

                         <!-- /.card-header -->
                         <div class="card-body p-0">
                             <div class="mailbox-read-info">
                                 <h5><?= $detail['title']; ?></h5>
                                 <h6>By: <?= $detail['author']; ?>
                                     <span class="mailbox-read-time float-right"><?= date('d F Y', $detail['post_at']); ?></span>
                                 </h6>
                             </div>
                             <!-- /.mailbox-read-info -->


                             <!-- /.mailbox-controls -->
                             <div class="mailbox-read-message">
                                 <div class="container-fluid">
                                     <?= $detail['content']; ?>
                                 </div>
                             </div>
                             <!-- /.mailbox-read-message -->

                         </div>

                         <!-- /.card-footer -->
                         <div class="card-footer">


                             <button type="button" id="save" class="btn btn-default"><i class="fas fa-save"></i> Save as pdf</button>
                             <div id="editor"></div>
                         </div>
                         <!-- /.card-footer -->
                     </div>
                     <!-- /.card -->
                 </div>
                 <!-- /.col -->
             </div>
             <!-- /.row -->
         </div><!-- /.container-fluid -->
     </section>
     <!-- /.content -->

     <!-- /.content-wrapper -->
 </div>