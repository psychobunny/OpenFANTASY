<?php

namespace OpenFantasy;

use OpenFantasy as API;
use Database as DB;

/**
 * @uri /openfantasy
 * @uri /openfantasy/:method
 */
Class OpenFantasy Extends API
{

    /**
     * @method GET
     * @api authenticate
     */
    public function authenticate()
    {
        return $this->response(array('status'=>isset($_SESSION['appKey']) ? 1 : 0));
    }


}
?>