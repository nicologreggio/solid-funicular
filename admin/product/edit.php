<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/product/edit.html');

$id = request()->only(['id']);
$request = request()->only([
    'id',
    'name',
    'description',
    'meta-description',
    'dimensions',
    'age',
    'category',
    'image-description',
    'materials',
    'page'
]);

replaceValues($id, $page);

$stm = DBC::getInstance()->prepare("
    SELECT *
    FROM PRODUCTS
    WHERE `_ID` = ?
");
$stm->execute([
    $request['id']
]);
$product = $stm->fetch();

error_if($product === false, 'Il prodotto cercato non esiste');
 


if(request()->method() == 'POST' ){
    $err = validate([
        'name' => $request['name'],
        'description' => $request['description'],
        'meta-description' => $request['meta-description'],
        'dimensions' => $request['dimensions'],
        'age' => $request['age'],
        'image' => $_FILES['image'] ?? null,
        'category' => $request['category'],
        'image-description' => $request['image-description'],
        'materials' => $request['materials'] ?? []
    ],[
        'name' => ["required", "min_length:2", "max_length:30"],
        'description' => ["required",  "min_length:30"],
        'meta-description' => ["required", "max_length:500", "min_length:30"],
        'dimensions' => ['max_length:300'],
        'age' => ['max_length:50'],
        'category' => ['in_table:CATEGORIES,_ID'],
        'image-description' => ['required', 'min_length:10', 'max_length:200'],
        'image' => ((!isset($_FILES['image']) || $_FILES['image']['size'] == 0) ? [] : ['file:700', 'image']),
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
    // validazione andata a buon fine
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
            $request['name'],
            $request['description'],
            $request['meta-description'],
            $request['dimensions'],
            $request['age'],
            $request['category'],
            $request['image-description'],
            $request['id'],
        ]);
        

        if($err === true){
            DBC::getInstance()->prepare("
                DELETE FROM `PRODUCT_MATERIAL` WHERE _PRODUCT_ID = ?
            ")->execute([
                $request['id']
            ]);
            foreach($request['materials'] ?? [] as $mat){
                $err = DBC::getInstance()->prepare("
                    INSERT INTO `PRODUCT_MATERIAL`(`_MATERIAL_ID`, `_PRODUCT_ID`) VALUES
                    (?, ?)
                ")->execute([
                    $mat,
                    $request['id']
                ]);
            }
            message("Prodotto modificato correttamente");
            redirectTo('/admin/product/index.php?page='.$request['page']);
        }    
    }
    replaceValues([
        "name" => $request["name"],
        "description" => $request["description"],
        "meta-description" => $request["meta-description"],
        'age' => $request["age"],
        'dimensions' => $request["dimensions"],
        'image-description' => $request["image-description"],
    ], $page, true);

    if($err === false){
        replaceErrors([
            'db'=> "C'è stato un errore durante l'inserimento"
        ], $page, true);
    }
    else if(is_array($err)){
        replaceErrors($err, $page, true);
     }
}
else {
    removeErrorsTag($page);
    replaceValues([
        "name" => $product->_NAME,
        "description" => $product->_DESCRIPTION,
        "meta-description" => $product->_METADESCRIPTION,
        'age' => $product->_AGE,
        'dimensions' => $product->_DIMENSIONS,
        'image-description' => $product->_MAIN_IMAGE_DESCRIPTION,
    ], $page, true);
}
$categories = DBC::getInstance()->query("
    SELECT _ID, _NAME FROM CATEGORIES 
")->fetchAll();
$out = "";
foreach($categories as $cat){
    $out.= '<option value="'.$cat->_ID.'"'.((($request['category'] ?? $product->_CATEGORY) === $cat->_ID )? 'selected' : '' ).'>'.$cat->_NAME.'</option>';
}
$page = str_replace('<categories/>', $out, $page);





$materials = DBC::getInstance()->query("
    SELECT * FROM MATERIALS 
")->fetchAll();
$out = "";
$current_materials = [];
if($request['materials']){
    $current_materials = $request['materials'];
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