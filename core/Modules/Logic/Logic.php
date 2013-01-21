<?php

namespace Logic;

use OpenFantasy as API,
    Database as DB,
    Analytics,
    Exception,
    User\User as User;

/**
 * @uri /logic
 * @uri /logic/:method
 */
Class Logic Extends API
{
    /**
     * @method GET
     * @api
     */
    public function get()
    {
        $userID = (isset($_GET['anonymous']) && $_GET['anonymous'] == true) ? (isset($_GET['userID']) ? $_GET['userID'] : User::getID()) : 0;
        $variable = $_GET['variable'];

        $db = DB::getInstance();
        $value = $db->select('logic', array(
                'userID' => $userID,
                'variable' => $variable
            ), 1);

        return $this->response(array('status'=>1, 'value'=>"Hello World!"));
    }
    
    /**
     * @method GET
     * @api name
     */
    public function set()
    {    
        $userID = (isset($_GET['anonymous']) && $_GET['anonymous'] == true) ? (isset($_GET['userID']) ? $_GET['userID'] : User::getID()) : 0;
        $variable = $_GET['variable'];
        $value = $_GET['value'];
        
        if (isset($_GET['track']) && $_GET['track'] == true)
        {
            Analytics::track($variable, 'Logic', $userID);
        }
        
        return $this->response(array('status'=>1, 'value'=>$value));
    }


    public function add()
    {

    }

    public function subtract()
    {
        
    }

}
?>