<?php
require_once __DIR__ . '/../DTO/userDTO.php';

// handles all database operations (CRUD) for the user 

class UserDAO {

    // authenticate a user by checking username and password

    public function login($username, $password) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($data = $result->fetch_assoc()) {
            return new UserDTO(
                $data['username'], $data['password'], $data['role'],
                $data['email'], $data['first_name'], $data['last_name'],
                $data['avatar'], $data['id']
            );
        }
        return null;
    }

   // creates a new user in database

    public function registerUser(UserDTO $user) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "INSERT INTO users (username, email, password, first_name, last_name, role, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        $un = $user->getUsername();
        $em = $user->getEmail();
        $pw = $user->getPassword(); // must be hashed before
        $fn = $user->getFirstName();
        $ln = $user->getLastName();
        $rl = $user->getRole();
        $av = $user->getAvatar();
        
        $stmt->bind_param("sssssss", $un, $em, $pw, $fn, $ln, $rl, $av);
        return $stmt->execute();
    }

 
    public function findById($id) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($data = $result->fetch_assoc()) {
            return $this->mapDataToDTO($data);
        }
        return null;
    }

    public function findByUsername($username) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($data = $result->fetch_assoc()) {
            return new UserDTO(
                $data['username'], 
                $data['password'], 
                $data['role'],
                $data['email'], 
                $data['first_name'], 
                $data['last_name'],
                $data['avatar'], 
                $data['id']
            );
        }
        return null;
    }

    public function findAll() {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "SELECT * FROM users";
        $rs = $conn->query($query);
        $users = [];

        while ($data = $rs->fetch_assoc()) {
            $users[] = $this->mapDataToDTO($data);
        }
        return $users;
    }

    public function updateProfile(UserDTO $user) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        $un = $user->getUsername();
        $fn = $user->getFirstName();
        $ln = $user->getLastName();
        $em = $user->getEmail();
        $av = $user->getAvatar();
        $id = $user->getId();

        $stmt->bind_param("sssssi", $un, $fn, $ln, $em, $av, $id);
        return $stmt->execute();
    }

    // manager functions
    public function updateRole($id, $newRole) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $newRole, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function isUsernameTaken($username, $excludeId) {
        $conn = Applications::getInstance()->getConexionBd();
        $query = "SELECT id FROM users WHERE username = ? AND id != ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $excludeId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    private function mapDataToDTO($data) {
        return new UserDTO(
            $data['username'],
            $data['password'],
            $data['role'],
            $data['email'],
            $data['first_name'],
            $data['last_name'],
            $data['avatar'],
            $data['id']
        );
    }
}