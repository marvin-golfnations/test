<?php
ob_start();
//echo '<pre>';
//var_dump(get_item($item_id));
//
//$times = explode(',', '8:00 AM, 9:00 AM, 10:00 AM, 11:00 AM, 5:00 PM');
//
//foreach ($times as $tm)
//{
//    $_start_date = new DateTime('2017-10-10' . ' ' . $tm);
//
//    var_dump($_start_date);
//
//    $_end_date = new DateTime('2017-10-10' . ' ' . $tm);
//    $_end_date->add(new DateInterval('PT30M'));
//    var_dump($_end_date->format('Y-m-d H:i:s'));
//}
//
//
//echo '</pre>';
?>
	
	<div class="row">
		
		<div class="col-lg-2">
			<p>
				<img src="<?php echo get_image_url($item_image);?>" width="100" style="padding-bottom:10px">
				<span><input type="file" name="item_image" class="filestyle"></span>
			</p>
		</div>
		
		<div class="col-lg-10">
			<p>
				<input type="text" class="form-control" name="title" placeholder="Title of your service" value="<?php echo $title;?>">
			</p>
			<label class="bold text-muted"><i class="fa fa-clock"></i>Categories</label>
			<p>
				<?php echo form_multiselect('item_categories[]', $categories, $item_categories, 'class="multi-select" data-header="Select categories"'); ?>
			</p>
		</div>
		
	</div>
		
	<div class="row">
		<div class="col-xs-6 col-md-3 col-lg-3">
			
			<label class="bold text-muted"><i class="fa fa-clock"></i> Duration</label>

			<div class="row">
				<div class="col-md-6">
				<select name="duration_hours" class="form-control">
					<option value="">Hr</option>
					<option value="0"<?php if ($duration_hr == 0) : ?> selected<?php endif;?>>00</option>
					<option value="1"<?php if ($duration_hr == 1) : ?> selected<?php endif;?>>01</option>
					<option value="2"<?php if ($duration_hr == 2) : ?> selected<?php endif;?>>02</option>
					<option value="3"<?php if ($duration_hr == 3) : ?> selected<?php endif;?>>03</option>
					<option value="4"<?php if ($duration_hr == 4) : ?> selected<?php endif;?>>04</option>
					<option value="5"<?php if ($duration_hr == 5) : ?> selected<?php endif;?>>05</option>
					<option value="6"<?php if ($duration_hr == 6) : ?> selected<?php endif;?>>06</option>
					<option value="7"<?php if ($duration_hr == 7) : ?> selected<?php endif;?>>07</option>
					<option value="8"<?php if ($duration_hr == 8) : ?> selected<?php endif;?>>08</option>
					<option value="9"<?php if ($duration_hr == 9) : ?> selected<?php endif;?>>09</option>
					<option value="10"<?php if ($duration_hr == 10) : ?> selected<?php endif;?>>10</option>
					<option value="11"<?php if ($duration_hr == 11) : ?> selected<?php endif;?>>11</option>
					<option value="12"<?php if ($duration_hr == 12) : ?> selected<?php endif;?>>12</option>
				</select>
				</div>
				<div class="col-md-6">
				<select name="duration_minutes" class="form-control col-md-6">
					<option value="">Min</option>
					<option value="0"<?php if ($duration_min == 0) : ?> selected<?php endif;?>>00</option>
					<option value="5"<?php if ($duration_min == 5) : ?> selected<?php endif;?>>05</option>
					<option value="10"<?php if ($duration_min == 10) : ?> selected<?php endif;?>>10</option>
					<option value="15"<?php if ($duration_min == 15) : ?> selected<?php endif;?>>15</option>
					<option value="20"<?php if ($duration_min == 20) : ?> selected<?php endif;?>>20</option>
					<option value="25"<?php if ($duration_min == 25) : ?> selected<?php endif;?>>25</option>
					<option value="30"<?php if ($duration_min == 30) : ?> selected<?php endif;?>>30</option>
					<option value="35"<?php if ($duration_min == 35) : ?> selected<?php endif;?>>35</option>
					<option value="40"<?php if ($duration_min == 40) : ?> selected<?php endif;?>>40</option>
					<option value="45"<?php if ($duration_min == 45) : ?> selected<?php endif;?>>45</option>
					<option value="50"<?php if ($duration_min == 50) : ?> selected<?php endif;?>>50</option>
					<option value="55"<?php if ($duration_min == 55) : ?> selected<?php endif;?>>55</option>
				</select>
				</div>
			</div>
			
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3">
			<label class="bold text-muted">Abbreviation</label>
			<p>
				<input type="text" class="form-control" name="abbr" value="<?php echo $abbr;?>">
			</p>
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3">
			<label class="bold text-muted">Cost</label>
			<p>
				<input type="text" class="form-control" name="amount" value="<?php echo $amount;?>">
			</p>
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3">

			<label class="bold text-muted">Service Providers</label>
			<p>
				<input type="text" class="form-control" name="max_provider" value="<?php echo $max_provider;?>">
			</p>
		</div>
	</div>
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="50%">Day Settings <span class="text-muted" style="font-size: 12px;">accepts Mon...Sun separated by comma.</span></th>
                        <th>Time Settings <span class="text-muted" style="font-size: 12px;">accepts 01:00AM format separated by comma.</span></th>
                    </tr>
                </thead>
                <?php foreach ($day_time_settings as $i => $day_time_setting) : ?>
                <tr>
                    <td><input placeholder="Applicable to all week days" type="text" name="day_settings[]" style="width: 100%" value="<?php echo $day_time_setting['day_settings'];?>"></td>
                    <td><input type="text" name="time_settings[]" style="width: 100%" value="<?php echo $day_time_setting['time_settings'];?>"></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
			<label class="bold text-muted">Description</label>
			<textarea name="description" class="summernote"><?php echo $description;?></textarea>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-4">
			<label class="bold text-muted">Related Providers</label>
			<p>
			<?php echo form_multiselect('related_user_ids[]', $providers, $related_user_ids, 'class="multi-select" data-header="Select providers" data-live-search="true"'); ?>
			</p>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-4">
			<label class="bold text-muted">Related Forms</label>
			<p>
				<?php echo form_multiselect('related_form_ids[]', $forms, $related_form_ids, 'class="multi-select" data-header="Select questionaires/forms" data-live-search="true"'); ?>
			</p>
		</div>
		<div class="col-xs-12 col-md-12 col-lg-4">
			<label class="bold text-muted">Related Facilities</label>
			<p>
			<?php echo form_multiselect('related_facility_ids[]', $facilities, $related_facility_ids, 'class="multi-select" data-header="Select facilities" data-live-search="true"'); ?>
			</p>
		</div>
	</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/service',
	'title' => $item_id ? 'Edit Service' : 'Add Service',
	'hidden_fields' => array('id' => $item_id, 'return' => $_REQUEST['return']),
	'contents' => $contents
));
?>
