<?php

namespace App\Controller;

use App\Services\APIServices;

class HomeController extends APIServices
{
    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function getAll()
    {
        return $this->responseOk('Welcome to products API');
    }

    public function getOne($id)
    {
    }

    public function create()
    {
    }

    //Deleting arrays of IDs
    public function delete()
    {
    }
}
