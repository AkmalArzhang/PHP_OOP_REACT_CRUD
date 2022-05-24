<?php

namespace App\Models;

use App\Models\ProductsType;
use App\Services\QueryHandler;

class ProductsModel extends Products
{
    protected $productAvailableTypes;

    public function __construct()
    {
        $this->productAvailableTypes = array(
            "dvd_disc" => new DVD(),
            "books" => new Books(),
            "furnitures" => new Furniture()
        );
    }


    //Get all data
    public function all()
    {
        $data = new QueryHandler();
        $data->tableName = 'products';
        $data->fields = [
            'products.id', 'products.SKU', 'products.name', 'products.price', 'products.type',
            'dvd_disc.size',
            'books.weight',
            'furnitures.height', 'furnitures.length', 'furnitures.width'
        ];
        //$data->where = array(['products.id', '=', 52], ['products.type', '=', 'books']);
        $data->orderBy = ['products.id', 'DESC'];
        $data->join = array(
            ['LEFT JOIN', 'books', 'products.id', 'books.product_id'],
            ['LEFT JOIN', 'furnitures', 'products.id', 'furnitures.product_id'],
            ['LEFT JOIN', 'dvd_disc', 'products.id', 'dvd_disc.product_id']
        );

        return $data->get('all');
    }

    //Find a specific ID
    public function find(int $id)
    {
        $data = new QueryHandler();
        $data->tableName = 'products';
        $data->fields = [
            'products.id', 'products.SKU', 'products.name', 'products.price', 'products.type',
            'dvd_disc.size',
            'books.weight',
            'furnitures.height', 'furnitures.length', 'furnitures.width'
        ];
        $data->where = array(['products.id', '=', $id]);
        $data->join = array(
            ['LEFT JOIN', 'books', 'products.id', 'books.product_id'],
            ['LEFT JOIN', 'furnitures', 'products.id', 'furnitures.product_id'],
            ['LEFT JOIN', 'dvd_disc', 'products.id', 'dvd_disc.product_id']
        );

        return $data->get('first');
    }

    //Handling insert
    public function insert(array $data)
    {
        //Checking product type, csonidering position: 3
        $productType = $data[3];

        //Table Fields
        $fields = ['SKU', 'name', 'price', 'type'];

        if (!$this->checkProductType($productType)) {
            return false;
        }

        //Get data for the main table
        $productTableData = array_slice($data, 0, count($fields));

        $queryHandler = new QueryHandler();
        $queryHandler->tableName = 'products';
        $queryHandler->fields = $fields;
        $queryHandler->data = $productTableData;

        $insertProduct = $queryHandler->insert();

        if (!$insertProduct) {
            return false;
        }

        //Extract product type fields and data
        $productTypeData = array_slice($data, count($fields), count($data) - count($fields));

        //Add product_id at the beginning of the array
        array_unshift($productTypeData, $insertProduct);

        //Get product class name
        $className = $this->productAvailableTypes[$productType];

        //Insert Product Type Data
        $this->insertProductType($className, $productTypeData);

        //Return the inserted product
        return $this->find($insertProduct);
    }

    //Delete model
    public function delete(array $ids)
    {
        $queryHandler = new QueryHandler();
        $queryHandler->tableName = 'products';
        $queryHandler->to_delete = $ids;
        return $queryHandler->delete();
    }

    //Find a specific SKU
    public function findSKU(string $sku)
    {
        $data = new QueryHandler();
        $data->tableName = 'products';
        $data->fields = ['*'];
        $data->where = array(['products.SKU', '=', $sku]);

        return $data->get('first');
    }

    //Check if the type exists within data
    public function checkProductType(string $type)
    {
        if (!array_key_exists($type, $this->productAvailableTypes)) {
            return false;
        }

        return true;
    }

    //Call the required product type class
    public function insertProductType(ProductsType $productType, $data)
    {
        $productType->insertProductType($data);
    }
}
