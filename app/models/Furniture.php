<?php

namespace App\Models;

class Furniture extends ProductsType
{
    protected $tableName = 'furnitures';

    public function insertProductType(array $data)
    {
        $fields = ['product_id', 'height', 'width', 'length'];

        return $this->inseryQueryHandler($this->tableName, $fields, $data);
    }
}
