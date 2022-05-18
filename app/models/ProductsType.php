<?php

namespace App\Models;

use App\Services\QueryHandler;

abstract class ProductsType
{
    protected $tableName;

    abstract public function insertProductType(array $data);

    public function inseryQueryHandler(string $tableName, array $fields, array $data)
    {
        $queryHandler = new QueryHandler();

        $queryHandler->tableName = $tableName;
        $queryHandler->fields = $fields;
        $queryHandler->data = $data;

        $queryHandler->insert();
    }
}
