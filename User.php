<?php
require_once __DIR__ . 'config.php';

class User {
    private ?int $id = null ;
    public ?string $login = null;
    public ?string $email = null;
    public ?string $firstname = null;
    public ?string $lastname = null;


    private ?mysqli $conn = null;


    public function __construct(){
        $this->conn = get_mysqli_connection();
    }

    public function __destruct(){
        if ($this->conn instanceof mysqli) {
            $this->conn->close();
        }
    }

    public function register(string $login, string $password, string $email = null, string $firstname, string $lastname): ?array{
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql ="INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUE (?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Mysqli Prépare Erreur :" . $this->conn->error);
        } 

        $stmt->bind_param('sssss',$login, $hash , $email, $firstname, $lastname);
        if (!$stmt->execute()) {
           $stmt->close();
           return null;
        }
        $this->id = $stmt->insert_id;
        $stmt->close();

        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;


        return $this->getAllInfos();

    }

}
?>