<?php

require_once(__DIR__."/material.repository.php");

class MaterialService
{
    public static function getMaterialsReleatedToProduct(int $id) : array
    {
        return MaterialRepository::getAllWhereProduct($id);
    }
}
