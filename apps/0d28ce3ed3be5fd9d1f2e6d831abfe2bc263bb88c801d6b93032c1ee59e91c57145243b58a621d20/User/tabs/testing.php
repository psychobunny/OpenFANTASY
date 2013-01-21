	<h1 id="qunit-header">User Unit Testing</h1>  
	<div id="qunit"></div>
	<script type="text/javascript">
		var OF_PATH = '<?php echo OF_PATH; ?>',
			APP_PATH = '<?php echo $_SESSION["appPath"]; ?>',
			APP_KEY = '<?php echo $_SESSION["appKey"]; ?>',
			APP_SECRET = '<?php echo $_SESSION["appSecret"]; ?>';
	</script>	
	<script src="<?PHP echo $_SESSION["appPath"]; ?>User/tabs/js/tests.js"></script>
