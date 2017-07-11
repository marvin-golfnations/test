<html>
<head>
    <style>
        body, td, span, th{
            font-family: Calibri,Arial,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
        }

        table th, table td {
            width: 275px;
        }

        table th.time, table td.time {
            width: 175px;
        }
    </style>
</head>

<body>
<table style="table-layout: fixed; border-collapse: collapse;" border="1">
    <thead>
    <tr>

        <?php foreach ($dates as $i => $date) : ?>
            <th class="time">Time</th><th class="text-center" width="250"><?php echo 'Day '.($day_start++).'<br />'.$date->format('d-M-y').'<br />'.$date->format('l');?></th>
        <?php endforeach?>
        <?php if ($show_label) : ?>
            <th colspan="2" style="width: 450px">&nbsp;</th>
        <?php endif; ?>
        <!--<th width="150">Time</th>-->
    </tr>
    </thead>
    <tbody>
    <?php
    $time = mktime(0, 0, 0, 1, 1);

    $rowspan = 0;

    $label = false;

    for ($i = time_to_seconds(site_pref('start_time')); $i < time_to_seconds(site_pref('end_time')); $i += 1800) {  // 1800 = half hour, 86400 = one day

        $t = sprintf('%1$s', date('g:ia', $time + $i));
        $t1 = sprintf('%1$s', date('g:ia', $time + $i + 1800));
        $t2 = sprintf('%1$s', date('H:i:s', $time + $i));
        $t3 = sprintf('%1$s', date('H_i_s', $time + $i));
        $t4 = sprintf('%1$s', date('H:i', $time + $i));

        $rowspan++;

        ?>
        <tr>
            <!--<td align="center" class="time"><?php echo $t.'-'.$t1;?></td>-->
            <?php
            foreach ($dates as $day => $date) :
            $event = isset($events[$date->format('Y-m-d')]) ? $events[$date->format('Y-m-d')] : false;
                echo '<td align="center" class="time">'.$t.'-'.$t1.'</td>';
            if ($event && isset($event[$t4])) {

                $backgroundColor = $event[$t4]['bg_color'];

                echo '<td align="center" width="200" style="background-color: '.$backgroundColor.'">'.($event[$t4]['title'] ? $event[$t4]['title'] : $event[$t4]['item_name']).'</td>';
                //echo '<td align="center" class="time">'.$t.'-'.$t1.'</td>';
            }
            else {
                echo '<td></td>';
                //echo '<td align="center" class="time">'.$t.'-'.$t1.'</td>';
            }
            endforeach;

            if (!$label && $show_label):
                $label = true;
            ?>
            <td rowspan="34" colspan="2" align="center">
                <p><img src="/images/logo_main.png"> </p><br /><br />
                <p><b><?php echo $booking['first_name'].' ' . $booking['last_name'];?></b></p><br /><br />
                <p><b><?php echo $begin->format('m/d/Y');?> - <?php echo $end->format('m/d/Y');?></b></p><br />
                <p><?php echo $duration.' Nights';?></p><br /><br />
                <p><b><?php echo $booking['title'];?></b></p>
            </td>
            <?php endif;?>
        </tr>
        <?php


    }
    ?>
    </tbody>
</table>
</body>
</html>