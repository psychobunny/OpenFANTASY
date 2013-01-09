<?PHP
	$of_path = 'http://' . $_SERVER['HTTP_HOST'] . str_replace("/install/", "", $_SERVER['REQUEST_URI']) . '/';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OpenFANTASY Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?PHP echo $of_path ?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
    <script src="<?PHP echo $of_path ?>resources/bootstrap/js/bootstrap.min.js"></script>
  </head>

  <body>
  	<?PHP
  	if (file_exists('../config.inc.php') && !isset($_POST['host']))
	{
		echo '<div class="alert alert-error">
				<p><h3>Config detected: It would seem that you have already installed OpenFantasy!</h3>
				<h4>Proceeding may delete all your current data, please make sure you have backed up. We recommend you delete the /install folder on a live environment.</h4></p>
			</div>';
	}
	?>
	
    <div class="container">		
    	<form class="form-signin" method="POST">
    	<?PHP
		if (isset($_POST['host']) && isset($_POST['dbname']) && isset($_POST['user']) && isset($_POST['password']))
		{	
			$dsn = 'mysql:host='.$_POST['host'].';dbname='.$_POST['dbname'];
			$user = $_POST['user'];
			$password = $_POST['password'];

			try {
				$db = new PDO($dsn, $user, $password);
			} catch (Exception $e) {
				echo "<h3>Unable to connect to database!</h3>";
				echo "<p>Please check your database credentials and try again.</p>";
				echo "<p><b>Error:</b><br />{$e->getMessage()}</p>";
				echo "<p><a href='javascript:window.history.go(-1)'>Go Back</a></p>";
				die;
			}
			

			$config = '<?PHP
require("core/Database.php");

const ENVIRONMENT = "DEVELOPMENT";
const OF_PATH = "{OF_PATH}";

$pdo = Database::instance();
$pdo->configMaster("{HOST}", "{DBNAME}", "{USER}", "{PASSWORD}");
?>
			';

			$config = str_replace("{OF_PATH}", $of_path, $config);
			$config = str_replace("{HOST}", $_POST['host'], $config);
			$config = str_replace("{DBNAME}", $_POST['dbname'], $config);
			$config = str_replace("{USER}", $_POST['user'], $config);
			$config = str_replace("{PASSWORD}", $_POST['password'], $config);
			
			$sql = file_get_contents('openfantasy.sql');
			$qr = $db->exec($sql);

			$filename = '../config.inc.php';
			if(is_writable('../'))
			{
				$fp = fopen('../config.inc.php', 'w');
				fwrite($fp, $config);
				fclose($fp);
				echo "<h3>Success!</h3>
				<p class='input-block-level'>You're all set up! Your instance of OpenFANTASY is ready to rock and roll!</p><p>You should delete the <b>/install</b> directory now.</p>";
				echo "<a href='../admin'>Click here to continue</a>";
			}
			else
			{
				echo "<h3>It appears that the folder is not writable.</h3>
				<p class='input-block-level'>Either modify the directory's chmod and retry the installation, or copy and paste the following code into a file called <b>config.inc.php</b> and then upload it to OpenFANTASY's root directory ({$of_path}config.inc.php)";
				echo "<textarea class='input-block-level' style='height: 220px; margin-top: 30px; margin-bottom: 30px; font-family: courier'>" . $config . "</textarea>";
				echo "<p>Be sure to delete the <b>/install</b> directory after you verify that everything is up and ready.</p>";
				echo "<a href='../admin'>Click here to continue</a>";
			}

		}
		else
		{
    	?>
	      

	        <h2 class="form-signin-heading">OpenFANTASY</h2>
	        <h3>Installation</h3>
	        <p>Installing OpenFANTASY on your server is a one-step process. </p><p>If you don't know the values for the following please contact your host, or post on our forums at <a href="http://www.openfantasy.org/" target="_blank">http://www.openfantasy.org/</a></p>
	        <input type="text" name="host" class="input-block-level" style="margin-top:8px"  placeholder="Database Host (ex. localhost, www.mydomain.com)">
	        <input type="text" name="dbname" class="input-block-level" placeholder="Database Name">
	        <input type="text" name="user" class="input-block-level" placeholder="Database Username">
	        <input type="password" name="password" class="input-block-level" placeholder="Database Password">
	        
	        
	        <button style="margin-top:8px" class="input-block-level btn btn-large btn-primary" type="submit">Install</button>
	      
      	<?PHP
			
		}
      	?>
		</form>
    </div>

  </body>
</html>

</body>
</html>
