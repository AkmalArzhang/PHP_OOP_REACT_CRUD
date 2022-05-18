<?php

namespace App;

use App\Config\API;
use App\Controller\HomeController;
use App\Controller\ProductController;

class Routes extends API
{
    public function __construct()
    {
        //Define routes
        $this->routes[''] = new HomeController($this->request, $this->id);
        $this->routes['products'] = new ProductController($this->request, $this->id);
    }
}
