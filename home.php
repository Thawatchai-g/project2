<?php 
    include "connect.php";
    session_start();
    function formatMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else { break; }
        }
        return $number;
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ร้านค้าอย่างเป็นทางการของ Sneakers</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }

            .headertop {
                overflow: hidden;
                background: #f1f1f1;
                padding-right: 10px;
            }

            .headertop a {
                float: left;
                color: black;
                text-align: center;
                padding: 12px;
                text-decoration: none;
                font-size: 13px; 
                line-height: 10px;
                border-radius: 4px;
            }

            .headertop a:hover {
                background-color: #ddd;
            }

            .headertop-right {
                float: right;
            }

            .header {
                overflow: hidden;
                padding: 10px 10px 80px 35px;
            }

            .header a {
                float: left;
                color: black;
                text-align: center;
                padding: 12px;
                text-decoration: none;
                font-size: 18px; 
                line-height: 25px;
                border-radius: 4px;
            }

            .header a.logo {
                font-size: 25px;
                font-weight: bold;
            }

            .header a:hover {
                background-color: #ddd;
                color: black;
            }

            .header-center {
                display: flex;
                justify-content: center;
            }

            @media screen and (max-width: 500px) {
            .header a {
                float: none;
                display: block;
                text-align: left;
            }
            
            .header-right {
                float: none;
            }
            }

            .topnav {
                overflow: hidden;
                background-color: white;
            }

            .topnav a {
                float: left;
                display: block;
                color: black;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }

            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }

            .topnav .search-container {
                float: right;
            }

            .topnav input[type=text] {
                padding: 6px;
                margin-top: 8px;
                font-size: 17px;
                border: none;
            }

            .topnav .search-container button {
                float: right;
                padding: 6px 10px;
                margin-top: 8px;
                margin-right: 16px;
                background: #ddd;
                font-size: 17px;
                border: none;
                cursor: pointer;
            }

            .topnav .search-container button:hover {
                background: #ccc;
            }

            @media screen and (max-width: 600px) {
            .topnav .search-container {
                float: none;
            }
            .topnav a, .topnav input[type=text], .topnav .search-container button {
                float: none;
                display: block;
                text-align: left;
                width: 100%;
                margin: 0;
                padding: 14px;
            }
            .topnav input[type=text] {
                border: 1px solid #ccc;  
            }
            }
        </style>
    </head>
    <body>
        <div class="headertop">
            <div class="headertop-right">
                <?php
                if (!empty($_SESSION["username"])) {
                ?>
                    <a href="about.php?username=<?=$_SESSION["username"]?>">Hi <b><?=$_SESSION["username"]?></b></a>
                <?php } ?>
                <?php
                if (empty($_SESSION["username"])) {
                ?>
                    <a href="signup.php">สมัครสมาชิก</a>
                    <a href="signin.php">เข้าสู่ระบบ</a>
                <?php } ?>
                <?php
                if (!empty($_SESSION["cart"])) {
                ?>
                    <a href="showcart.php?action=">ตะกร้าสินค้า(<?=sizeof($_SESSION['cart'])?>)</a>
                <?php } ?>
            </div>
        </div>

        <div class="header">
            <!-- <a href="" class="logo">Sneakers</a> -->
            <div class="header-center">
                <a href="home.php">show all</a>
                <a href="home.php?ptype=basketball">basketball</a>
                <a href="home.php?ptype=running">running</a>
                <a href="home.php?ptype=tennis">tennis</a>
            </div>
        </div>

        <div class="topnav">
            <div class="search-container">
                <form method="post" action="home.php">
                    <input type="text" placeholder="Search.." name="pname">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>

        <?php
            if(!empty($_GET)) {
                $stmt = $pdo->prepare("SELECT * FROM product WHERE ptype LIKE ?");
                $value = '%'.$_GET["ptype"].'%';
                $stmt->bindParam(1,$value);
            } else if(!empty($_POST)) {
                $stmt = $pdo->prepare("SELECT * FROM product WHERE pname LIKE ?");
                $value = '%'.$_POST["pname"].'%';
                $stmt->bindParam(1,$value);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM product");
            }
            
            $stmt->execute();
            while ($row = $stmt->fetch()):
        ?>
        <div style="display:flex">
            <div style="padding: 15px 15px 15px 20px; text-align: center">
                <a href="detail.php?pid=<?=$row["pid"]?>&pname=<?=$row["pname"]?>">
                    <div style="padding: 15px; text-align: center">
                        <img src='img/<?=$row["pid"]?>.jpg' width='240'></a><br>
                    </div>
                <?=$row["pname"]?><br><?=$row["ptype"]?><br><br><?=formatMoney($row["price"])?> บาท
            </div>
            <?php endwhile; ?>
            </div>
        </div>
    </body>
</html>