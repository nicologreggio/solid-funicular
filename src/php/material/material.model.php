<?php

class MaterialModel
{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(int $id, string $name, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        
        if($description) $this->description = $description;
    }

    public static function instanceFromMaterial($material) : MaterialModel
    {
        return new MaterialModel($material->_ID, $material->_NAME, $material->_DESCRIPTION);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }
}
