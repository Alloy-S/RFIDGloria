<?php
session_start();
require_once('../conn.php');

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username=:username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $countData = $stmt->rowCount();

    if ($countData > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['admin'] = true;
            header("location: ../index.php");
        } else {
            $_SESSION['login_error'] = "Username/Password salah";
            header("location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Username/Password salah";
        header("location: ../login.php");
        exit();
    }
}
?>