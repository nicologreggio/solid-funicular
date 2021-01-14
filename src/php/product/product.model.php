<?php

class ProductModel
{
    private int $id;
    private string $name;
    private string $description;
    private string $metaDescription;
    private string $dimensions;
    private int $age;
    private string $mainImage;
    private string $mainImageDescription;
    private string $category;
    private array $materials;

    public function __construct(int $id, string $name, string $description, 
                                    string $metaDescription, ?string $dimensions, ?int $age,
                                    string $mainImage, string $mainImageDescription, string $category, array $materials = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->metaDescription = $metaDescription;
        if($dimensions) $this->dimensions = $dimensions;
        if($age) $this->age = $age;
        $this->mainImage = $mainImage;
        $this->mainImageDescription = $mainImageDescription;
        $this->category = $category;
        $this->$materials = $materials;
    }

    public static function instanceFromProduct($product) : ProductModel
    {
        return new ProductModel($product->_ID, $product->_NAME, $product->_DESCRIPTION, 
                                $product->_METADESCRIPTION, $product->_DIMENSIONS, $product->_AGE,
                                $product->_MAIN_IMAGE, $product->_MAIN_IMAGE_DESCRIPTION, $product->_CATEGORY);
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

    public function getMetaDescription() : string
    {
        return $this->metaDescription;
    }

    public function getDimensions() : string
    {
        return $this->dimensions;
    }

    public function getAge() : int 
    {
        return $this->age;
    }

    public function getMainImage() : string
    {
        return $this->mainImage;
    }

    public function getMainImageDescription() : string
    {
        return $this->mainImageDescription;
    }

    public function getCategory() : string
    {
        return $this->category;
    }

    public function getMaterials() : array
    {
        return $this->materials;
    }

    public function addMaterials($materials)
    {
        $this->materials = $materials;
    }
}
