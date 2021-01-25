<?php

require_once(__DIR__."/../../DBC.php");
require_once(__DIR__."/material.model.php");

class MaterialRepository
{
    public static function getAll() : array
    {
        $stm = DBC::getInstance()->prepare(
            "SELECT _ID, _NAME from `MATERIALS`"
        );

        $stm->execute();

        $materials = $stm->fetchAll();

        $materialsModel = array();

        foreach($materials as $material)
        {
            $materialsModel[] = MaterialModel::instanceFromMaterial($material);
        }

        return $materialsModel;
    }

    public static function getAllWhereProduct(int $id) : array
    {
        $stm = DBC::getInstance()->prepare(
            "SELECT `MATERIALS`._ID, _NAME 
            FROM `MATERIALS` join (select PRODUCT_MATERIAL._MATERIAL_ID from PRODUCT_MATERIAL where PRODUCT_MATERIAL._PRODUCT_ID = ? ) m 
            on MATERIALS._ID = m._MATERIAL_ID"
        );

        $stm->execute([$id]);

        $materials = $stm->fetchAll();

        $materialsModel = array();

        foreach($materials as $material)
        {
            $materialsModel[] = MaterialModel::instanceFromMaterial($material);
        }

        return $materialsModel;
    }
}
