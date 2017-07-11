<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<!-- Brain Admin Dashboard Template -->
<link href='http://fonts.googleapis.com/css?family=Lora:400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/typeahead.css">
<link rel="stylesheet" href="/js/summernote/summernote.css">
<link rel="stylesheet" href="/css/fullcalendar.min.css">
<link rel="stylesheet" href="/css/scheduler.css">
<link rel="stylesheet" href="/css/colorPicker.css">
<link rel="stylesheet" href="/css/bootstrap-select.css">
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
<link rel="stylesheet" href="/css/bootstrap-colorselector.css">
<link rel="stylesheet" href="/css/datepicker.css">
<link rel="stylesheet" href="/css/morris.css">
<link rel="stylesheet" href="/css/chartist.css">
<link rel="stylesheet" href="/css/style.css">

<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php if (isset($inline_css) && $inline_css) : ?>
<!-- Inline CSS -->
<style>
	<?php foreach ($inline_css as $style) : ?>
	<?php echo implode(', '."\n", $style['name']);?> {
		<?php echo $style['style'];?>
	}
	<?php endforeach ?>
</style>
<?php endif; ?>