<?php if ($this->session->flashdata('success_message')) : ?>
<div id="notification" data-position="top-right" class="display-none">
    <?php echo $this->session->flashdata('success_message') ?>
</div>
<?php endif; ?>
