<?PHP
  $admin = is_admin();
  if (!$admin) die('Not Authorized.');
  $username = $admin['username'];  
  
  $modules = get_modules($module_basepath);

  $pages = array(
      'Home' => 'icon-home',
      'Modules' => 'icon-hdd',
    );
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OpenFANTASY - Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?PHP echo OF_PATH ?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?PHP echo OF_PATH ?>resources/qunit/qunit-1.10.0.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .nav.of-top-nav li a {
        color: white;
      }
      .nav.of-top-nav li.active a {
        font-weight: 700;
      }
    </style>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        
    <script src="<?php echo OF_PATH; ?>resources/jquery-1.8.3.min.js"></script>
    <script src="<?PHP echo OF_PATH ?>resources/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../resources/flotr2/lib/bean-min.js"></script>
    <script type="text/javascript" src="../resources/flotr2/lib/underscore-min.js"></script>
  </head>

  <body>

    <script src="<?php echo OF_PATH; ?>resources/qunit/qunit-1.10.0.js"></script>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">OpenFANTASY</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link"><?PHP echo $username; ?></a> &bull; <a href="index.php?logout=1" class="navbar-link">Logout</a>
            </p>
            <ul class="nav of-top-nav">
              <?PHP
              foreach ($pages as $page => $icon)
              {
                $active = (!isset($_GET['module']) && ((isset($_GET['page']) && $_GET['page'] == $page) || !isset($_GET['page']) && $page == 'Home')) ? 'active' : '';
                echo "<li class='$active'><a href='index.php?page=$page'><i class='$icon icon-white'></i> $page</a></li>";
              }
              ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">OpenFANTASY</li>
              <?PHP
              foreach ($pages as $page => $icon)
              {
                $active = (!isset($_GET['module']) && ((isset($_GET['page']) && $_GET['page'] == $page) || !isset($_GET['page']) && $page == 'Home')) ? 'active' : '';
                echo "<li class='$active'><a href='index.php?page=$page'><i class='$icon'></i> $page</a></li>";
              }
              ?>
              <li class="nav-header">Modules</li>
              <?PHP
                $currentParent = null;
                $parents = array();
                foreach ($modules as $module)
                {
                  $active = (isset($_GET['module']) && $_GET['module'] == $module) ? 'active' : '';

                  if (in_array($module, $parents)) continue;

                  if (stristr($module, "/")) {
                    $module = explode('/', $module);
                    $modulePath = $module[0] . '/' . $module[1];     

                    if ($currentParent != $module[0]) {
                      $active = (isset($_GET['module']) && $_GET['module'] == $module[0]) ? 'active' : '';
                      echo "<li class='$active'><a href='index.php?module={$module[0]}'>{$module[0]}</a></li><ul class='nav nav-list'>";
                      $currentParent = $module[0];
                      $active = (isset($_GET['module']) && $_GET['module'] == $modulePath) ? 'active' : '';
                      array_push($parents, $currentParent);
                    } else {
                      $active = (isset($_GET['module']) && $_GET['module'] == $modulePath) ? 'active' : '';
                    }
                                   
                    $module = $module[1];

                    echo "<li class='$active'><a href='index.php?module=$modulePath'>$module</a></li>";
                  } else {
                    if ($currentParent != null) {
                      echo "</ul>";
                      $currentParent = null;
                    }
                    echo "<li class='$active'><a href='index.php?module=$module'>$module</a></li>";
                  }
                  
                }
              ?>              
            </ul>
          </div><!--/.well -->
        </div><!--/span-->