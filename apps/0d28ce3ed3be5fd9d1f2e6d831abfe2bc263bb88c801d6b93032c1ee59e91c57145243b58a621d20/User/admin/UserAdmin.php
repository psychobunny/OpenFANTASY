<?php

namespace UserAdmin;

use OpenFantasy as API,
    User\User as User,
    Database as DB;

/**
 * @uri /user/admin
 * @uri /user/admin/:method
 */
Class UserAdmin Extends API
{

    /**
     * @method GET
     * @api get
     */
    public function get()
    {
        $db = DB::instance();
        $data = $db->select('users', array('userID'=>$_GET['userID']));

        return $this->response($data);   
    }


    /**
     * @method POST
     * @api edit
     */
    public function edit()
    {
        return $this->response(array(
            'data' => $this->request->data,
            'status' => 1
        ));
    }


    /**
     * @method POST
     * @api delete
     * We set the userlevel to -1 and disable the user instead of straight up deleting them from the db.
     * During maintenance we can remove the user permanently along with the rest of their belongings.
     */
    public function delete()
    {
        $db = DB::instance();
        //$data = $db->delete('users', array('userID' => $_POST['userID']));
        $data = $db->update('users', array('userlevel' => -1), array('userID' => $_POST['userID']));

        return $this->response(array(
            'status' => $data
        ));
    }

}
?>