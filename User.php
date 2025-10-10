<?php
require_once __DIR__ . "config.php";

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

    public function register(string $login, string $password, string $firstname, string $lastname, ?string $email = null): ?array{
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql ="INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?,?,?,?,?)";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new RuntimeException("Mysqli Prépare Erreur :" . $this->conn->error);
    } 
    
    $stmt->bind_param('sssss', $login, $hash, $email, $firstname, $lastname);

    if (!$stmt->execute()) {
       $stmt->close();
       return null;
    }
    $this->id = $this->conn->insert_id;
    $stmt->close();

    $this->login = $login;
    $this->email = $email;
    $this->firstname = $firstname;
    $this->lastname = $lastname;

    return $this->getAllInfos();
}



    public function connect(string $login, string $password): bool{
        $sql = "SELECT id, login,password ,email ,firstname ,lastname FROM utilisateurs WHERE login = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) throw new RuntimeException("Mysqli Erreur de préparation". $this->conn->error);
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row && password_verify($password, $row['password'])) {
            $this->id = (int)$row['id'];
            $this->login = $row['login'];
            $this->email= $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            return true;
        }
        return false;
    }


    public function disconnect(): void{
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
    }

    public function delete(): bool{
        if($this->id === null) return false;
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $this->disconnect();
            return true;
        }
        return false;
    }

    public function update(string $login, ?string $password, ?string $email, ?string $firstname, ?string $lastname): bool {
        if($this->id === null) return false;

        if ($password !== null && $password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssssi', $login, $hash, $email, $firstname, $lastname, $this->id);
        }else{
            $sql = "UPDATE utilisateurs SET login = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ssssi',$login ,$email ,$firstname ,$lastname, $this->id);
        }


        $ok = $stmt->execute();
        $stmt->close();
        if($ok){
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            return true;
        }
        return false;
    }


    public function isConnected(): bool {
        return $this->id !== null;
    }


    public function getAllInfos(): ?array {
        if ($this->id === null && $this->login === null) return null;
        if($this->id !== null) {
            $sql = "SELECT id, login, email, firstname, lastname FROM utilisateurs WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $this->id);
            $stmt->execute();
            $res = $stmt->get_result();
            $data = $res->fetch_assoc();
            $stmt->close();
            return $data;
        }
        return[
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }


    public function getLogin(): ?string {
        return $this->login;
    }
    public function getEmail(): ?string {
        return $this->email;
    }
    public function getFirstname(): ?string {
        return $this->firstname;
    }
    public function getLastname(): ?string {
        return $this->lastname;
    }
}
?>