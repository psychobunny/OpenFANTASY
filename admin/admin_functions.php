<?PHP

//temporary until we set up in config.
$installed_modules = null;

define('INSTALLED_MODULES', 1);
define('UNINSTALLED_MODULES', 2);
define('ALL_MODULES', 3);

function get_module_basepath() {
	$namespace = get_namespace();
	$module_basepath = "../apps/$namespace";
	return $module_basepath;
}

function uninstall_module($module) {
	remove_module_from_manifest($module);
	delete_module($module);
}

function delete_module($module) {

}

function remove_module_from_manifest() {
	$manifest = get_installed_modules();
}

function get_appKey() {
	return $_SESSION['appKey'];
}

function get_appSecret() {
	return $_SESSION['appSecret'];
}

function get_namespace() {
	return get_appKey() . get_appSecret();
}

function get_installed_modules() {
	global $installed_modules;

	if ($installed_modules != null) return $installed_modules;
	$namespace = get_namespace();

	$manifest = json_decode(file_get_contents("../apps/$namespace/manifest.json"), true);

	$installed_modules = $manifest['modules'];

	return $installed_modules;
}

function get_modules($path=null, $get_installed=INSTALLED_MODULES) {
	$module_basepath = get_module_basepath();

	if ($path == null) $path = $module_basepath;

	$results = scandir($path);
	$modules = array();
	$installed_modules = get_installed_modules();

	foreach ($results as $result) {
	    if ($result === '.' or $result === '..') continue;

	    if (is_dir($path . '/' . $result)) {
	    	if ($get_installed == INSTALLED_MODULES && !in_array($result, $installed_modules)) continue;
	    	else if ($get_installed == UNINSTALLED_MODULES && in_array($result, $installed_modules)) continue;


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
	$namespace = get_namespace();
	if ($handle = opendir("../apps/$namespace/$module/tabs")) {
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
	$namespace = get_namespace();
	return json_decode(file_get_contents("../apps/$namespace/$module/settings/settings.json"), true);
}


function constructAdminFooter($module) {
	$module = get_module_settings($module);

	$url = isset($module['forum_thread']) ? $module['forum_thread'] : 'http://openfantasy.org';


	echo "<hr />
		<p>Always make sure your modules are up to date. Go <a href='$url'>here</a> to check for the latest version.<br />
		If you have any issues, suggestions, or improvements please visit the module's <a href='$url'>forum thread</a> and post your concerns.</p>";
}


?>