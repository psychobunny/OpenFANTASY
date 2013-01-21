<?php
/*
* WARNING: THIS CLASS SHOULD NEVER BE DEPLOYED ON A LIVE ENVIRONMENT
*  attaching @development prevents the method from running if the ENVIRONMENT is set higher than DEV
*/

namespace User;

use OpenFantasy as API;
use Database as DB;

/**
 * @uri /tools
 * @uri /tools/:method
 */
Class Tools Extends API
{

    /**
     * @method POST
     * @api truncate
     * @development
     */
    public function truncate()
    {        
        $db = DB::instance();
        $data = $db->query("DELETE FROM {$_POST['table']}");

        return API::Response(200, $data);   
    }


}
?>