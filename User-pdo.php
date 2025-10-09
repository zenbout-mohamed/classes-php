<?php
require_once "User-pdo.php";

class UserPDO{
    private ?int $id = null;
    public ?string $login = null;
    public ?string $email = null;
    public ?string $login = null;
    public ?string $firstname = null;
    public ?string $lastname = null;



    private PDO $pdo;

    public function __construct(){
        $this->pdo = get_pdo_connection();
    }

    public function register()
}

?>