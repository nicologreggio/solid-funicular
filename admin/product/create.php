<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/product/create.html');
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'] ?? "",
        'description' => $_POST['description'] ?? "",
        'meta-description' => $_POST['meta-description'] ?? "",
        'dimensions' => $_POST['dimensions'] ?? "",
        'age' => $_POST['age'] ?? "",
        'image' => $_FILES['image'] ?? null,
        'category' => $_POST['category'] ?? "",
        'image-description' => $_POST['image-description'] ?? "",
        'materials' => $_POST['materials'] ?? []
    ],[
        'name' => ["required", "min_length:2", "max_length:30"],
        'description' => ["required",  "min_length:30"],
        'meta-description' => ["required", "max_length:500", "min_length:30"],
        'dimensions' => ['max_length:300'],
        'age' => ['max_length:50'],
        'image' => ['file:700', 'image'],
        'category' => ['in_table:CATEGORIES,_ID'],
        'image-description' => ['required', 'min_length:10', 'max_length:200'],
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

        "image.file" => "E' obbligatorio inserire un immagine valida di dimensione massima 700kb",
        "image.image" => "Il file selezionato deve essere un immagine JPEG, PNG, JPEG2000 o GIF",

        'category.in_table' => "La categoria selezionata non è stata trovata",

        'image-description.required' => "E' obbligatorio inserire una descrizione dell'immagine",
        'image-description.min_length' => "La descrizione dell'immagine inserita deve essere lunga almeno 10 caratteri",
        'image-description.max_length' => "La descrizione dell'immagine inserita può essere lunga al massimo 200 caratteri",

        'materials.array_in_table' => "Uno o più dei materiali selezionati non è stato trovato nel database"
    ]);
    if($err === true){
        if($file_path = saveFromRequest('image')){
            $err = DBC::getInstance()->prepare("
                INSERT INTO `PRODUCTS`(`_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_DIMENSIONS`, `_AGE`, `_MAIN_IMAGE`, `_CATEGORY`, `_MAIN_IMAGE_DESCRIPTION`) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)
            ")->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['meta-description'],
                $_POST['dimensions'],
                $_POST['age'],
                $file_path,
                $_POST['category'],
                $_POST['image-description'],
            ]);
            if($err === true){
                if(!empty($_POST['materials'] ?? [])){
                    $prod_id = DBC::getInstance()->lastInsertId();
                    foreach($_POST['materials'] ?? [] as $mat){
                        $err = DBC::getInstance()->prepare("
                            INSERT INTO `PRODUCT_MATERIAL`(`_MATERIAL_ID`, `_PRODUCT_ID`) VALUES
                            (?, ?)
                        ")->execute([
                            $mat,
                            $prod_id
                        ]);
                    }
                }
                redirectTo('/admin/product/index.php');
            }
        }
    }
    
    $page = str_replace("<value-name/>", $_POST["name"], $page);
    $page = str_replace("<value-description/>", $_POST["description"], $page);
    $page = str_replace("<value-meta-description/>", $_POST["meta-description"], $page);
    $page = str_replace('<value-age/>', $_POST["age"], $page);
    $page = str_replace('<value-dimensions/>', $_POST["dimensions"], $page);
    $page = str_replace('<value-image-description/>', $_POST["dimensions"], $page);
    $page = str_replace('<value-image-description/>', $_POST["image-description"], $page);

    if($err === false){
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento", $page);
        $page = str_replace('<error-name/>', "", $page);
        $page = str_replace('<error-description/>', "" , $page);
        $page = str_replace('<error-meta-description/>', "" , $page);
        $page = str_replace('<error-age/>', "" , $page);
        $page = str_replace('<error-dimensions/>', "" , $page);
        $page = str_replace('<error-materials/>', "" , $page);
        $page = str_replace('<error-image/>', "" , $page);
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
    $page = str_replace("<value-name/>", "", $page);
    $page = str_replace("<value-description/>", "", $page);
    $page = str_replace("<value-meta-description/>", "", $page);
    $page = str_replace('<value-age/>', "", $page);
    $page = str_replace('<value-dimensions/>', "", $page);
    $page = str_replace('<value-image-description/>', "", $page);
    
    $page = str_replace('<error-db/>', "", $page);
    $page = str_replace('<error-name/>', "", $page);
    $page = str_replace('<error-description/>', "" , $page);
    $page = str_replace('<error-meta-description/>', "" , $page);
    $page = str_replace('<error-age/>', "" , $page);
    $page = str_replace('<error-dimensions/>', "" , $page);
    $page = str_replace('<error-image/>', "" , $page);
    $page = str_replace('<error-category/>', "" , $page);
    $page = str_replace('<error-image-description/>', "" , $page);
    $page = str_replace('<error-materials/>', "" , $page);
}

$categories = DBC::getInstance()->query("
    SELECT _ID, _NAME FROM CATEGORIES 
")->fetchAll();
$out = "<option value='' ".(isset($_REQUEST['category']) ? '' : 'selected' ).">Seleziona la categoria di questo prodotto</option>";
foreach($categories as $cat){
    $out.= '<option value="'.$cat->_ID.'"'.(($_REQUEST['category'] ?? null === $cat->_ID )? 'selected' : '' ).'>'.$cat->_NAME.'</option>';
}
$page = str_replace('<categories/>', $out, $page);




$materials = DBC::getInstance()->query("
    SELECT * FROM MATERIALS 
")->fetchAll();
$out = "";
foreach($materials as $mat){
    $out.= '<option value="'.$mat->_ID.'" '.(in_array($mat->_ID, $_REQUEST['material'] ?? [] )? 'selected ' : '' ).' >'.$mat->_NAME.'</option>';
}
$page = str_replace('<materials/>', $out, $page);





echo $page;
