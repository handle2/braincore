<?php

namespace Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Modules\BusinessLogic\Models as Models;
use Modules\BusinessLogic\Frontend as Frontend;

class ControllerBase extends Controller
{
    public function initialize()
    {
        
    }

    protected function api($code, $data)
    {

        $this->response->setStatusCode($code);
        $this->response->setContentType("application/json; charset=UTF-8");
        $this->response->setContent(json_encode($data));

        return $this->response;

    }
}
