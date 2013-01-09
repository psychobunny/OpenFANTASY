<?php

use API\Resource,
    API\Response,
    API\ConditionException;

Class OpenFantasy extends Resource
{

    
	protected function response($response, $code = 200)
	{
		return new Response ($code, $response);
	}

    protected function development()
    {
        if (ENVIRONMENT != 'DEVELOPMENT')
        {
            throw new ConditionException();
        }        
    }

	protected function api($method = null)
    {
        if (strtolower($method) != strtolower($this->method)) throw new ConditionException;

        $this->before(function ($request) {
            if ($request->contentType == "application/json") {
                $request->data = json_decode($request->data);
            }
        });

        $this->after(function ($response) {
            $response->contentType = "application/json";
            if (isset($_GET['jsonp'])) {
                $response->body = $_GET['jsonp'].'('.json_encode($response->body).');';
            } else {
                $response->body = json_encode($response->body);
            }
        });
    }

    protected static function getSettings()
    {
        return json_decode(file_get_contents('settings.json'));
    }
}


?>