<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="/js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/js/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/form-elements.css">
        <link rel="stylesheet" href="/css/style-login.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
	                        <img src="/images/logov2.png" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login to our site</h3>
                            		<p>Enter your username and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
	                            <?php echo form_open('login/submit',array('class'=>'validate', 'name' => 'login-form')); ?>
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="username" placeholder="Username..." class="required form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="required form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn" name="login-button">Submit</button>
			                    <?php echo form_close(); ?>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Javascript -->
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap/js/bootstrap.js"></script>
        <script src="/js/jquery.backstretch.js"></script>
        <script src="/js/jquery.form.js"></script>
        <script src="/js/jquery.validate.js"></script>
        <script type="application/javascript">
            $(document).ready(function(){
//test
                $.backstretch("/images/Calendar.jpg");

                if ($('form[name="login-form"]').length > 0) {
                    $('form[name="login-form"]').validate({
                        submitHandler: function (form) {
                            $(form).ajaxSubmit({
                                dataType: 'json',
                                success: function (data) {
                                    if (data.Error) alert(data.Message);
                                    else window.location = data.Redirect;
                                }
                            });
                        }
                    });
                }
            });
        </script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>