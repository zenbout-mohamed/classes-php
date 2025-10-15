<?php
require_once __DIR__ . "/config.php";

class UserPDO {
    private ?int $id = null;
    public ?string $login = null;
    public ?string $email = null;
    public ?string $firstname = null;
    public ?string $lastname = null;
    private ?string $password = null;

    private PDO $pdo;

    public function __construct() {
        $this->pdo = get_pdo_connection();
    }

    public function register(string $login, string $password, ?string $email = null, ?string $firstname = null, ?string $lastname = null): ?array {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) 
                VALUES (:login, :password, :email, :firstname, :lastname)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([
                ':login' => $login,
                ':password' => $hash,
                ':email' => $email,
                ':firstname' => $firstname,
                ':lastname' => $lastname
            ]);

            $this->id = (int)$this->pdo->lastInsertId();
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->password = $hash;

            return $this->getAllInfos();

        } catch (PDOException $e) {
            return null;
        }
    }

    public function connect(string $login, string $password): bool {
        $sql = "SELECT id, login, password, email, firstname, lastname 
                FROM utilisateurs WHERE login = :login LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $this->id = (int)$row['id'];
            $this->login = $row['login'];
            $this->email = $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password'];
            return true;
        }
        return false;
    }

    public function disconnect(): void {
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->password = null;
    }

    public function delete(): bool {
        if ($this->id === null) return false;
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute([':id' => $this->id]);

        if ($ok) {
            $this->disconnect();
            return true;
        }
        return false;
    }

    public function update(string $login, ?string $password, ?string $email, ?string $firstname, ?string $lastname): bool {
        if ($this->id === null) return false;

        if ($password !== null && $password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE utilisateurs SET login = :login, password = :password, email = :email,
                    firstname = :firstname, lastname = :lastname WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':login' => $login,
                ':password' => $hash,
                ':email' => $email,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':id' => $this->id
            ]);
            if ($ok) $this->password = $hash;
        } else {
            $sql = "UPDATE utilisateurs SET login = :login, email = :email,
                    firstname = :firstname, lastname = :lastname WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':login' => $login,
                ':email' => $email,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':id' => $this->id
            ]);
        }

        if ($ok) {
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            return true;
        }
        return false;
    }

    public function getAllInfos(): ?array {
        if ($this->id === null) return null;

        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }
}
?>
