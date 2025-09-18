<?php
class Pengurus {
    private $conn;                   // Database connection
    private $table = 'data_pengurus';// Table name

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new staff (registration)
     * @param string $nama
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $no_hp
     * @param string $status
     * @return bool - True if success, False if failed
     */
    public function create($nama, $username, $password, $email, $no_hp, $status) {
        try {
            //SQL query
            $sql = "INSERT INTO {$this->table}
                (nama_pengurus, username, password, email, no_hp, status)
                VALUES (:nama, :username, :password, :email, :no_hp, :status)";

            //Prepare statement
            $stmt = $this->conn->prepare($sql);

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindValue(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':no_hp', $no_hp, PDO::PARAM_STR);   
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Pengurus create error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get staff by username
     * @param string $username
     * @return array|false - User data or false on error
     */
    public function getByUsername($username) {
        try {
            $sql = "SELECT * FROM {$this->table}
                WHERE username = :username LIMIT 1";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Pengurus getByUsername error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get staff by e-mail
     * @param string $email
     * @return array|false - User data or false on error
     */
    public function getByEmail($email) {
        try {
            $sql = "SELECT * FROM {$this->table}
                WHERE email = :email LIMIT 1";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Pengurus getByEmail error: " . $e->getMessage());
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
            $pengurus = $this->getByUsername($username);
            if ($pengurus && password_verify($password, $pengurus['password']) === true) {
                unset($pengurus['password']);
                return $pengurus;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Pengurus verifyLogin error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update staff 
     * @param int $id_pengurus
     * @param string $nama
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $no_hp
     * @param string $status
     * @return bool - True if success, False if failed
     */
    public function update($id_pengurus, $nama, $username, $password, $email, $no_hp, $status) {
        try {
            // Check if password field is not empty
            if (!empty($password)) {
                // Re-hash new password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $password_sql = "password = :password,";
            } else {
                // Skip password update
                $hashed_password = null;
                $password_sql = "";
            }

            $sql = "UPDATE {$this->table}
                    SET nama_pengurus = :nama, username = :username,
                        email = :email, no_hp = :no_hp, 
                        status = :status, ".$password_sql."
                    WHERE id_pengurus = :id_pengurus";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id_pengurus', $id_pengurus, PDO::PARAM_INT);
            $stmt->bindValue(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':no_hp', $no_hp, PDO::PARAM_STR);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);

            if (!empty($password)) {
                $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Pengurus update error: " . $e->getMessage());
            return false;
        }
        
    }

    /**
     * Delete staff
     * @param int $id_pengurus
     * @return bool
     */
    public function delete($id_pengurus) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id_pengurus = :id_pengurus";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_pengurus', $id_pengurus, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Pengurus delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all staff
     * @param int $id_pengurus 
     * @return array - List of staff
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id_pengurus DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Pengurus getAll error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get staff by ID
     * @param int $id_pengurus
     * @return array|false - User data or false on error
     */
    public function getById($id_pengurus) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_pengurus = :id_pengurus LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_pengurus', $id_pengurus, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            error_log("Pengurus getById error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count staff based from status
     * @param string $status
     * @return int|false - Total staff or false on error
     */
    public function countByStatus(string $status): int {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int) $result['total'] : 0;
        } catch (PDOException $e) {
            error_log("Pengurus countByStatus error: " . $e->getMessage());
            return false;
        }
    }
}
?>
