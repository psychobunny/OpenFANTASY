<style type="text/css">
.anchor { 
  display: block; 
  content: " "; 
  margin-top: -80px;   
  position: absolute;
  visibility: hidden;

}
</style>

<div class='span9'>
	<h1>Uninstalled Modules</h1>
	<?PHP	
		$modules = get_modules(null, UNINSTALLED_MODULES);
		$module_basepath = get_module_basepath();

		echo '<ul class="nav nav-pills">';
		foreach ($modules as $module) {
			if (stristr($module, '/')) {
				$module = explode('/', $module);
				$module = $module[1];	
			}			

			echo "<li ><a href='#$module'>$module</a></li>";
		}
		echo '</ul>';

		foreach ($modules as $module) {
			//echo "$module";
			echo "<a class='anchor' id='$module'>$module</a><div class='well'>";
			include $module_basepath . '/' . $module . '/tabs/home.php';
			echo "</div>";
		}
	?>
</div>