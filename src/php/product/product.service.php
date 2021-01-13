<?php

require_once(__DIR__."/product.model.php");
require_once(__DIR__."/product.repository.php");

class ProductService
{
    public static function getProductDetails(int $id)
    {
        return ProductRepository::getOne($id);
    }

    public static function getProductsList(array $search, int $limit = 25)
    {
        return ProductRepository::getAllWhere($search, $limit);
    }
}

var_dump(ProductService::getProductsList(["name" => "p", "page" => 1]));
