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

    public static function getAll(int $limit = -1) : array
    {
        $limitStr = "";

        if($limit != -1)
        {
            $limitStr .= "LIMIT :lim";
        }

        $stm = DBC::getInstance()->prepare(
            "SELECT * FROM `CATEGORIES` ".$limitStr
        );

        if($limit != -1)
        {
            $stm->bindValue(":lim", $limit, PDO::PARAM_INT);
        }

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

