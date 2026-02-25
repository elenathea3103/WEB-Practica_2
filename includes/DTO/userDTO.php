<?php

 // used to transfer data between the database (DAO) and the interface (views)

class UserDTO {
    // properties matching the 'users' table columns 
    private $id;
    private $username;
    private $password;
    private $role;
    private $email;
    private $firstName;
    private $lastName;
    private $avatar;

    // constructor to initialize a user object

    public function __construct($username, $password, $role, $email, $firstName, $lastName, $avatar, $id = null) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->avatar = $avatar;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getAvatar() {
        return $this->avatar;
    }
    
    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }
}