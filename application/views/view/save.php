<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?= $detail['title']; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
    <?php if (isset($assets['link'])) : ?>
        <?php foreach ($assets['link'] as $link) : ?>
            <link rel="stylesheet" href="<?= base_url('assets/'); ?><?= $link; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body class="hold-transition sidebar-mini">


    <div class="mailbox-read-message">
        <div class="container-fluid">
            <?= $detail['content']; ?>
        </div>
    </div>



    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script>
        window.print();
    </script>
    <?php $i = 1;
    if (isset($assets)) : ?>
        <?php while ($i < count($assets['script'])) : ?>
            <script src="<?= $assets['script']['link'][0]; ?>"></script>
            <?php if (isset($assets['script']['func'])) : ?>
                <script>
                    <?= $assets['script']['func'][0]; ?>
                </script>
            <?php endif; ?>
        <?php $i++;
        endwhile; ?>
    <?php endif; ?>
</body>

</html>