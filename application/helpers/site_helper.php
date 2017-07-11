<?php

function site_info($key)
{
    return '';
}

function site_title() {
    $TF =& get_instance();
    $site = $TF->db->get('sites')->row_array();

    return $site['site_title'];
}

function site_pref($pref, $site = 1)
{
    $TF =& get_instance();
    $site = $TF->db->get('sites')->row_array();

    $preferences = json_decode($site['site_system_preferences'], true);
    
    if (!isset($preferences[$pref])) return false;
    
    return $preferences[$pref];
}

function update_site_pref($pref, $value, $default = '') {
    $TF =& get_instance();
    $site = $TF->db->get('sites')->row_array();

    $site_id = (int)$site['site_id'];
    $preferences = json_decode($site['site_system_preferences'], true);

    if (!isset($preferences[$pref])) {
        $preferences[$pref] = $value ? $value : $default;
    }

    $TF->db->update('sites', array('site_system_preferences' => json_encode($preferences)), 'site_id='.$site_id);
}

/**
 * Hours and minutes dropdown.
 * @param $name
 * @param $selected
 * @param string $attr
 */
function hm_dropdown($name, $selected, $attr = '')
{
    $time = mktime(0, 0, 0, 1, 1);

    $options = array();

    for ($i = 0; $i < 86400; $i += 900) {  // 1800 = half hour, 86400 = one day

        $t = sprintf('%1$s', date('h:i A', $time + $i));
        $t2 = sprintf('%1$s', date('H:i:s', $time + $i));
        $t3 = sprintf('%1$s', date('H_i_s', $time + $i));

        $options[$t] = $t;
    }

    return form_dropdown($name, $options, $selected);
}

function nationalities() {
    $arr = array('Afghan','Albanian','Algerian','American','Andorran','Angolan','Antiguans','Argentinean','Armenian','Australian','Austrian','Azerbaijani','Bahamian','Bahraini','Bangladeshi','Barbadian','Barbudans','Batswana','Belarusian','Belgian','Belizean','Beninese','Bhutanese','Bolivian','Bosnian','Brazilian','British','Bruneian','Bulgarian','Burkinabe','Burmese','Burundian','Cambodian','Cameroonian','Canadian','Cape Verdean','Central African','Chadian','Chilean','Chinese','Colombian','Comoran','Congolese','Costa Rican','Croatian','Cuban','Cypriot','Czech','Danish','Djibouti','Dominican','Dutch','East Timorese','Ecuadorean','Egyptian','Emirian','Equatorial Guinean','Eritrean','Estonian','Ethiopian','Fijian','Filipino','Finnish','French','Gabonese','Gambian','Georgian','German','Ghanaian','Greek','Grenadian','Guatemalan','Guinea-Bissauan','Guinean','Guyanese','Haitian','Herzegovinian','Honduran','Hungarian','Icelander','Indian','Indonesian','Iranian','Iraqi','Irish','Israeli','Italian','Ivorian','Jamaican','Japanese','Jordanian','Kazakhstani','Kenyan','Kittian and Nevisian','Kuwaiti','Kyrgyz','Laotian','Latvian','Lebanese','Liberian','Libyan','Liechtensteiner','Lithuanian','Luxembourger','Macedonian','Malagasy','Malawian','Malaysian','Maldivan','Malian','Maltese','Marshallese','Mauritanian','Mauritian','Mexican','Micronesian','Moldovan','Monacan','Mongolian','Moroccan','Mosotho','Motswana','Mozambican','Namibian','Nauruan','Nepalese','Netherlander','New Zealander','Ni-Vanuatu','Nicaraguan','Nigerian','Nigerien','North Korean','Northern Irish','Norwegian','Omani','Pakistani','Palauan','Panamanian','Papua New Guinean','Paraguayan','Peruvian','Polish','Portuguese','Qatari','Romanian','Russian','Rwandan','Saint Lucian','Salvadoran','Samoan','San Marinese','Sao Tomean','Saudi','Scottish','Senegalese','Serbian','Seychellois','Sierra Leonean','Singaporean','Slovakian','Slovenian','Solomon Islander','Somali','South African','South Korean','Spanish','Sri Lankan','Sudanese','Surinamer','Swazi','Swedish','Swiss','Syrian','Taiwanese','Tajik','Tanzanian','Thai','Togolese','Tongan','Trinidadian or Tobagonian','Tunisian','Turkish','Tuvaluan','Ugandan','Ukrainian','Uruguayan','Uzbekistani','Venezuelan','Vietnamese','Welsh','Yemenite','Zambian','Zimbabwean');

    $nationalities = array();
    foreach ($arr as $text) {
        $nationalities[$text] = $text;
    }

    return $nationalities;
}

function position() {

    $TF =& get_instance();
    $TF->db->distinct();
    $TF->db->select('position');
    $TF->db->from('contacts');

    $query = $TF->db->get();
    $result = $query->result_array();

    $positions = array();
    foreach ($result as $row) {
        $positions[] = $row['position'];
    }

    return $positions;
}

function keyval($result_array, $key_id, $key_value, $group_by = false, &$output = array())
{
	if (!$result_array) return $output;
	
	foreach ($result_array as $row) {
		$values = array();
		if (is_array($key_value)) {
			foreach ($key_value as $k) {
				if (isset($row[$k])) {
					$values[] = $row[$k];
				}
			}
		}
		else {
			$values = array($row[$key_value]);
		}
		
		if ($group_by && isset($row[$group_by])) {
			$group = $row[$group_by] === '' ? 'Others' : $row[$group_by];
			
			$output[$group][$row[$key_id]] = implode(' ', $values);
		}
		else
			$output[$row[$key_id]] = implode(' ', $values);
	}

	return $output;
}

function countries() {
    return
        array("AF" => "Afghanistan",
        "AX" => "Åland Islands",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, The Democratic Republic of The",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and Mcdonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, The Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory, Occupied",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and The Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and The South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TL" => "Timor-leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.S.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe");
}

function draw_calendar($month,$year){

    /* draw table */

    $calendar = '<table cellpadding="0" cellspacing="0" class="table table-bordered">';

    /* table headings */
    $headings = array('Su','Mo','Tu','We','Th','Fr','Sa');
    $calendar.= '<tr class="calendar-row"><th class="calendar-day-head">'.implode('</th><th class="calendar-day-head">',$headings).'</th></tr>';

    /* days and weeks vars now ... */
    $running_day = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();

    /* row for week one */
    $calendar.= '<tr class="calendar-row">';

    /* print "blank" days until the first of the current week */
    for($x = 0; $x < $running_day; $x++):
        $calendar.= '<td class="calendar-day-np"> </td>';
        $days_in_this_week++;
    endfor;

    /* keep going with days.... */
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
        $calendar.= '<td class="calendar-day">';
        /* add in the day number */
        $calendar.= '<div class="day-number">'.$list_day.'</div>';

        /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
        $calendar.= str_repeat('<p> </p>',2);

        $calendar.= '</td>';
        if($running_day == 6):
            $calendar.= '</tr>';
            if(($day_counter+1) != $days_in_month):
                $calendar.= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++; $running_day++; $day_counter++;
    endfor;

    /* finish the rest of the days in the week */
    if($days_in_this_week < 8):
        for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
        endfor;
    endif;

    /* final row */
    $calendar.= '</tr>';

    /* end the table */
    $calendar.= '</table>';

    /* all done, return result */
    return $calendar;
}

function get_schedule_codes() {
	
    $statuses = array(
        '' => '',
        '1' => '6:00 AM - 3:00 PM',
        '2' => '7:00 AM - 4:00 PM',
        '3' => '8:00 AM - 5:00 PM',
        '4' => '8:30 AM - 5:30 PM',
        '5' => '9:00 AM - 6:00 PM',
        '6' => '12:00 PM - 9:00 PM',
        '7' => '1:00 PM - 10:00 PM',
        '8' => '9:00 PM - 6:00 AM',
        '9' => '2:00 PM - 11:00 PM',
        '10' => '10:00 PM - 7:00 AM',
        '11' => '3:00 PM - 12:00 AM',
        '12' => '10:00 AM - 7:00 PM',
        'A' => '6:00 AM - 10:00 AM',
        'B' => '7:00 AM - 11:00 AM',
        'C' => '8:00 PM - 12:00 PM',
        'D' => '4:00 PM - 9:00 PM',
        'VL' => 'Vacation Leave',
        'SL' => 'Sick Leave',
        'EL' => 'Emergency Leave',
        'PL' => 'Paternity Leave',
        'SH' => 'Special Holiday',
        'LH' => 'Legal Holiday',
        'EDO' => 'Extra Day Off',
        'ML' => 'Maternity Leave',
        'WL' => 'Wadding Leave',
        'AWOL' => 'Absent without Official Leave',
        'OHD' => 'Off Half Day',
        'OS' => 'Offset',
        'UVL' => 'Unscheduled Leave',
        'OFF' => 'Day OFF',
        'custom' => '*Custom'
    );

    return $statuses;
}

function time_to_seconds($time) {
    $minutes = 0;
    $seconds = 0;
    sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);

    return isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
}

function csv_to_array($file_name)
{
    $TF = get_instance();
    $file = fopen($file_name,"r");
    $header = fgetcsv($file);
    $output = array();
    while(! feof($file))
    {
        $data = fgetcsv($file);
        $arr = array();
        for($i = 0; $i<count($data); $i++) {
            $arr[preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[$i])] = $data[$i];
        }
        $output[] = $arr;
    }

    fclose($file);

    return $output;

}

function csv_to_object($file_name)
{
    $file = fopen($file_name,"r");
    $header = fgetcsv($file);
    $output = array();
    while(! feof($file))
    {
        $data = fgetcsv($file);
        $arr = array();
        for($i = 0; $i<count($data); $i++) {
            $arr[$header[$i]] = $data[$i];
        }
        $output[] = (object)$arr;
    }

    fclose($file);

    return $output;

}

function json_output($data) 
{
    $TF = get_instance();
    $TF->output->set_content_type('application/json')->set_output(json_encode($data));
    return;
}

function dateToCal($timestamp) {
    return date('Ymd\THis\Z', strtotime($timestamp));
}

function escapeString($string) {
    return preg_replace('/([\,;])/','\\\$1', $string);
}

function createTimeRangeArray($from=0, $to=86400, $interval=1800) {
	
	$time = mktime(0, 0, 0, 1, 1);
	$arr = array();
	for ($i = $from; $i < $to; $i += $interval) {  // 1800 = half hour, 86400 = one day

		$tm = $time + $i;	
			
        $t = sprintf('%1$s', date('h:i A', $tm));
        $t2 = sprintf('%1$s', date('H:i', $tm));
        
        $arr[$t2] = $t;
    }
    
    return $arr;
}

function createDateRangeArray($strDateFrom, $strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function get_months()
{
	return array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
}

function get_upload_config($upload_id) {
    $TF =& get_instance();

    $query = $TF->db->get_where('upload_prefs', 'upload_id='.$upload_id);

    return $query->row_array();
}

function get_image_url($image_id) {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('files');
    $TF->db->join('upload_prefs', 'files.upload_id=upload_prefs.upload_id');
    $TF->db->where('file_id', $image_id);

    $query = $TF->db->get();
    if ($query->num_rows() > 0) {
        $image = $query->row_array();
        return $image['url'] . $image['file_name'];
    }

    return '/images/noimage.jpg';
}

function form_checkboxes($name, $options, $selected = '') {
	
	$selected = explode('|', $selected);
	
	foreach ($options as $option) {
		
		$checked = '';
		if (in_array($option, $selected)) $checked = 'checked';
		
		echo "<div class='checkbox'><label for='{$name}_2'><input type='checkbox' {$checked} class='{$name}-group' id='{$name}_2' value='{$option}' name='{$name}[]'>{$option}</label></div>";
	}
}

function form_radio_buttons($name, $options, $selected = '') {
	
	$i = 0;
	foreach ($options as $option => $text) {
		
		$checked = '';
		if ($option === $selected) $checked = 'checked="checked"';
		
		echo "<div class='radio'><label for='{$name}_{$i}'><input type='radio' {$checked} class='{$name}-group' id='{$name}_{$i}' value='{$option}' name='{$name}'>{$text}</label></div>";
		
		$i++;
	}
}

function form_toggle_button($name, $id, $options, $selected) {
	
	$selected = $selected === 'y' ? 'Yes' : 'No';
	
	echo '<div class="btn-group btn-toggle">';
	foreach ($options as $option) {
		echo '<button name="'.$name.'-'.strtolower($option).'" data-value="'.$option.'" data-id="'.$id.'" class="btn btn-xs '.$name.($selected === $option ? ' btn-success active' : ' btn-default').'">'.$option.'</option>';
	}
	echo '</div>';
}

function get_available_providers_time($from, $to) {
	
	
	
/*
	$TF->db->select('contacts.*');
    $TF->db->from('user_work_plan_time');
    $TF->db->join('contacts', 'contacts.contact_id = user_work_plan_time.contact_id');
    $TF->db->where('user_work_plan_time.dt BETWEEN \''.$from.'\' AND \''.$to.'\'');
    	
	$q = $TF->db->get();
	
	
	
	echo $TF->db->last_query();
	if ($q->num_rows() > 0) return $q->result_array();
	
	return array();
*/
}

function get_available_providers($from, $locations = array()) {
	
	$TF =& get_instance();
	
	$TF->db->select('contacts.first_name, contacts.last_name, contacts.contact_id, user_work_plan_day.work_code, contacts.position');
    $TF->db->from('user_work_plan_day');
	$TF->db->join('user_work_plan_code', 'user_work_plan_day.work_code = user_work_plan_code.work_plan_cd');
    $TF->db->join('contacts', 'contacts.contact_id = user_work_plan_day.contact_id');
	$TF->db->join('users', 'users.contact_id = contacts.contact_id');
	$TF->db->join('groups', 'groups.group_id = users.group_id');
	$TF->db->where("user_work_plan_day.work_code NOT IN ('OFF', 'VL', 'OS')");
    $TF->db->where('user_work_plan_day.date = \''.$from.'\'');
	
	if ($locations)
	{
		if (!is_array($locations)) $locations = array($locations);
		if ($locations)
			$TF->db->where_in('users.location_id', $locations);
	}

	$TF->db->where('contacts.deleted', 0);
	$TF->db->where('groups.include_in_provider_list = "y"');
	$TF->db->order_by("FIELD(tf_contacts.position, 'Doctor', 'Medical Secretary', 'Therapist', 'HS Therapist', 'Nutritionist', 'Fitness', 'Medical Custodian', '')");
	$query = $TF->db->get();

	if ($query->num_rows() > 0) return $query->result_array();
	
	return array();
}

function get_provider_day_schedule($contact_id, $date) {
    $TF =& get_instance();
    $TF->db->select('MAX(start_date) as s, MIN(end_date) as e');
    $TF->db->from('user_work_plan_time');
    $TF->db->where('contact_id', $contact_id);
    $TF->db->where('DATE_FORMAT(start_date, \'%Y-%m-%d\') = \''.$date.'\'');
    $q = $TF->db->get();

    if ($q->num_rows() > 0) {
        $result = $q->row_array();
        $s = new DateTime($result['s']);
        $e = new DateTime($result['e']);
        $e->add(new DateInterval('PT1M'));
        return '*'.$e->format('g:i A') . ' - ' . $s->format('g:i A');
    }

    return '';
}

function is_past_date($date) {
    $date = new DateTime($date);
    $now = new DateTime();

    if($date < $now) {
        return true;
    }

    return false;
}

function get_time_ago($time_stamp)
{
    $time_difference = strtotime('now') - $time_stamp;

    if ($time_difference >= 60 * 60 * 24 * 365.242199)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
         * This means that the time difference is 1 year or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
         * This means that the time difference is 1 month or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 7)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
         * This means that the time difference is 1 week or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'week');
    }
    elseif ($time_difference >= 60 * 60 * 24)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day
         * This means that the time difference is 1 day or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24, 'day');
    }
    elseif ($time_difference >= 60 * 60)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour
         * This means that the time difference is 1 hour or more
         */
        return get_time_ago_string($time_stamp, 60 * 60, 'hour');
    }
    else
    {
        /*
         * 60 seconds/minute
         * This means that the time difference is a matter of minutes
         */
        return get_time_ago_string($time_stamp, 60, 'minute');
    }
}

function get_time_ago_string($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);

    settype($time_units, 'string');

    if ($time_units === '0')
    {
        return 'less than 1 ' . $time_unit . ' ago';
    }
    elseif ($time_units === '1')
    {
        return '1 ' . $time_unit . ' ago';
    }
    else
    {
        return $time_units . ' ' . $time_unit . 's ago';
    }
}