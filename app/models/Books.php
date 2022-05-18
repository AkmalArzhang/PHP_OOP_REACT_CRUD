<?php

namespace App\Models;

class Books extends ProductsType
{
    protected $tableName = 'books';

    public function insertProductType(array $data)
    {
        $fields = ['product_id', 'weight'];

        return $this->inseryQueryHandler($this->tableName, $fields, $data);
    }
}
