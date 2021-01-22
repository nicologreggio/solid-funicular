<?php

require_once(__DIR__."/../../utils/utils.php");

class ProductModel
{
    private $id;
    private $name;
    private $description;
    private $metaDescription;
    private $dimensions;
    private $age;
    private $mainImage;
    private $mainImageDescription;
    private $category;
    private $categoryId; 
    private $materials;

    public function __construct(
        int $id,
        string $name,
        ?string $description = null,
        ?string $metaDescription = null,
        ?string $dimensions = null,
        ?string $age = null,
        ?string $mainImage = null,
        ?string $mainImageDescription = null,
        ?string $category = null,
        ?int $categoryId =null,
        ?array $materials = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->metaDescription = $metaDescription;
        $this->dimensions = $dimensions;
        $this->age = $age;
        $this->mainImage = $mainImage;
        $this->mainImageDescription = $mainImageDescription;
        $this->category = $category;
        $this->categoryId = $categoryId;
        $this->$materials = $materials;
    }

    public static function instanceFromProduct($product): ProductModel
    {
        $newModel = new ProductModel(
            $product->_ID,
            $product->_NAME
        );

        if(isset($product->_DESCRIPTION))
        {
            $newModel->setDescription($product->_DESCRIPTION);
        }

        if(isset($product->_METADESCRIPTION))
        {
            $newModel->setMetaDescription($product->_METADESCRIPTION);
        }

        if(isset($product->_DIMENSIONS))
        {
            $newModel->setDimensions($product->_DIMENSIONS);
        }

        if(isset($product->_AGE))
        {
            $newModel->setAge($product->_AGE);
        }

        if(isset($product->_MAIN_IMAGE))
        {
            $newModel->setMainImage($product->_MAIN_IMAGE);
        }

        if(isset($product->_MAIN_IMAGE_DESCRIPTION))
        {
            $newModel->setMainImageDescription($product->_MAIN_IMAGE_DESCRIPTION);
        }

        if(isset($product->_CATEGORY))
        {
            $newModel->setCategory($product->_CATEGORY);
        }

        if(isset($product->_CATEGORY_ID))
        {
            $newModel->setCategoryId($product->_CATEGORY_ID);
        }

        return $newModel;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description=$description;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(string $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age)
    {
        $this->age = $age;
    }

    public function getMainImage(): ?string
    {
        return base().$this->mainImage;
    }

    public function setMainImage(string $mainImage)
    {
        $this->mainImage = $mainImage;
    }

    public function getMainImageDescription(): ?string
    {
        return $this->mainImageDescription;
    }

    public function setMainImageDescription(string $mainImageDescription)
    {
        $this->mainImageDescription = $mainImageDescription;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    public function getCategoryId() : ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getMaterials(): ?array
    {
        return $this->materials;
    }

    public function addMaterials($materials)
    {
        $this->materials = $materials;
    }
}
