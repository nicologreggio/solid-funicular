<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/product/edit.html');
$page = str_replace('<value-id/>', $_REQUEST['id'], $page);


$stm = DBC::getInstance()->prepare("
    SELECT *
    FROM PRODUCTS
    WHERE `_ID` = ?
");
$stm->execute([
    $_REQUEST['id']
]);
$product = $stm->fetch();
if($product === false){
    error('Il prodotto cercato non esiste');
} 


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'] ?? "",
        'description' => $_POST['description'] ?? "",
        'meta-description' => $_POST['meta-description'] ?? "",
        'dimensions' => $_POST['dimensions'] ?? "",
        'age' => $_POST['age'] ?? "",
        'image' => $_FILES['image'] ?? null,
        'category' => $_POST['category'],
        'image' => $_FILES['image'],
        'image-description' => $_POST['image-description'],
        'materials' => $_POST['materials'] ?? []
    ],[
        'name' => ["required", "min_length:2", "max_length:30"],
        'description' => ["required",  "min_length:30"],
        'meta-description' => ["required", "max_length:500", "min_length:30"],
        'dimensions' => ['max_length:300'],
        'age' => ['max_length:50'],
        'category' => ['in_table:CATEGORIES,_ID'],
        'image-description' => ['required', 'min_length:10', 'max_length:200'],
        'image' => ($_FILES['image']['size'] == 0 ? [] : ['file:700', 'image']),
        'materials' => ['array_in_table:MATERIALS,_ID']
    ],[
        "name.required" => "E' obbligatorio inserire un nome",
        "name.min_length" => "Il nome inserito deve essere lungo almeno 2 caratteri",
        "name.max_length" => "Il nome inserito può essere lungo al massimo 30 caratteri",

        "meta-description.required" => "E' obbligatorio inserire una meta-descrizione",
        "meta-description.min_length" => "La meta descrizione deve essere lunga almeno 30 caratteri",
        "meta-description.max_length" => "La meta descrizione può essere lunga al massimo 500 caratteri",

        "description.required" => "E' obbligatorio inserire una descrizione",
        "description.min_length" => "La descrizione deve essere lunga almeno 30 caratteri",

        "age.max_length" => "L'età consigliata può essere lunga al massimo 50 caratteri",

        "dimensions.max_length" => "Le dimensioni possono essere lunghe al massimo 300 caratteri",

        'category.in_table' => "La categoria selezionata non è stata trovata",

        "image.file" => "E' obbligatorio inserire un immagine valida di dimensione massima 700kb",
        "image.image" => "Il file selezionato deve essere un immagine JPEG, PNG, JPEG2000 o GIF",

        'image-description.required' => "E' obbligatorio inserire una descrizione dell'immagine",
        'image-description.min_length' => "La descrizione dell'immagine inserita deve essere lunga almeno 10 caratteri",
        'image-description.max_length' => "La descrizione dell'immagine inserita può essere lunga al massimo 200 caratteri",

        'materials.array_in_table' => "Uno o più dei materiali selezionati non è stato trovato nel database"
    ]);

    if($err === true){
        if($_FILES['image']['size'] != 0){
            $file_path = saveFromRequest('image');
            $err = DBC::getInstance()->prepare("
                UPDATE `PRODUCTS`
                SET
                `_MAIN_IMAGE` = ?
                WHERE _ID = ?
            ")->execute([
                $file_path,
                $_REQUEST['id']
            ]);
        }
        
        

        $err = $err && DBC::getInstance()->prepare("
            UPDATE `PRODUCTS`
            SET
            `_NAME` = ?, 
            `_DESCRIPTION` = ?, 
            `_METADESCRIPTION` = ?, 
            `_DIMENSIONS` = ?, 
            `_AGE` = ?,  
            `_CATEGORY` = ?,
            `_MAIN_IMAGE_DESCRIPTION` = ?
            WHERE _ID = ?
        ")->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['meta-description'],
            $_POST['dimensions'],
            $_POST['age'],
            $_POST['category'],
            $_POST['image-description'],
            $_REQUEST['id'],
        ]);
        


        
        if($err === true){
            DBC::getInstance()->prepare("
                DELETE FROM `PRODUCT_MATERIAL` WHERE _PRODUCT_ID = ?
            ")->execute([
                $_REQUEST['id']
            ]);
            foreach($_POST['materials'] ?? [] as $mat){
                $err = DBC::getInstance()->prepare("
                    INSERT INTO `PRODUCT_MATERIAL`(`_MATERIAL_ID`, `_PRODUCT_ID`) VALUES
                    (?, ?)
                ")->execute([
                    $mat,
                    $_REQUEST['id']
                ]);
            }
            message("Prodotto modificato correttamente");
            redirectTo('/admin/product/index.php');
        }    
    }
    $page = str_replace("<value-name/>", $_POST["name"], $page);
    $page = str_replace("<value-description/>", $_POST["description"], $page);
    $page = str_replace("<value-meta-description/>", $_POST["meta-description"], $page);
    $page = str_replace('<value-age/>', $_POST["age"], $page);
    $page = str_replace('<value-dimensions/>', $_POST["dimensions"], $page);
    $page = str_replace('<value-image-description/>', $_POST["image-description"], $page);

    if($err === false){
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento", $page);
        $page = str_replace('<error-name/>', "", $page);
        $page = str_replace('<error-description/>', "" , $page);
        $page = str_replace('<error-meta-description/>', "" , $page);
        $page = str_replace('<error-image-description/>', "" , $page);
    }
    else if(is_array($err)){
        $page = str_replace('<error-db/>', "", $page); // rimuovo placeholder per errore db
        foreach($err as $k => $errors){
            $msg = "<ul class='errors-list'>";
            foreach($errors as $error){
                $msg .= "<li> $error </li>";
            }
            $msg .= "</ul>";
            $page = str_replace("<error-$k/>", $msg, $page);
        }
     }
}
else {

    $page = str_replace("<value-name/>", $product->_NAME, $page);
    $page = str_replace("<value-description/>", $product->_DESCRIPTION, $page);
    $page = str_replace("<value-meta-description/>", $product->_METADESCRIPTION, $page);
    $page = str_replace('<value-age/>', $product->_AGE, $page);
    $page = str_replace('<value-dimensions/>', $product->_DIMENSIONS, $page);
    $page = str_replace('<value-image-description/>', $product->_MAIN_IMAGE_DESCRIPTION, $page);
    
    $page = str_replace('<error-db/>', "", $page);
    $page = str_replace('<error-name/>', "", $page);
    $page = str_replace('<error-description/>', "" , $page);
    $page = str_replace('<error-meta-description/>', "" , $page);
    $page = str_replace('<error-age/>', "" , $page);
    $page = str_replace('<error-dimensions/>', "" , $page);
    $page = str_replace('<error-image/>', "" , $page);
    $page = str_replace('<error-category/>', "" , $page);
    $page = str_replace('<error-image-description/>', "" , $page);
}
$categories = DBC::getInstance()->query("
    SELECT _ID, _NAME FROM CATEGORIES 
")->fetchAll();
$out = "";
foreach($categories as $cat){
    $out.= '<option value="'.$cat->_ID.'"'.((($_REQUEST['category'] ?? $product->_CATEGORY) === $cat->_ID )? 'selected' : '' ).'>'.$cat->_NAME.'</option>';
}
$page = str_replace('<categories/>', $out, $page);





$materials = DBC::getInstance()->query("
    SELECT * FROM MATERIALS 
")->fetchAll();
$out = "";
$current_materials = [];
if(isset($_POST['materials'])){
    $current_materials = $_POST['materials'];
}
else {
    $current_materials = DBC::getInstance()->query("
        SELECT _MATERIAL_ID
        FROM PRODUCT_MATERIAL 
        WHERE _PRODUCT_ID = $product->_ID
    ")->fetchAll(PDO::FETCH_COLUMN);
}
foreach($materials as $mat){
    $select = in_array( $mat->_ID, $current_materials );
    $out.= '<option value="'.$mat->_ID.'" '.($select ? 'selected ' : '' ).'>'.$mat->_NAME.'</option>';
}
$page = str_replace('<materials/>', $out, $page);





echo $page;