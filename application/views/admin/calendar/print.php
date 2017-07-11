<html>
<head>
<?php if (isset($inline_css) && $inline_css) : ?>
<!-- Inline CSS -->
<style>
	/*media @print {*/
		body, td, th, span {
			font-family: Arial;
			font-size: 0.75em;
		}
		.fc-event {
			background-color: #da70d6;
		}
		<?php foreach ($inline_css as $style) : ?>
		<?php echo implode(', '."\n", $style['name']);?> {
			<?php echo $style['style'];?>
		}
	/*}*/
	<?php endforeach ?>
</style>
<?php endif; ?>
</head>

<body onload="window.print()">
<table style="border-collapse: collapse;" border="1">
    <thead>
		<tr>
        <th width="150" nowrap="" align="center"><?php echo $date;?></th>
        <?php foreach ($providers as $row) : ?>
        <th class="text-center" width="250"><?php echo $row['title'].' '.$row['first_name'];?></th>
        <?php endforeach?>
        <th width="150" nowrap="" align="center"><?php echo $date;?></th>
    </tr>    
    <tr>
        <th width="150" nowrap="" align="center" style="border: 1px solid #000;">Time/Work Sched.</th>
        <?php foreach ($providers as $row) : ?>
        <th class="text-center" width="250" style="border: 1px solid #000;">&nbsp;</th>
        <?php endforeach?>
        <th width="150" nowrap="" align="center" style="border: 1px solid #000;">Time/Work Sched.</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $time = mktime(0, 0, 0, 1, 1);
    
    
	$hide = array();
    for ($i = time_to_seconds(site_pref('start_time')); $i < time_to_seconds(site_pref('end_time')); $i += 1800) {  // 1800 = half hour, 86400 = one day

        $t = sprintf('%1$s', date('g:ia', $time + $i));
        $t1 = sprintf('%1$s', date('g:ia', $time + $i + 1800));
        $t2 = sprintf('%1$s', date('H:i:s', $time + $i));
        $t3 = sprintf('%1$s', date('H_i_s', $time + $i));
        $t4 = sprintf('%1$s', date('H:i', $time + $i));
		
        ?>
        <tr>
            <td align="center" nowrap="" style="background-color: #9ACD32;border: 1px solid #000;"><?php echo $t;?></td>
            <?php foreach ($providers as $row) : ?>
            <?php
	        $schedule = false;
	        if (isset($provider_events[$row['contact_id']]) && isset($provider_events[$row['contact_id']][$t4])) 
		        $schedule = $provider_events[$row['contact_id']][$t4];  
		        
		    $title = $schedule['title'];
		    
		    if ($schedule):    
		    	if (!in_array($schedule['event_id'].$row['contact_id'], $hide)) :
		    		$hide[] = $schedule['event_id'].$row['contact_id'];
	        ?>
            <td valign="top" rowspan="<?php echo $event_count[$schedule['event_id']]?>" style="border: 1px solid #ccc;" class="fc-event <?php echo $schedule['className'];?>"><span class="fc-content"><?php echo $title;?></span></td>
            	<?php else : ?>
            	<?php endif; ?>
            	
            <?php else : ?>
            <td style="border: 1px solid #ccc"></td>
            <?php endif; ?>
            <?php endforeach ?>
            <td align="center" nowrap="" style="background-color: #9ACD32;border: 1px solid #000;"><?php echo $t;?></td>
        </tr>
        <?php

    }
    ?>
    </tbody>
</table>
</body>
</html>