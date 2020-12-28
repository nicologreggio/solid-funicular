<?php 
function save($file,  $name, $path){

}
function saveFromRequest($key){
    try{
        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            '../../images/products/'.uniqid()
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        echo 'File is uploaded successfully.';
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
}