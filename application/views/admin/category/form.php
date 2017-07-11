<?php
ob_start();
?>

<div class="row">

    <div class="col-lg-3">

                <p class="text-center">
                    <img class="img-responsive" src="<?php echo get_image_url($cat_image); ?>" style="padding-bottom:10px">
                    <span><input type="file" name="cat_image" class="filestyle"></span>
                </p>

    </div>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-12">
                <small class="bold text-muted">Name</small>
                <p>
                    <input type="text" class="form-control" name="cat_name" value="<?php echo $cat_name; ?>">
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <small class="bold text-muted">Parent Category</small>
                <p>
                    <?php echo form_dropdown('parent_id', $parent_categories, $parent_id); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6 col-lg-3">
                <small class="bold text-muted">Color</small>
                <div class="form-group">
                    <div id="facility-bg-colorpicker" class="input-group colorpicker-component">
                        <input type="text" name="cat_bg_color" value="<?php echo $cat_bg_color; ?>" class="form-control"/> <span
                            class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




<div class="row">
    <div class="col-lg-12">
        <small class="bold text-muted">Description</small>
        <textarea name="cat_body" class="summernote"><?php echo $cat_body; ?></textarea>
    </div>
</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
    'action' => 'backend/category/submit',
    'title' => $cat_id ? 'Edit Category' : 'Add Category',
    'hidden_fields' => array('id' => $cat_id, 'return' => $_REQUEST['return']),
    'contents' => $contents
));
?>
