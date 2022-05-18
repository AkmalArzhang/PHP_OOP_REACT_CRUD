<?php

namespace App\Models;

abstract class Products
{
    abstract public function all();

    abstract public function find(int $id);

    abstract public function insert(array $data);

    abstract public function delete(array $ids);
}
