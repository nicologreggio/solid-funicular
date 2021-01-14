<?php

require_once(__DIR__."/../../../DBC.php");
require_once(__DIR__."/product.service.php");
require_once(__DIR__."/../material/material.service.php");


class ProductRepository
{
    public static function getOne(int $id) : ?ProductModel
    {
        $stm = DBC::getInstance()->prepare(
            "SELECT `PRODUCTS`._ID, _NAME, _DESCRIPTION, _METADESCRIPTION, _DIMENSIONS, _AGE, _MAIN_IMAGE, _MAIN_IMAGE_DESCRIPTION, NAME_CATEGORY as _CATEGORY 
            FROM `PRODUCTS` join (select _ID, _NAME as NAME_CATEGORY from CATEGORIES) c on c._ID = _CATEGORY 
            where `PRODUCTS`._ID = ?"
        );

        $stm->execute([$id]);

        $product = $stm->fetch();

        if($product)
        {
            $product = ProductModel::instanceFromProduct($product);
            
            $product->addMaterials(MaterialService::getMaterialsReleatedToProduct($id));
            
            return $product;
        }
        else
        {
            return null;
        }
    }

    public static function getAllWhere(array $search, int $limit) : array
    {
        $page = $search["page"];
        $name = $search["name"];
        $category = $search["category"];

        $filterCategory = self::filterForCategory($category);
        $filterMaterials = self::filterForMaterials($search["materials"]);

        $stm = DBC::getInstance()->prepare(
            "SELECT `PRODUCTS`._ID, `PRODUCTS`._NAME, `PRODUCTS`._DESCRIPTION, `PRODUCTS`._METADESCRIPTION, 
            _MAIN_IMAGE, _MAIN_IMAGE_DESCRIPTION, NAME_CATEGORY as _CATEGORY 
            FROM (`PRODUCTS` inner join (select _ID, _NAME as NAME_CATEGORY from CATEGORIES {$filterCategory}) c 
                on c._ID = _CATEGORY)
            inner join (select * from PRODUCT_MATERIAL join MATERIALS on PRODUCT_MATERIAL._MATERIAL_ID = MATERIALS._ID {$filterMaterials} group by PRODUCT_MATERIAL._PRODUCT_ID) pm 
                on pm._PRODUCT_ID = PRODUCTS._ID
            WHERE `PRODUCTS`._NAME like :name LIMIT :lim OFFSET :of
            "
        );

        $stm->bindValue(":name", "%{$name}%", PDO::PARAM_STR);
        if(!empty($category))
        {
            $stm->bindValue(":category", $category, PDO::PARAM_STR);
        }
        $stm->bindValue(":lim", $limit, PDO::PARAM_INT);
        $stm->bindValue(":of", ($limit * ($page - 1)), PDO::PARAM_INT);

        $stm->execute();

        $products = $stm->fetchAll();
        
        $productsModel = [];

        foreach($products as $product)
        {
            $productModel = ProductModel::instanceFromProduct($product);
            $productModel->addMaterials(MaterialService::getMaterialsReleatedToProduct($productModel->getId()));
            $productsModel[] = $productModel;
        }

        return $productsModel;
    }

    private static function filterForMaterials(?array $materials) : string
    {
        $filterMaterials = "";

        if($materials && !empty($materials))
        {
            $filterMaterials .= "WHERE ";
            
            foreach($materials as $index => $material)
            {
                $filterMaterials .= "`MATERIALS`._NAME = ".$material;

                if($index + 1 != count($materials)) $filterMaterials .= " OR ";
            }
        }

        return $filterMaterials;
    }

    private static function filterForCategory(?string $category) : string
    {
        $filterCategory = "";

        if(!empty($category))
        {
            $filterCategory = "WHERE NAME_CATEGORY = :category";
        }
        
        return $filterCategory;
    }
}
