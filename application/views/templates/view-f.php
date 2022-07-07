<!-- jQuery -->
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script>
    $("#save").click(function() {
        var url = "<?= base_url('v?r=' . $detail['link'] . '&download=yes'); ?>";
        window.open(url, '_blank');

    });
</script>
<?php $i = 1;
if (isset($assets['script'])) : ?>
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