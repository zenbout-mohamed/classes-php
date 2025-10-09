<?php
require_once __DIR__ ."config.php";

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
        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (:login , :password, :email, :firstname, :lastname)";
        $stmt = $this->pdo->prepare($sql);

        try{
            $stmt->execute([
                ':login' => $login,
                ':password' => $password,
                ':email' => $email,
                ':firstname' => $firstname,
                ':lastname' => $lastname
            ]);
            $this->id = (int)$this->pdo->lastInsertId();
            $this->login = $login;
            $this->password = $password;
            $this->firstname = $firstname;
            $this->lastname = $lastname;

            return $this->getAllInfos();

        } catch (PDOException $e){
            return null;
        }
    }

    public fucntion connect(string $login, string $password): bool {
        $sql = "SELECT id, login, password, email, firstname, lastname FROM utilisateurs WHERE login = :login LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            $this->id = (int)$row['id'];
            $this>login = $row['login'];
            $this->email = $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            return true;

        }
        return false;
    }

    public function dsiconnect(): void{
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
    }
}

?>