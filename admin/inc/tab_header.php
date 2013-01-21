<?PHP
	if (!is_admin()) die();

	$modulePath = $_GET['module'];	

	$tabs = array('home.php');

	$tabs = array_merge($tabs, get_tabs($modulePath));	
	
	$selectedtab = (isset($_GET['tab'])) ? strtolower($_GET['tab']) : 'home';
?>
<div class="span9">

    <ul class="nav nav-pills">
    	<?PHP

    	foreach ($tabs as $tab)
    	{    		
    		$tab = str_replace('.php', '', $tab);
    		$active = (strtolower($selectedtab) === strtolower($tab)) ? 'active' : '';
    		$formatted_tab = ucwords($tab);
    		echo "<li class='$active'><a href='index.php?module={$_GET['module']}&tab=$tab'>$formatted_tab</a></li>";
    	}
    	?>
    </ul>

<?PHP
	$basePath = get_module_basepath();
	include("$basePath/$modulePath/tabs/$selectedtab.php");
	if ($selectedtab == "home")
	{
		constructAdminFooter($modulePath);
	}


?>


</div>