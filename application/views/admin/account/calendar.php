<div class="media">
	<div class="media-body">
		
		<div class="clearfix" style="padding-bottom: 10px;">
			
			<div class="btn-group" data-toggle="buttons">
			  <label class="btn btn-default active">
			    <input type="radio" checked name="calendar-categories" value="1,2,3,12"> All
			  </label>
			  <label class="btn btn-default">
			    <input type="radio" name="calendar-categories" value="1,2"> Treatments
			  </label>
			  <label class="btn btn-default">
			    <input type="radio" name="calendar-categories" value="3,12"> Nutrional Activities
			  </label>
			</div>
		
		</div>
		
		<div class="separator"></div>
		
		<!--
		<?php if ($confirmed_bookings) : ?>
			<div class="form-group">
				<select id="basic" name="category" class="selectpicker show-tick form-control" data-live-search="false">
					<?php foreach ($confirmed_bookings as $row): ?>
						<option value="<?php echo $row['booking_id']; ?>"><?php echo $row['title']; ?></option>
					<?php endforeach ?>
				</select>
			</div>
		<?php endif; ?>
		-->
		<!-- Calendar -->
		<div id='calendar'></div>
	</div>
	<?php if (current_user_can('can_assign_schedules')): ?>
		<div class="media-right clearfix-xs">
			<div class="width-300">
				<h4 class="headline text-center">Services</h4>
				<div id="this-month-event-list"></div>
				<?php foreach ($booking_items as $item) : ?>
					<?php
					$inv = (int)$item['quantity'] - (int)$item['inventory'];
					if ($inv > 0) :
					?>
					<p>
						<a data-booking-item-id="<?php echo $item['booking_item_id']; ?>"
						   data-uom="<?php echo $item['uom'] ?>" data-resource-id="0"
						   data-booking-id="<?php echo $booking_id; ?>" data-duration="<?php echo $item['duration']; ?>"
						   data-qty="<?php echo $inv; ?>" data-item-id="<?php echo $item['item_id']; ?>"
						   title="<?php echo $item['title']; ?>" href="#"
						   class="btn btn-primary btn-xs btn-add-item-to-calendar"><?php echo $item['title']; ?>
							x <?php echo $inv ?> <?php echo $item['uom'] ?></a>
					</p>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>