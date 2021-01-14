<?php

class CategoryModel
{
    private int $id;
    private string $name;
    private ?string $description;
    private ?string $metaDescription;

    public function __construct(int $id, string $name, ?string $description, ?string $metaDescription)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->metaDescription = $metaDescription;
    }

    public static function instanceFromCategory($category) : CategoryModel
    {
        return new CategoryModel($category->_ID, $category->_NAME, $category->_DESCRIPTION, $category->_METADESCRIPTION);
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

    public function getMetaDescription() : ?string
    {
        return $this->metaDescription;
    }
}
