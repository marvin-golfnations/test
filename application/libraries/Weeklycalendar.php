<?php

/**
 * EasyWeeklyCalClass V 1.0. A class that generates a weekly schedule easily configurable *
 * @author Ruben Crespo Alvarez [rumailster@gmail.com] http://peachep.wordpress.com
 */
class WeeklyCalendar
{

    var $day;
    var $month;
    var $year;
    var $date;
    var $base;
    var $schedule;
    var $schedule_code;


    public function __construct($params)
    {
        list($year, $month, $day) = explode('-', $params['date']);

        $this->base = isset($params['base']) ? site_url($params['base']) : '/';
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->schedule = $params['schedule'];
        $this->schedule_code = $params['schedule_code'];
        $this->date = $this->showDate($month, $day, $year);
    }


    public function showCalendar()
    {

        $Output = '';
        $Output .= $this->buttonsWeek($this->day, $this->month, $this->year, $this->date["numdaysMonth"]);
        //$Output .= $this->buttons ($this->day, $this->month, $this->year, $this->date["numdaysMonth"]);
        $Output .= "<table class=\"table table-striped table-hover\">";
        $Output .= $this->WeekTable($this->date ["dayMonth"], $this->date ["dayWeek"], $this->date["numdaysMonth"], $this->date["nameMonth"], $this->day, $this->month, $this->year);
        $Output .= "</table>";

        return $Output;
    }


    public function WeeksInMonth($month, $leapYear, $firstDay)
    {
        if ($month == 1 or $month == 3 or $month == 5 or $month == 7 or $month == 8 or $month == 10 or $month == 12) {

            if ($firstDay > 5) {
                return 6;
            } else {
                return 5;
            }

        } else if ($month == 4 or $month == 6 or $month == 9 or $month == 11) {

            if ($firstDay == 7) {
                return 6;
            } else {
                return 5;
            }


        } else if ($month == 2) {

            if ($leapYear == "0" and $firstDay == 1) {
                return 4;
            } else {
                return 5;
            }

        }


    }


    public function showDate($month, $day, $year, $hour = 0, $min = 0, $second = 0)
    {
        $fecha = mktime($hour, $min, $second, $month, $day, $year);

        $cal ["dayMonth"] = date("d", $fecha);
        $cal ["nameMonth"] = date("F", $fecha);
        $cal ["numdaysMonth"] = date("t", $fecha);

        if (date("w", $fecha) == "0") {
            $cal ["dayWeek"] = 7;
        } else {
            $cal ["dayWeek"] = date("w", $fecha);
        }

        $cal ["namedaySem"] = date("l", $fecha);
        $cal ["leapYear"] = date("L", $fecha);


        return $cal;
    }


    public function dayName($day)
    {

        if ($day == 1) {
            $Output = "Mon";
        } else if ($day == 2) {
            $Output = "Tue";
        } else if ($day == 3) {
            $Output = "Wed";
        } else if ($day == 4) {
            $Output = "Thu";
        } else if ($day == 5) {
            $Output = "Fri";
        } else if ($day == 6) {
            $Output = "Sat";
        } else if ($day == 7) {
            $Output = "Sun";
        }

        return $Output;
    }


    public function previousMonth($day, $month, $year)
    {
        $month = $month - 1;
        $month = $this->showDate($month, $day, $year);
        return $month;
    }


    public function nextMonth($day, $month, $year)
    {
        $month = $month + 1;
        $month = $this->showDate($month, 1, $year, "10", "00", "00");
        return $month;
    }


    public function numberOfWeek($day, $month, $year)
    {
        $firstDay = $this->showDate($month, 1, $year);
        $numberOfWeek = ceil(($day + ($firstDay ["dayWeek"] - 1)) / 7);
        return $numberOfWeek;
    }


    public function WeekTable($dayMonth, $dayWeek, $numdaysMonth, $nameMonth, $day, $month, $year)
    {


        if ($dayWeek == 0) {
            $dayWeek = 7;
        }

        $n = 0;

        /*NUMBER OF WEEKS AND WEEK NUMBER*/
        $WeekNumber = $this->showDate($month, 1, $year);
        $WeeksInMonth = $this->WeeksInMonth($month, $WeekNumber["leapYear"], $WeekNumber["dayWeek"]);
        $numberOfWeek = $this->numberOfWeek($day, $month, $year);
        $Output = '';
        $Output .= "<tr><td>&nbsp;</td>";

        $substraction = $dayWeek - 1;
        $dayMonth = $dayMonth - $substraction;
        $change = 0;
        $namePrevious = '';
        $monthVar = 1;
        $yearVar = 1;
        $previousMonth = array();
        $statuses = get_schedule_codes();

        for ($i = 1; $i < $dayWeek; $i++) {

            if ($dayMonth < 1) {
                $previousMonth = $this->previousMonth($day, $month, $year);
                $daysPrevious = $previousMonth ["numdaysMonth"];
                $namePrevious = $previousMonth ["nameMonth"];

                if ($month == 1) {
                    $monthVar = 12;
                    $yearVar = $year - 1;

                } else {

                    $monthVar = $month - 1;
                    $yearVar = $year;
                }

                $change = 1;
                $dayMonth = $daysPrevious + $dayMonth;

            } else {

                if ($change != 1) {
                    $namePrevious = $nameMonth;
                    $monthVar = $month;
                    $yearVar = $year;
                }
            }
            
			$_m = str_pad($monthVar, 2, "0", STR_PAD_LEFT);   
	        $_d = str_pad($dayMonth, 2, "0", STR_PAD_LEFT);  
            $name = $yearVar.'-'.$_m.'-'.$_d;
            

            $status = isset($this->schedule_code[$name]) ? $this->schedule_code[$name] : '';

            if ($dayMonth == $day) {

                $Output .= "<th class='text-center schedule schedule-".$status."'>" . $this->dayName($i) . ", " . $namePrevious . " of " . $dayMonth;
                $Output .= "<br />".form_dropdown('schedule_day['.$name.']', $statuses, $status, 'id="date-'.$name.'" style="width:100%; display:inline" class="form-control"').'</th>';

            } else {

                $Output .= "<th class='text-center schedule schedule-".$status."'>" . $this->dayName($i) . ", " . $namePrevious . " " . $dayMonth;
                $Output .= "<br />".form_dropdown('schedule_day['.$name.']', $statuses, $status, 'id="date-'.$name.'" style="width:100%; display:inline" class="form-control"').'</th>';
            }


            $dayLink[$n]["day"] = $dayMonth;
            $dayLink[$n]["month"] = $monthVar;
            $dayLink[$n]["year"] = $yearVar;


            if (isset($previousMonth["numdaysMonth"]) && $dayMonth == $previousMonth["numdaysMonth"]) {
                $dayMonth = 1;
                $change = 0;
            } else {
                $dayMonth++;
            }

            $n++;

        }


        //Seguimos a partir del day seleccionado
        for ($dayWeek; $dayWeek <= 7; $dayWeek++) {

            if ($dayMonth > $numdaysMonth) {
                $monthS = $this->nextMonth($day, $month, $year);
                $nameFollowing = $monthS ["nameMonth"];
                if ($month == 12) {
                    $monthVar = 1;
                    $yearVar = $year + 1;
                } else {
                    $monthVar = $month + 1;
                }

                $change = 1;
                $dayMonth = 1;

            } else {

                if ($change != 1) {
                    $nameFollowing = $nameMonth;
                    $monthVar = $month;
                    $yearVar = $year;
                }
            }
            
            $_m = str_pad($monthVar, 2, "0", STR_PAD_LEFT);   
	        $_d = str_pad($dayMonth, 2, "0", STR_PAD_LEFT);   


            $name = $yearVar.'-'.$_m.'-'.$_d;

            $status = isset($this->schedule_code[$name]) ? $this->schedule_code[$name] : '';


            if ($dayMonth == $day) {
                $Output .= "<th class='text-center schedule schedule-".$status."'>" . $this->dayName($dayWeek) . ", " . $nameFollowing . " " . $dayMonth;
                $Output .= "<br />".form_dropdown('schedule_day['.$name.']', $statuses, $status, 'id="date-'.$name.'" style="width:100%; display:inline" class="form-control"').'</th>';
            } else {
                $Output .= "<th class='text-center schedule schedule-".$status."'>" . $this->dayName($dayWeek) . ", " . $nameFollowing . " " . $dayMonth;
                $Output .= "<br />".form_dropdown('schedule_day['.$name.']', $statuses, $status, 'id="date-'.$name.'" style="width:100%; display:inline" class="form-control"').'</th>';

            }

            $dayLink[$n]["day"] = $dayMonth;
            $dayLink[$n]["month"] = $monthVar;
            $dayLink[$n]["year"] = $yearVar;
            $n++;

            $dayMonth++;

        }


        $Output .= "</tr>";

        $time = mktime(0, 0, 0, 1, 1);
//        
//        $default = array();
//        
//        for ($i = $this->to_seconds(site_pref('start_time')); $i < $this->to_seconds(site_pref('end_time')); $i += 1800) {  // 1800 = half hour, 86400 = one day
//			$default[] = $time+$i;
//	    }

        for ($i = 0; $i < 86400; $i += 1800) {  // 1800 = half hour, 86400 = one day

			$tm = $time + $i;	
				
            $t = sprintf('%1$s', date('h:i A', $tm));
            $t2 = sprintf('%1$s', date('H:i', $tm));

            ob_start();
            ?>
            <tr>
                <td nowrap=""><?php echo $t; ?></td>
                <?php for ($n = 0; $n <= 6; $n++)  : ?>
                	<?php
	                	$_m = str_pad($dayLink[$n]["month"], 2, "0", STR_PAD_LEFT);   
	                    $_d = str_pad($dayLink[$n]["day"], 2, "0", STR_PAD_LEFT);       
                        $date = $dayLink[$n]["year"] . '-' . $_m . '-' . $_d;
                        $checked = false;
                        
                        $has_schedule = isset($this->schedule[$date]) ? $this->schedule[$date] : false;

                        if ($has_schedule && is_array($this->schedule[$date]) && in_array($t2, $this->schedule[$date])) {
                            $checked = true;
                        }

                        $status = isset($this->schedule_code[$date]) ? 'schedule-'.$this->schedule_code[$date] : '';

                    ?>
                    <td nowrap="" class="text-center schedule <?php echo $status;?> date-<?php echo $date;?>">
                        <?php
                        echo form_checkbox('schedule[' . $date . '][]', $t2, $checked);
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
            <?php

            $ret = ob_get_contents();
            ob_end_clean();

            $Output .= $ret;

        }


//        for ($i = 0; $i < 24; $i++) {
//            $Output .= "<tr>";
//
//            $Output .= "
//            <td><b>" . $i . ":00</b></td>";
//
//
//            for ($n = 0; $n <= 6; $n++) {
//                $date = $dayLink[$n]["year"] . '-' . $dayLink[$n]["month"] . '-' . $dayLink[$n]["day"];
//                $Output .= "<td class='text-center'>" . form_checkbox('schedule[' . $date . '][' . $i . ']') . "</td>";
//            }
//
//
//            $Output .= "</tr>";
//        }

        return $Output;
    }

    function buttonsWeek($day, $month, $year, $numdaysMonth)
    {
        $thisMonth = $this->showDate($month, $day, $year);
        $thisMontOne = $this->showDate($month, 1, $year);
        $previousMonth = $this->previousMonth($day, $month, $year);
        $WeeksInMonth = $this->WeeksInMonth($month, $thisMonth["leapYear"], $thisMonth["dayWeek"]);
        $numberOfWeek = $this->numberOfWeek($day, $month, $year);
        $daysRemaining = (7 - $thisMonth["dayWeek"]);

        //BOTON ANT
        if ($day <= 7) {

            $ant = $previousMonth["numdaysMonth"] - (($thisMontOne["dayWeek"] - 1)) + 1;
            $monthAnt = $month - 1;

            if ($month == 1) {
                $yearAnt = $year - 1;
                $monthAnt = 12;
            } else {
                $yearAnt = $year;
            }


        } else {

            $ant = $day - ($thisMonth["dayWeek"] + 6);
            $monthAnt = $month;
            $yearAnt = $year;
        }


        //BOTON POST
        if ($numberOfWeek == $WeeksInMonth) {
            $post = "1";
            $monthPost = $month + 1;

            if ($month == 12) {
                $yearPost = $year + 1;
                $monthPost = 1;
            } else {
                $yearPost = $year;
            }

        } else {

            $post = $day + ($daysRemaining + 1);
            $monthPost = $month;
            $yearPost = $year;
        }

        $url = site_url($this->base);

        $previous_week = $this->base . '/' . $yearAnt . '-' . $monthAnt . '-' . $ant;
        $next_week = $this->base . '/' . $yearPost . '-' . $monthPost . '-' . $post;

        $Output = '';
        $Output .= "<p><a class='btn' href='" . $previous_week . "'>&laquo; previous week</a> | <a class='btn' href='" . $next_week . "'>next week &raquo;</a></p>";

        return $Output;

    }


    function buttons($day, $month, $year, $numdaysMonth)
    {
        $previousMonth = $this->previousMonth($day, $month, $year);
        $nextMonth = $this->nextMonth($day, $month, $year);

        $ant = $day - 1;


        //BOTON ANT
        if ($day == 1) {
            $ant = $previousMonth ["numdaysMonth"];
            $monthAnt = $month - 1;

            if ($month == 1) {
                $yearAnt = $year - 1;
                $monthAnt = 12;
            } else {
                $yearAnt = $year;
            }


        } else {
            $ant = $day - 1;
            $monthAnt = $month;
            $yearAnt = $year;
        }


        //BOTON POST
        if ($day == $numdaysMonth) {
            $post = "1";
            $monthPost = $month + 1;

            if ($month == 12) {
                $yearPost = $year + 1;
                $monthPost = 1;
            } else {
                $yearPost = $year;
            }

        } else {

            $post = $day + 1;
            $monthPost = $month;
            $yearPost = $year;
        }

        $next = $this->base . '/' . $yearPost . '-' . $post . '-' . $monthPost;
        $prev = $this->base . '/' . $yearAnt . '-' . $ant . '-' . $monthAnt;

        $Output = '';
        $Output .= "<p>

<a class='btn' href='" . $prev . "'>&laquo; previous</a> |

<a class='btn' href='" . $next . "'>next &raquo;</a>
</p>";

        return $Output;
    }


}//End of WeeklyCalendar Class


?>