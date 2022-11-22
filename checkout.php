<?php 
    include "connect.php";
  
    session_start();
    $totalquantity = 0;
    $totalprice  = 0;
    if(isset($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $item) {
            $totalquantity += $item["qty"];
            $totalprice += ($item["price"] * $item["qty"]);
        }
    }
    if(isset($_SESSION["username"]) and isset($_SESSION["cart"])) {
        $myjson = json_encode($_SESSION["cart"]);
        $username = json_encode($_SESSION["username"]);

        $insert = "INSERT INTO orders VALUES('','$username','$totalprice')";
        header("location: home.php");
        session_destroy();

    } else {
        header("location: signin.php");
    }
?>