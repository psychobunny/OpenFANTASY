<?php

namespace HelloWorld;

use OpenFantasy as API,
    Database as DB,
    Analytics,
    Exception,
    User\User as User;

/**
 * @uri /hello
 * @uri /hello/:method
 */
Class HelloWorld Extends API
{
    /**
     * @method GET
     * @api
     */
    public function hello()
    {
        Analytics::track('saidhello', 'HelloWorld', 0);
        return $this->response(array('status'=>1, 'message'=>"Hello World!"));
    }
    
    /**
     * @method GET
     * @api name
     */
    public function name()
    {    
        // if not logged in, getID is 0 (anonymous)
        Analytics::track('saidhello', 'HelloWorld', User::getID());
        return $this->response(array('status'=>1, 'message'=>"Hello " . $_GET['myName'] . "!"));
    } 

}
?>