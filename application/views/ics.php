BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
DTSTART:<?php echo dateToCal($event['start']) ?>
DTEND:<?php echo dateToCal($event['end']) ?>
DTSTAMP:<?php echo dateToCal(time()) ?>
UID:<?php echo uniqid() ?>
LOCATION:<?php echo escapeString($event['facility_name']) ?>
DESCRIPTION:<?php echo escapeString($event['event_title'] ? $event['event_title'] : $event['item_name']) ?>
URL;VALUE=URI:<?php echo escapeString(site_url()) ?>
STATUS:CONFIRMED
SUMMARY:<?php echo escapeString($summary) ?>
END:VEVENT
END:VCALENDAR