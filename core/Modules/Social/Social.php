<?php

namespace Social;

require 'inc/facebook.php';



use OpenFantasy as API,
    Database as DB,
    Analytics,
    Exception,
    Facebook,
    User\User as User;

/**
 * @uri /facebook
 * @uri /facebook/:method
 */
Class Social Extends API
{
    /**
     * @method GET
     * @api connect
     */
    public function connect()
    {
      $userID = User::getID();

      $appID = Social::getSettings('appID');
      $appSecret = Social::getSettings('appSecret');

      $facebook = new Facebook(array(
        'appId'  => $appID,
        'secret' => $appSecret,
      ));

      // Get User ID
      $user = $facebook->getUser();

      if ($user)
      {
        try {
          $user_profile = $facebook->api('/me');
        } catch (FacebookApiException $e) {
          $user = null;
        }
        $db = DB::instance();
        $data = $db->select('facebook', array('facebookID'=>$user_profile['id']));

        //
        if (count($data)==0)
        {

          $db->insert('facebook', array(
            'userID' => $userID,
            'facebookID' => $user_profile['id']
            ));
        }

        die('<script>window.close()</script>');
      }
      else
      {
        $params = array(
          'redirect_uri' => 'http://localhost/openfantasy/web/facebook/connect',
          'scope'=>'email');

        die('<script>top.location.href="'.$facebook->getLoginUrl($params).'";</script>');
      }
    }
    
    /**
     * @method POST
     * @api name
     */
    public function name()
    {    
        // if not logged in, getID is 0 (anonymous)
        //Analytics::track('saidhello', 'HelloWorld', User::getID());
        return $this->response(array('status'=>1, 'message'=>"Hello " . $_POST['myName'] . "!"));
    } 


    // move these into parent class.
    public static $settings = null;
    public static function getSettings($name = null)
    {
        if (User::$settings == null)
        {
            $settings = file_get_contents('../core/Modules/Social/settings/settings.json');
            User::$settings = json_decode($settings, true);
        }

        $settings = User::$settings;
        return ($name == null) ? $settings : $settings[$name]['value'];
    }

}
?>