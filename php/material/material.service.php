<?php

require_once(__DIR__."/material.repository.php");

class MaterialService
{
    public static function getAll() : array
    {
        return MaterialRepository::getAll();
    }

    public static function getMaterialsReleatedToProduct(int $id) : array
    {
        return MaterialRepository::getAllWhereProduct($id);
    }
}
