<?php

class CategoryModel
{
    private int $id;
    private string $name;
    private ?string $description;
    private ?string $metaDescription;

    public function __construct(int $id, string $name, ?string $description = null, ?string $metaDescription = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->metaDescription = $metaDescription;
    }

    public static function instanceFromCategory($category) : CategoryModel
    {
        $newModel = new CategoryModel($category->_ID, $category->_NAME);

        if(isset($category->_DESCRIPTION))
        {
            $newModel->setDescription($category->_DESCRIPTION);
        }

        if(isset($category->_METADESCRIPTION))
        {
            $newModel->setMetaDescription($category->_METADESCRIPTION);
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

    public function getMetaDescription() : ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }
}
