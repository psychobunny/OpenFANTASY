<?php

namespace User;

use OpenFantasy as API,
    Database as DB,
    Analytics,
    //User\Settings as Settings,
    Exception;

/**
 * @uri /user
 * @uri /user/:method
 */
Class User Extends API
{
    public static function getID()
    {
        return isset($_SESSION['userID']) ? $_SESSION['userID'] : 0;
    }

    public static function setID($id)
    {
        $_SESSION['userID'] = doubleval($id);
    }

    /**
     * @method GET
     * @api get
     */
    public function get()
    {
        $userID = isset($_GET['userID']) ? $_GET['userID'] : User::getID();
        $db = DB::instance();
        $data = $db->select('users', array('userID'=>$userID), 1);

        return $this->response($data);   
    }
    
    /**
     * @method POST
     * @api register
     */
    public function register()
    {    
        if (!isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['username']))
        {
            return $this->response(array(
                'code' => 'INVALID_PARAMS',
                'status' => 0
            ));
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            return $this->response(array(
                'code' => 'INVALID_EMAIL',
                'status' => 0
            ));
        }

        if ($this->getUserByEmail($_POST['email']))
        {
            return $this->response(array(
                'code' => 'EMAIL_EXISTS',
                'status' => 0
            ));   
        }
        
        $userlevel = (User::getSettings('validate_email') === true) ? 0 : 1;

        $db = DB::instance();
        $id = $db->insert('users', array(
            'username' => $_POST['username'],
            'password' => md5($_POST['password']),
            'email' => $_POST['email'],
            'userlevel' => $userlevel,
            'created' => time()
        ));

        Analytics::track('registered', 'user', $id);

        return $this->response(array(
            'userID' => $id,
            'status' => 1
        ));
    }

    private function getUserByEmail($email)
    {
        $db = DB::instance();
        $data = $db->select('users', array('email' => $_POST['email']), 1);
        return $data;
    }

    // http://php.net/manual/en/function.sha1.php todo: figure this out
    private function hashSSHA($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 4);
        $hash = base64_encode( sha1($password . $salt, true) . $salt );
        return $hash;
    } 

    /**
     * @method POST
     * @api login
     */
    public function login()
    {
        if (!isset($_POST['password']) || !isset($_POST['email']))
        {
            return $this->response(array(
                'code' => 'INVALID_PARAMS',
                'status' => 0
            ));
        }

        $user = $this->getUserByEmail($_POST['email']);

        if (!$user)
        {
            return $this->response(array(
                'code' => 'USER_DNE',
                'status' => 0,
            ));
        }

        if (md5($_POST['password']) != $user['password'])
        {
             return $this->response(array(
                'code' => 'INVALID_PASSWORD',
                'status' => 0,
            ));
        }

        User::setID($user['userID']);
        Analytics::track('times_logged_in', 'user', $user['userID']);

        return $this->response(array(
            'status' => 1
        ));
    }


    /**
     * @method POST
     * @api logout
     */
    public function logout()
    {
        User::setID(0);
        
        return $this->response(array(
            'method' => 'logout',
            'status' => 1
        ));
    }


    // move these into parent class.
    public static $settings = null;
    public static function getSettings($name = null)
    {
        if (User::$settings == null)
        {
            $settings = file_get_contents('../core/Modules/User/settings/settings.json');
            User::$settings = json_decode($settings, true);
        }

        $settings = User::$settings;
        return ($name == null) ? $settings : $settings[$name];
    }
}
?>