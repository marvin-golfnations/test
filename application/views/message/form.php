<?php
ob_start();
?>
<div class="form-group">
    <label for="" class="col-sm-3 control-label">Subject</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="subject" name="subject" value="">
    </div>
</div>

<div class="form-group">
    <label for="" class="col-sm-3 control-label">To</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="to" name="to" value="<?php echo $email;?>">
    </div>
</div>

<div class="form-group">
    <label for="" class="col-sm-3 control-label">Message</label>
    <div class="col-sm-9">
        <textarea name="message" id="message" cols="30" rows="10" class="summernote"></textarea>
    </div>
</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
    'action' => 'message/send',
    'title' => $contact_id ? 'Edit Form' : 'Add Form',
    'hidden_fields' => array('contact_id' => $contact_id),
    'contents' => $contents
));
?>