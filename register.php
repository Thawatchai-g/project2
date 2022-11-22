<?php include "connect.php" ?>
<?php
    $stmt = $pdo -> prepare("INSERT INTO member VALUES(?,?,?,?,?,?,?,?) ");
    $stmt -> bindParam(1,$_POST["username"]);
    $stmt -> bindParam(2,$_POST["password"]);
    $stmt -> bindParam(3,$_POST["fname"]);
    $stmt -> bindParam(4,$_POST["lname"]);
    $stmt -> bindParam(5,$_POST["address"]);
    $stmt -> bindParam(6,$_POST["mobile"]);
    $stmt -> bindParam(7,$_POST["email"]);
    $stmt -> bindParam(8,$_POST["status"]);
    $stmt -> execute();
    header("location: home.php");
?>
   
