<?php
  include "connect.php";
  
  session_start();

  $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ? AND password = ?");
  $stmt->bindParam(1, $_POST["username"]);
  $stmt->bindParam(2, $_POST["password"]);
  $stmt->execute();
  $row = $stmt->fetch();

  if (!empty($row)) { 
    $_SESSION["fullname"] = $row["fname"];   
    $_SESSION["username"] = $row["username"];

    header("location: home.php");

  } else {
    header("location: signin.php"); 
  }
?>