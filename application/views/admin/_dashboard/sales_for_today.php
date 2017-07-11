
<div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count text-center">
	<div class="value">
		&#x20B1;
		<?php if (isset($sales['daily_sales'][$today])) : ?>
			<?php echo money_format('%i', $sales['daily_sales'][$today]['total']);?>
		<?php else: ?> 0.00
		<?php endif;?>
	</div>
	<div class="tile_count_label text-muted">
		Sales Today
	</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count text-center">
	<div class="value">
		&#x20B1;
		<?php if (isset($sales['daily_sales'][$yesterday])) : ?>
			<?php echo money_format('%i', $sales['daily_sales'][$yesterday]['total']);?>
		<?php else: ?> 0.00
		<?php endif;?>
	</div>
	<div class="tile_count_label text-muted">
		Sales Yesterday
	</div>
</div>