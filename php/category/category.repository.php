<?php

require_once(__DIR__."/../../DBC.php");

class CategoryRepository
{
    public static function getOne(int $id) : CategoryModel
    {
        $stm = DBC::getInstance()->prepare(
            "SELECT * FROM `CATEGORIES` WHERE _ID = ?"
        );

        $stm->execute([$id]);

        $category = $stm->fetch();

        return CategoryModel::instanceFromCategory($category);
    }

    public static function getAll() : array
    {
        $stm = DBC::getInstance()->prepare(
            "SELECT * FROM `CATEGORIES`"
        );

        $stm->execute();

        $categories = $stm->fetchAll();

        $categoriesModel = array();

        foreach($categories as $category)
        {
            $categoriesModel[] = CategoryModel::instanceFromCategory($category);
        }

        return $categoriesModel;
    }
}

