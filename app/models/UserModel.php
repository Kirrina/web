<?php

require_once '../app/core/Database.php';

class UserModel extends Database {
    
    
    public function createUser($fullname, $email, $password) {
       
        $sql = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        
        
        return $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    
    public function checkEmailExist($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0; 
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

   
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    
    public function getAllUsers() {
        
        $sql = "SELECT id, fullname, email, phone, role, status FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function updateProfile($id, $fullname) {
        $sql = "UPDATE users SET fullname = :fullname WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':fullname' => $fullname,
            ':id' => $id
        ]);
    }

    
    public function updatePassword($id, $hashedPassword) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $id
        ]);
    }

    public function updateAvatar($id, $avatarName) {
        $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':avatar' => $avatarName,
            ':id' => $id
        ]);
    }

    
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    
    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE users SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
    
    
    public function updateAccount($id, $fullname, $email, $phone,  $role, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET fullname = :fullname, email = :email, phone = :phone, role = :role, password = :password WHERE id = :id";
            $params = [
                ':id' => $id,
                ':fullname' => $fullname,
                ':email' => $email,
                ':phone' => $phone,
                ':role' => $role,
                ':password' => $hashedPassword
            ];
        } else {
            $sql = "UPDATE users SET fullname = :fullname, email = :email, phone = :phone, role = :role WHERE id = :id";
            $params = [
                ':id' => $id,
                ':fullname' => $fullname,
                ':email' => $email,
                ':phone' => $phone,
                ':role' => $role
            ];
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
    
}
?>