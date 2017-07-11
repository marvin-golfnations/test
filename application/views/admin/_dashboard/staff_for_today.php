<?php
$codes = get_schedule_codes();
$date = date('Y-m-d');
?>
<div class="col-lg-2">
	<div class="panel panel-default">
		<div class="panel-heading bold">Staff on Duty <span class="badge"><?php echo count($providers);?></span></div>
		<ul class="list-group">
			<?php foreach ($providers as $row) :?>
				<?php
				$work_plan = $row['work_code'];

				if ($work_plan === 'custom') {
					$work_plan = get_provider_day_schedule($row['contact_id'], $date);
				}
				else {
					$work_plan = $codes[$work_plan];
				}
				?>
			<li class="list-group-item">
			<a href="<?php echo site_url('backend/account/edit/'.$row['contact_id']);?>"><?php echo $row['first_name'] . ' ' . $row['last_name'];?></a> <span class="text-muted"><?php echo $work_plan;?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>