<?PHP

//temporary until we set up in config.
$module_basepath = '../core/Modules';
$installed_modules = null;

define('INSTALLED', 1);
define('UNINSTALLED', 2);
define('ALL', 3);

function get_module_basepath() {
	global $module_basepath;
	return $module_basepath;
}


function remove_module_from_manifest() {
	$manifest = get_installed_modules();
}

function get_installed_modules() {
	global $installed_modules;

	if ($installed_modules != null) return $installed_modules;

	$manifest = json_decode(file_get_contents('../manifest.json'), true);

	$installed_modules = $manifest['modules'];

	return $installed_modules;
}

function get_modules($path=null, $get_installed=INSTALLED) {
	global $module_basepath;

	if ($path == null) $path = $module_basepath;

	$results = scandir($path);
	$modules = array();
	$installed_modules = get_installed_modules();

	foreach ($results as $result) {
	    if ($result === '.' or $result === '..') continue;

	    if (is_dir($path . '/' . $result)) {
	    	if ($get_installed == INSTALLED && !in_array($result, $installed_modules)) continue;
	    	else if ($get_installed == UNINSTALLED && in_array($result, $installed_modules)) continue;


	    	$modules = array_merge($modules, get_modules($path . '/' . $result, $get_installed));
	        if (file_exists($path . '/' . $result . '/settings/settings.json'))
	        {              
	          array_push($modules, str_replace($module_basepath .'/', '', $path . '/' . $result));
	        }

	    }
	}
	return $modules;
}

function get_tabs($module) {
	$tabs = array();
	if ($handle = opendir("../core/Modules/$module/tabs")) {
	    while (false !== ($entry = readdir($handle))) {
	        if (stristr($entry, '.php') && $entry != "Admin.php" && $entry != "home.php") {
	            array_push($tabs, $entry);
	        }
	    }
	    closedir($handle);
	}	
	return $tabs;
}
function get_module_settings($module) {
	return json_decode(file_get_contents("../core/Modules/$module/settings/settings.json"), true);
}


function constructAdminFooter($module) {
	$module = get_module_settings($module);

	$url = isset($module['forum_thread']) ? $module['forum_thread'] : 'http://openfantasy.org';


	echo "<hr />
		<p>Always make sure your modules are up to date. Go <a href='$url'>here</a> to check for the latest version.<br />
		If you have any issues, suggestions, or improvements please visit the module's <a href='$url'>forum thread</a> and post your concerns.</p>";
}
?>