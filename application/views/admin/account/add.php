<!doctype html>
<html>
<head>
    <?php $this->view('partials/head',array('title'=>'Add Guest')); ?>

</head>
<body class="sidebar-push">

<?php $this->view('partials/topbar'); ?>

<?php $this->view('partials/sidebar'); ?>

<div class="container-fluid ">

    <div id="main">
        <div class="page-header">
            <h2 class="serif">Add</h2>
            <a href="<?php echo site_url('/contacts');?>" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
        </div>
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation">
                    <a href="#account" aria-controls="account" role="tab" data-toggle="tab">Add</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-content-default">
                <div role="tabpanel" class="tab-pane" id="account">

                    <?php echo form_open('account', array('class'=>'form-horizontal padding-15 validate'), array('contact_id' => 0));?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $account['last_name'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="<?php echo $account['email'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Skip Confirmation Email</label>
                        <div class="col-sm-9">
                            <?php echo form_checkbox('skip_confirmation', 0); ?> Add the guest without sending an email that requires their confirmation.
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-sm-9 ">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>

                    <?php echo form_close() ?>

                </div>
            </div>

            <div class="sidebar right-side" id="right-sidebar">

            </div>

        </div>
    </div>

    <?php $this->view('partials/footer'); ?>
</div>


<div class="overlay-disabled"></div>

<?php $this->view('admin/_common/footer_js', array('inline_js' => isset($inline_js) ? $inline_js : false)); ?>
</body>
</html>