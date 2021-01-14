<?php
require_once(__DIR__.'/../inc/imports.php');
class Request{
    private $request;
    private $server;
    public function __construct(array $request, array $server){
        $this->request = $request;
        $this->server = $server;
    }
    public function only(array $fields_name) : array{
        $res = [];
        foreach($fields_name as $f){
            $res[$f] = $_REQUEST[$f] ?? null;
        }
        return $res;
    }
    public function validate(array $fields_name, $rules, $messages){
        return validate(
            $this->only($fields_name), 
            $rules, 
            $messages
        );
    }
    public function method(){
        return $_SERVER['REQUEST_METHOD'];
    }
}
function request(){
    return new Request($_REQUEST, $_SERVER);
}