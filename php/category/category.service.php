<?php

require_once(__DIR__."/category.model.php");
require_once(__DIR__."/category.repository.php");

class CategoryService
{
    public static function getOne(int $id) : CategoryModel
    {
        return CategoryRepository::getOne($id);
    }

    public static function getAll(int $limit = -1) : array
    {
        return CategoryRepository::getAll($limit);
    }
}
