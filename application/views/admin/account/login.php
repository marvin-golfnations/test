<?php echo form_open('backend/account/login', array('id' => 'validateLogin', 'class'=>'validate form-horizontal padding-15'), array('contact_id' => $contact_id, 'return' => $return));?>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Username</label>
        <div class="col-sm-9">
            <input type="text" class="form-control required" id="username" name="username" value="<?php echo $account['username'] ? $account['username'] : $account['email'];?>">
        </div>
    </div>
    <?php if ($account['username']) : ?>
    <?php if (is_admin()) : ?>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Member Group Assignment</label>
            <div class="col-sm-9">
                <?php echo form_dropdown('group_id', tf_user_groups(), !$account['group_id'] ? 5 : $account['group_id'], array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (is_admin()) : ?>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Assignment</label>
            <div class="col-sm-9">
                <?php echo form_dropdown('location_id', get_locations(), $account['location_id'], array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Last Login</label>
        <div class="col-sm-9">
            <?php if (!$account['last_login']) : ?>
                Never
            <?php else : ?>
                <?php echo date('c', $account['last_login']); ?>
            <?php endif; ?>
        </div>
    </div>
    <fieldset>
        <legend>Password Change Form</legend>
        <div class="alert alert-info">Leave blank if you do not wish to change it</div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">New Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="new_password" name="new_password" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Confirm New Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control confirm_password" id="confirm_new_password" name="confirm_new_password" value="">
            </div>
        </div>
    </fieldset>
    <hr />
    <?php else : ?>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control required" id="password" name="password" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Confirm Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" name="confirm_password" value="">
        </div>
    </div>
    <?php if (is_admin()) : ?>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Member Group Assignment</label>
            <div class="col-sm-9">
                <?php echo form_dropdown('group_id', tf_user_groups(), !$account['group_id'] ? 5 : $account['group_id'], array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (is_admin()) : ?>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Assignment</label>
            <div class="col-sm-9">
                <?php echo form_dropdown('location_id', get_locations(), isset($account['location_id']) ? $account['location_id'] : 0, array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Last Login</label>
        <div class="col-sm-9">
            <?php if (!$account['last_login']) : ?>
                Never
            <?php else : ?>
                <?php echo date('c', $account['last_login']); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <hr>
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-9 ">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
<?php echo form_close() ?>