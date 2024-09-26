<?php
include("configs/DBConnection.php");
include("models/User.php");

class UserService {
    public function getAllUsers() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT ma_user, username, password FROM users ORDER BY ma_user ASC";
        $stmt = $conn->query($sql);

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['ma_user'], $row['username'], $row['password']);
            array_push($users, $user);
        }

        return $users;
    }

    public function addUser($username, $password) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $passwordHash);

        return $stmt->execute();
    }

    public function getUserById($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT ma_user, username, password FROM users WHERE ma_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['ma_user'], $row['username'], $row['password']);
        }

        return null;
    }

    public function getUserByUsername($username) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT ma_user, username, password FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['ma_user'], $row['username'], $row['password']);
        }

        return null;
    }

    public function updateUser($id, $username, $password = null) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE users SET username = :username";
        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }
        $sql .= " WHERE ma_user = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username);
        if ($password) {
            $stmt->bindValue(':password', $passwordHash);
        }
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public function deleteUser($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "DELETE FROM users WHERE ma_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
?>