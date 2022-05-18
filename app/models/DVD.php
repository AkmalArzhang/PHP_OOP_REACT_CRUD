<?php

namespace App\Models;

class DVD extends ProductsType
{
    protected $tableName = 'dvd_disc';

    public function insertProductType(array $data)
    {
        $fields = ['product_id', 'size'];

        return $this->inseryQueryHandler($this->tableName, $fields, $data);
    }
}
