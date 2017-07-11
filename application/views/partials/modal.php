    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <?php echo form_open_multipart($action,
                array('role' => 'form', 'ajax' => isset($ajax) ? $ajax : '',
                    'id' => isset($form_id) ? $form_id : ''), $hidden_fields); ?>

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php echo $title;?></h4>
            </div>
            <div class="modal-body">
                <?php echo $contents ?>
            </div>
            <div class="modal-footer">
	            <?php if (isset($custom_buttons) && $custom_buttons) : ?>
	            <?php echo $custom_buttons; ?>
	            <?php endif; ?>
                <button class="btn btn-default btn-link" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving" name="save-booking">Save</button>
                <div class="loader" style="display: none;"></div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>