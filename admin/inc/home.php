<?PHP
  if (!is_admin()) die('Not Authorized.');

  $appInfo = $db->select('apps', array(      
      'namespace' => $_SESSION['namespace']
  ), 1);
  $_SESSION['appKey'] = $appInfo['appKey'];
  $_SESSION['appSecret'] = $appInfo['appSecret'];

  $_SESSION['appPath'] = '../apps/' . $appInfo['appKey'] . $appInfo['appSecret'] . '/';
?>

<div class="span9">
  <div class="hero-unit">
    <h1>OpenFANTASY Control Panel</h1>
    <p>
      Thank you for choosing OpenFANTASY! Don't forget to visit our forums for help and to contribute to the community.
      Please help us develop more modules!
    </p>
    <p>
      <a href="http://openfantasy.org/forum" class="btn btn-primary btn-large" target="_blank">Visit Forum &raquo;</a>
      <a href="http://openfantasy.org/forum/viewforum.php?f=3" class="btn btn-primary btn-large" target="_blank">Download Modules &raquo;</a>
      <a href="http://openfantasy.org/forum/viewforum.php?f=3" class="btn btn-primary btn-large" target="_blank">Customize &raquo;</a>
    </p>
  </div>    

  <div class="well">
    <h4>Use these when making API calls.</h4>
    <strong>App Key</strong>: <?PHP echo $appInfo['appKey']; ?><br />
    <strong>App Secret</strong>: <?PHP echo $appInfo['appSecret']; ?>
  </div>
</div><!--/span-->
