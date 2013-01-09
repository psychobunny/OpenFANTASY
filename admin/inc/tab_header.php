<?PHP
	if (!is_admin()) die();

	$modulePath = $_GET['module'];	

	$tabs = array('home.php');
	if ($handle = opendir("../core/Modules/$modulePath/tabs")) {
	    while (false !== ($entry = readdir($handle))) {
	        if (stristr($entry, '.php') && $entry != "Admin.php" && $entry != "home.php") {
	            array_push($tabs, $entry);
	        }
	    }
	    closedir($handle);
	}
	
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
	include("../core/Modules/$modulePath/tabs/$selectedtab.php");


?>


</div>