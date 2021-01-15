<?php

class MaterialModel
{
    private int $id;
    private string $name;
    private ?string $description;

    public function __construct(int $id, string $name, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public static function instanceFromMaterial($material) : MaterialModel
    {
        $newModel = new MaterialModel($material->_ID, $material->_NAME);

        if(isset($material->_DESCRIPTION))
        {
            $newModel->setDescription($material->_DESCRIPTION);
        }

        return $newModel;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}
