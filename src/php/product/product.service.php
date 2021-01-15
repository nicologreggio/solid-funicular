<?php

require_once(__DIR__."/product.model.php");
require_once(__DIR__."/product.repository.php");

class ProductService
{
    public static function getProductDetails(int $id) : ?ProductModel
    {
        return ProductRepository::getOne($id);
    }

    public static function getProductsList(array $search, int $limit = 25) : array
    {
        return ProductRepository::getAllWhere($search, $limit);
    }

    public static function getProductsListCount(array $search) : int
    {
        return ProductRepository::countAllWhere($search);
    }

    public static function getProductsWhereCategory(int $categoryId, int $page, int $limit = 25) : array
    {
        return ProductRepository::getAllWhereCategory($categoryId, $page, $limit);
    } 

    public static function getProductsWhereCategoryCount(int $categoryId, int $page, int $limit = 25) : array
    {
        return ProductRepository::getAllWhereCategory($categoryId, $page, $limit);
    } 
}
