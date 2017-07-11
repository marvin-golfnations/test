<?php if ($this->session->flashdata('success_message')) : ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('success_message') ?>
    </div>
<?php endif ?>

<?php if ($this->session->flashdata('error_message')) : ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('error_message') ?>
    </div>
<?php endif ?>

<?php echo form_open_multipart('account', array('class'=>'form-horizontal padding-15 validate'), array('contact_id' => $contact_id, 'return' => $return));?>
    <div class="form-group">
        <label for="avatar" class="col-sm-3 control-label">Profile Picture</label>
        <div class="col-sm-5">
            <div class="media">

                <?php if ($account['avatar']) : ?>
                    <div class="media-left">
                        <img src="<?php echo $account['avatar'];?>" width="80" alt="person">
                    </div>
                <?php endif; ?>

                <div class="media-body media-middle">
                    <input type="file" name="avatar" class="filestyle">
                    <small class="text-muted bold">Size 80x80px</small>
                </div>
            </div>
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Last Name</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $account['last_name'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">First Name</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $account['first_name'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Nick Name</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $account['nickname'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Title</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="title" value="<?php echo $account['title'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Position</label>
        <div class="col-sm-5">
            <?php echo form_input('position', $account['position']); ?>
        </div>
    </div>
	<div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Civil Status</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="civil_status" value="<?php echo $account['civil_status'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Gender</label>
        <div class="col-sm-5">
            <div class="radio radio-info radio-inline">
                <input type="radio" id="female" value="0" name="gender" <?php  echo ($account['gender']==0) ? "checked":""; ?>>
                <label for="female"> Female </label>
            </div>
            <div class="radio radio-info radio-inline">
                <input type="radio" id="male" value="1" name="gender" <?php  echo ($account['gender']==1) ? "checked":""; ?>>
                <label for="male"> Male </label>
            </div>
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Date of Birth</label>
        <div class="col-sm-5">
            <input type="text" class="datepicker form-control" name="dob" value="<?php echo ($account['dob'] === '' || $account['dob'] === '0000-00-00') ? '':date('m/d/Y', strtotime($account['dob']));?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Ethnic Origin</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="etnic_origin" value="<?php echo $account['etnic_origin'];?>">
        </div>
    </div>
	<div class="line line-dashed b-b line-lg pull-in"></div>    
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Height</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="height" value="<?php echo $account['height'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Weight</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="weight" value="<?php echo $account['weight'];?>">
        </div>
    </div>
	<div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Telephone Number</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="phone" value="<?php echo $account['phone'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-5">
            <input type="email" class="form-control" name="email" value="<?php echo $account['email'];?>">
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Nationality</label>
        <div class="col-sm-5">
            <?php echo form_dropdown('nationality', $nationalities, $nationality, array("class"=>"selectpicker show-tick form-control")); ?>
        </div>
    </div>
    <div class="line line-dashed b-b line-lg pull-in"></div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">Country of Dominicile</label>
        <div class="col-sm-5">
            <?php echo form_dropdown('country_dominicile', $countries, $account['country_dominicile'], array("class"=>"selectpicker show-tick form-control")); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-5 ">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>

<?php echo form_close() ?>