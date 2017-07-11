<!doctype html>
<html>
<head>
    <?php $this->view('partials/head',array('title'=>'Account')); ?>

</head>
<body class="sidebar-push">

<?php $this->view('partials/topbar'); ?>

<?php $this->view('partials/sidebar'); ?>



<div class="container-fluid ">

    <div id="main">
        <div class="page-header">
            <h2 class="serif">Add User</h2>
            <a href="<?php echo site_url('backend/contacts/staff');?>" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
        </div>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#account" aria-controls="account" role="tab" data-toggle="tab">Account</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-content-default">
                <div role="tabpanel" class="tab-pane active" id="account">
                    <?php
                        echo form_open('backend/account/user',
                        array('class'=>'form-horizontal padding-15 validate'), array('group_id' => $this->uri->segment(3)));
                    ?>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last_name" name="last_name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="first_name" name="first_name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="">
                        </div>
                    </div>
                    <?php if (is_admin()) : ?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Assignment</label>
                            <div class="col-sm-9">
                                <?php echo form_dropdown('location_id', get_locations(), $this->session->userdata('location_id'), array('class' => 'form-control')); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Skip Confirmation Email</label>
                        <div class="col-sm-9">
                            <?php echo form_checkbox('skip_confirmation', 1); ?> Add the user without sending an email that requires their confirmation.
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