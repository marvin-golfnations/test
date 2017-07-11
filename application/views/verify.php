<!doctype html>
<html>
<head>
	
	<?php $this->view('partials/head',array('title'=>$title)); ?>

</head>
<body>
  <div class="container-fluid">
      
<div id="main">
	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default panel-shadow">
				<div class="panel-body">
					<h3><?php echo $title;?></h3>
					<p><?php echo $message;?></p>
				</div>
			</div>

		</div>
	</div>
</div>
  </div>
		
  <?php $this->view('admin/_common/footer_js'); ?>
	
</body>
</html>