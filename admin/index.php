<?PHP
session_start();
use Database as DB;

if (!file_exists('../config.inc.php'))
{
	$install_path = 'http://' . $_SERVER['HTTP_HOST'] . str_replace("/admin/", "", $_SERVER['REQUEST_URI']) . '/install/';
	header("Location: $install_path") ;
}

require ('../config.inc.php');


$db = DB::instance();
$data = $db->select('users', array('userID'=>1));
$admin_created = (count($data)) ? true : false;


if (!$admin_created)
{
	include 'inc/setup.php';
	die();
}

if (isset($_GET['logout']))
{
	$_SESSION['adminID'] = 0;
    $admin_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}



function is_admin()
{
	if (!isset($_SESSION['adminID'])) return false;

	$userID = $_SESSION['adminID'];
	$db = DB::instance();
	$data = $db->select('users', array('userID'=>$userID), 1);
	if (count($data) === 0) return false;

	if ($data['userlevel'] < 10) return false;
	else return $data;
}


if (!is_admin())
{
	include 'inc/login.php';
	die();
}

include 'inc/header.php';

$page = (isset($_GET['page'])) ? strtolower($_GET['page']) : 'home';

if (isset($_GET['module']))
{
	include "inc/tab_header.php";
}
else
{
	include "inc/$page.php";
}

include 'inc/footer.php';
?>

