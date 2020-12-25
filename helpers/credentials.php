<?php
function db_credentials(): array{
    $content = explode(PHP_EOL, file_get_contents(realpath(__DIR__.'/../.credentials')));
    return [
        'dsn' => $content[0],
        'user' => $content[1],
        'password' => $content[2]
    ];
}
