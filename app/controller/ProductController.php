<?php

namespace App\Controller;

use App\Services\ValidationServices;
use App\Services\APIServices;
use App\Models\ProductsModel;

class ProductController extends APIServices
{
    protected $products, $validation;

    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
        $this->products = new ProductsModel();
        $this->validation = new ValidationServices();
    }

    public function getAll()
    {
        $result = $this->products->all();

        if (!$result) {
            return $this->badRequest400();
        }

        return $this->responseOk($result);
    }

    public function getOne($id)
    {
        $result = $this->products->find($id);

        //If result not found throw not found
        if (!$result) {
            return $this->notFound404();
        }

        return $this->responseOk($result);
    }

    public function create()
    {
        $inputs = (array) json_decode(file_get_contents('php://input'), TRUE);
        $expected = ['SKU', 'name', 'price', 'type'];

        //return $this->responseCreated($inputs);

        //Check if required inputs exist
        if (!$this->validation->input_exists($inputs, $expected)) {
            return $this->invalidInput('Required fields does not exist!');
        }

        //Check if required inputs are not empty
        if (!$this->validation->requiredInput($inputs, $expected)) {
            return $this->invalidInput('Required fields can not be empty!');
        }

        //Check for uniquness of the SKU
        if ($this->products->findSKU($inputs['SKU'])) {
            return $this->invalidInput('SKU Taken!');
        }

        //Process all inputs
        $processed_inputs = $this->validation->process_input($inputs);

        //Insert and return a response
        $result = $this->products->insert($processed_inputs);

        if (!$result) {
            return $this->badRequest400();
        }

        return $this->responseCreated($result);
    }

    //Deleting arrays of IDs
    public function delete()
    {
        $ids = (array) json_decode(file_get_contents('php://input'), TRUE);

        //return $this->responseOk($ids['source']);

        if (!isset($ids['source']) || empty($ids['source'])) {
            return $this->invalidInput('Products IDs and Source does not exist!');
        }

        $result = $this->products->delete($ids['source']);

        //return $this->responseOk($result);

        if (!$result) {
            return $this->badRequest400();
        }

        $result_json = array('deleted_ids' => $result);

        return $this->responseOk($result_json);
    }
}
