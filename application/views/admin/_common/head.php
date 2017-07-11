<meta charset="utf-8" />
<title><?php echo $title;?></title>
<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Mr+De+Haviland" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Raleway:300,100" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

<link rel="stylesheet" href="/css/fullcalendar.min.css">
<link rel="stylesheet" href="/css/scheduler.css">
<link rel="stylesheet" href="/css/bootstrap-select.css">
<link rel="stylesheet" href="/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="/css/multi-select.css">
<link rel="stylesheet" href="/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/js/summernote/summernote.css">
<link rel="stylesheet" href="/css/app.css" type="text/css">
<link rel="stylesheet" href="/css/common.css" type="text/css">
<link rel="stylesheet" href="/css/BootSideMenu.css">

<script src="/js/app.js"></script>		
<script src="/js/jquery-ui.min.js"></script>
<script>
var TF = {};
</script>
<style>
	
.fc-content {
	color: inherit;
}	

.fc-event {
	border: 0;
}

.notifications {
  position: fixed;
}

/* Positioning */ 
.notifications.top-right {
  right: 10px;
  top: 25px;
}

.notifications.top-left {
  left: 10px;
  top: 25px;
}

.notifications.bottom-left {
  left: 10px;
  bottom: 25px;
}

.notifications.bottom-right {
  right: 10px;
  bottom: 25px;
}

/* Notification Element */
.notifications > div {
  position: relative;
  z-index: 9999;
  margin: 5px 0px;
}

.windowSettings {
	background-color: #fff;
	border-radius: 3px;
	box-shadow: 0 0 1px rgba(57, 70, 78, 0.15), 0 20px 55px -8px rgba(57, 70, 78, 0.25);
	display: none;
	margin: 0;
	padding: 15px;
	position: absolute;
	width: 250px;
	z-index: 100;
}
.windowSettings::before {
	border-bottom: 11px solid rgba(57, 70, 78, 0.08);
	border-left: 9px double transparent;
	border-right: 9px double transparent;
	border-style: none double solid;
	content: "";
	display: block;
	height: 0;
	position: absolute;
	right: 9px;
	top: -11px;
	vertical-align: middle;
	width: 0;
}
.windowSettings::after {
	border-bottom: 10px solid #fff;
	border-left: 8px double transparent;
	border-right: 8px double transparent;
	border-style: none double solid;
	content: "";
	display: block;
	height: 0;
	position: absolute;
	right: 10px;
	top: -10px;
	vertical-align: middle;
	width: 0;
}
.windowSettings h3 {
	color: #abb9c2;
	font-size: 11px;
	letter-spacing: 1px;
	margin-bottom: 5px;
	padding: 0;
	text-transform: uppercase;
}
.windowSettings * + h3 {
	margin: 15px 0 5px;
}

.typeahead {
  background-color: #fff;
}

.typeahead:focus {
  border: 1px solid #0097cf;
}

.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-menu {
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
}

.tt-suggestion {
  padding: 3px 20px;
  line-height: 24px;
}

.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}

.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}

.tile_count {
	margin-bottom: 20px;
}

/*.tile_count .tile_stats_count::before {*/
    /*border-left: 2px solid #adb2b5;*/
    /*content: "";*/
    /*height: 65px;*/
    /*left: 0;*/
    /*margin-top: 10px;*/
    /*position: absolute;*/
/*}*/

/*.tile_count .tile_stats_count .count {*/
    /*font-size: 40px;*/
    /*font-weight: 600;*/
    /*line-height: 47px;*/
/*}*/

div#main {
    margin-top: 20px;;
    margin-bottom: 20px;
}

.dataTables_wrapper .dataTables_length {
	float: right;
}

.dataTables_length label {
	text-align: center;
	width: 100%;
}

.dataTables_wrapper .dataTables_paginate {
	float: right;
}

.dataTables_wrapper .dataTables_filter {
	float: right;
}

.ct-label {
	font-size: 1em;
}

.ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
    stroke: #0CC162;
}
.ct-series-b .ct-bar, .ct-series-b .ct-line, .ct-series-b .ct-point, .ct-series-b .ct-slice-donut {
    stroke: #BBBBBB;
}

.fc-cell-text {
	color: #788288 !important;
}

.bootstrap-timepicker-widget {
	z-index: 999 !important;
}

.colorpicker {
    z-index: 1060 !important;
}

.tile_count {

    background-color: #233143;
    padding-top: 20px;
    padding-bottom: 10px;
}

.tile_count .value {
    font-weight: bold;
    color: #fff;
    font-size: 28px;
    line-height: 15px;
}

.tile_count .tile_count_label {
    font-weight:bold;
    font-size: 18px;
}

label.error {
    background-color: #d9534f;
    border-radius: 0.25em;
    color: #fff;
    display: inline;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    padding: 0.2em 0.6em 0.3em;
    text-align: center;
    vertical-align: baseline;
    white-space: nowrap;
}

<?php if (isset($inline_css)) : ?>
<?php foreach ($inline_css as $style) : ?>
<?php
echo implode(',', $style['name'])."\n";	
echo '{'."\n";
echo $style['style']."\n";
echo '}'."\n";
?>
<?php endforeach; ?>
<?php endif; ?>
</style>