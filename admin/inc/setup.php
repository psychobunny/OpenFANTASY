<?PHP
	use Database as DB;

	if ($admin_created !== false) die();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OpenFANTASY - Create Administrator Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?PHP echo OF_PATH ?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {        
        background-color: #f5f5f5;
      }

      .form-signin {      	
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        margin-top: 40px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?PHP echo OF_PATH ?>resources/bootstrap/js/bootstrap.min.js"></script>
  </head>

  <body>
	
    <div class="container">		
    	<form class="form-signin" method="POST">
    	<?PHP
		if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
	        $db = DB::instance();
	        $id = $db->insert('users', array(
	            'username' => $_POST['username'],
	            'password' => md5($_POST['password']),
	            'email' => $_POST['email'],
	            'userlevel' => 10,
	            'created' => time()
	        ));

	        $_SESSION['adminID'] = $id;
	        // todo: use the API for the above later.

			echo "<h3>Account {$_POST['username']} created!</h3>";
			echo "<p>Thanks! At this point you're free to start managing your instance of OpenFANTASY.</p><p>You can start making a connection to your API and test calls right away. If you need help or would like some sample code, please visit our forums at <a href='http://openfantasy.org'>http://openfantasy.org</a>.</p>";
			echo "<a href='../admin'>Click here to continue</a>";

		}
		else
		{
    	?>
	        <h2 class="form-signin-heading">OpenFANTASY</h2>
	        <h3>Create Administrator Account</h3>
	        <p>OK, so we lied. There's just one more step - create your account and you'll be able to start managing your instance of OpenFANTASY right away!</p>
	        <input type="text" name="username" class="input-block-level" style="margin-top:8px"  placeholder="Username">
	        <input type="password" name="password" class="input-block-level" placeholder="Password">
	        <input type="text" name="email" class="input-block-level" placeholder="Email">
	        <?PHP
	        if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	        {
	        	?>
	        	<div class="alert alert-error">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    Invalid Email.
			    </div>
			    <?PHP
	        }
	        ?>
	        
	        <button style="margin-top:8px" class="input-block-level btn btn-large btn-primary" type="submit">Create Account</button>
	      
      	<?PHP
			
		}
      	?>
		</form>
    </div>

  </body>
</html>

</body>
</html>