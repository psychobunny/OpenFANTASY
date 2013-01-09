<?PHP
	use Database as DB;

    if (isset($_POST['username']) && isset($_POST['password']))
    {
      $db = DB::instance();
      $data = $db->select('users', array('username' => $_POST['username']), 1);
      
      if (count($data) > 0 && md5($_POST['password']) === $data['password'] && $data['userlevel'] == 10)
      {
        $_SESSION['adminID'] = $data['userID'];
        $admin_path = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        header("Location: $admin_path") ;
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OpenFANTASY - Login to Control Panel</title>
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
	        <h2 class="form-signin-heading">OpenFANTASY</h2>
	        <h3>Login to Control Panel</h3>
	        <input type="text" name="username" class="input-block-level" style="margin-top:8px"  placeholder="Username">
	        <input type="password" name="password" class="input-block-level" placeholder="Password">
	        <button style="margin-top:8px" class="input-block-level btn btn-large btn-primary" type="submit">Login</button>
		  </form>
    </div>

  </body>
</html>

</body>
</html>