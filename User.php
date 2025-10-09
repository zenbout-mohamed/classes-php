<?php
require_once __DIR__ . 'config.php';

class User {
    private ?int $id = null ;
    public ?string $login = null;
    public ?string $email = null;
    public ?string $firstname = null;
    public ?string $lastname = null;
}
?>