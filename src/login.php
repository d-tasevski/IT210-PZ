<?php
require_once('common/connection.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $conn = connect();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = md5($password);

    $stmt = $conn->prepare("SELECT * FROM clients WHERE email=:email AND password=:password");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    $row = $stmt->fetch();

    if ($row) {
        session_start();
        $_SESSION["id"] = $row["id"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["name"] = $row["name"];
        header("Location: ../public/index.php");
    } else {
        header("Location: ../public/pages/login.php?fail=1");
    }
}
