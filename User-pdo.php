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

    public function register(string $login, string $password, ?string $email = null, ?string $firstname = null, ?string $lastname = null): ?array{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateurs (login, password, email, firstanme"
    }
}

?>