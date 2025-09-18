<?php
class User {
    public $username;           // Anyone can read/write
    private $passwordHash;      // Hidden from outside
    protected $role;            // Subclasses can access

    public function __construct($username, $password) {
        $this->username = $username;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->role = "user";
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->passwordHash);
    }
}

class AdminUser extends User {
    public function promote() {
        $this->role = "admin"; // Can access protected
    }
}

$user = new User("john", "secret");
// echo $user->passwordHash; // ERROR: private
echo $user->verifyPassword("secret") ? "Correct" : "Wrong"; // OK
?>