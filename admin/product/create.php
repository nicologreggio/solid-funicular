<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/product/create.html');
if(request()->method() == 'POST' ){
    $request = request()->only([
        'name',
        'description',
        'meta-description',
        'dimensions',
        'age',
        'category',
        'image-description',
        'materials'
    ]);
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

    // validazione andata a buon fine
    if($err === true){
        // se riesco a salvare la foto
        if($file_path = saveFromRequest('image')){
            $err = DBC::getInstance()->prepare("
                INSERT INTO `PRODUCTS`(`_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_DIMENSIONS`, `_AGE`, `_MAIN_IMAGE`, `_CATEGORY`, `_MAIN_IMAGE_DESCRIPTION`) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)
            ")->execute([
                $request['name'],
                $request['description'],
                $request['meta-description'],
                $request['dimensions'],
                $request['age'],
                $file_path,
                $request['category'],
                $request['image-description'],
            ]);
            if($err === true){
                if(!empty($request['materials'] ?? [])){
                    $prod_id = DBC::getInstance()->lastInsertId();
                    foreach($request['materials'] ?? [] as $mat){
                        $err = DBC::getInstance()->prepare("
                            INSERT INTO `PRODUCT_MATERIAL`(`_MATERIAL_ID`, `_PRODUCT_ID`) VALUES
                            (?, ?)
                        ")->execute([
                            $mat,
                            $prod_id
                        ]);
                    }
                }
                message("Prodotto inserito correttamente");
                redirectTo('/admin/product/index.php');
            }
        }
    }

    // altrimenti precompilo i campi
    replaceValues([
        "name" => $request["name"],
        "description" => $request["description"],
        "meta-description" => $request["meta-description"],
        'age' => $request["age"],
        'dimensions' => $request["dimensions"],
        'image-description' => $request["image-description"],
    ], $page, true);

    // mostro l'errore
    if($err === false){
        replaceErrors([
            'db'=> "C'è stato un errore durante l'inserimento o il salvataggio della foto"
        ], $page, true);
    }
    else if(is_array($err)){
        replaceErrors($err, $page, true);
     }
}
else {
    removeErrorsTag($page);
    removeValuesTag($page);
}

$categories = DBC::getInstance()->query("
    SELECT _ID, _NAME FROM CATEGORIES 
")->fetchAll();
$out = "<option value='' ".(isset($_REQUEST['category']) ? '' : ' selected="selected"' ).">Seleziona la categoria di questo prodotto</option>";
foreach($categories as $cat){
    $out.= '<option value="'.$cat->_ID.'"'.((($_REQUEST['category'] ?? null) === $cat->_ID )? ' selected="selected"' : '' ).'>'.$cat->_NAME.'</option>';
}
$page = str_replace('<categories/>', $out, $page);



$materials = DBC::getInstance()->query("
    SELECT * FROM MATERIALS 
")->fetchAll();
$out = "";
foreach($materials as $mat){
    $out.= '<option value="'.$mat->_ID.'" '.(in_array($mat->_ID, $_REQUEST['materials'] ?? [] )? ' selected="selected" ' : '' ).' >'.$mat->_NAME.'</option>';
}
$page = str_replace('<materials/>', $out, $page);





echo $page;
