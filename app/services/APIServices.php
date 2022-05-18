<?php

namespace App\Services;

use App\Config\API;

abstract class APIServices extends API
{
    public function processRequest()
    {
        switch ($this->request) {
            case 'GET':
                if ($this->id) {
                    $response = $this->getOne($this->id);
                } else {
                    $response = $this->getAll();
                };
                break;
            case 'POST':
                /* Creating the delete request as a POST request,
                   in order to work around server rejection of DELETE request.
                   You can still use DELETE request directly if the hosted server allows to.
                */
                if ($this->id) {
                    $response = $this->delete();
                } else {
                    $response = $this->create();
                };
                break;
            case 'DELETE':
                $response = $this->delete();
                break;
            default:
                $response = $this->api->notFound404();
                break;
        }

        $this->headerResponse($response);
    }


    //Mandatory abstract methods for APIServices extentsion
    abstract public function getOne($id);

    abstract public function getAll();

    abstract public function create();

    abstract public function delete();
}
