<?php
class User {
    private $conn;              // Database connection
    private $table = 'data_user'; // Table name

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new user (registration)
     * @param string $nama
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $no_hp
     * @return bool - True if success, False if failed
     */
    public function create($nama, $username, $password, $email, $no_hp) {
        try {
            $sql = "INSERT INTO {$this->table}
                    (nama_user, username, password, email, no_hp)
                    VALUES (:nama, :username, :password, :email, :no_hp)";
            
            $stmt = $this->conn->prepare($sql);

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindValue(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':no_hp', $no_hp, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("User create error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by username
     * @param string $username
     * @return array|false - User data or false on error
     */
    public function getByUsername($username) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User getByUsername error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by email
     * @param string $email
     * @return array|false
     */
    public function getByEmail($email) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User getByEmail error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array|false
     */
    public function getById($id_user) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_user = :id_user LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User getById error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count all users
     * @return int|false - Total users or false on error
     */
    public function countAllUsers() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch (PDOException $e) {
            error_log("User countAllUsers error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify login credentials
     * @param string $username
     * @param string $password
     * @return array|false - User data without password or false if invalid
     */
    public function verifyLogin($username, $password) {
        try {
            $user = $this->getByUsername($username);
            if ($user && password_verify($password, $user['password']) === true) {
                unset($user['password']);
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("User verifyLogin error: " . $e->getMessage());
            return false;
        }
    }
}
?>
