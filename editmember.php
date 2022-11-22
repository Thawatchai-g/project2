<?php 
    include "connect.php";
    session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>แก้ไขข้อมูล</title>
        <style>
            body {margin: 0; font-family: Arial, Helvetica, sans-serif;}
            * {box-sizing: border-box}

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

            /* Create two equal columns that floats next to each other */
            .column {
                float: left;
                width: 50%;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            /* Full-width input fields */
            input[type=text], input[type=password] {
                width: 100%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus, input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }

            hr {
                border: 1px solid #f1f1f1;
                margin-bottom: 25px;
            }

            /* Set a style for all buttons */
            button {
                background-color: black;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            button:hover {
                opacity:1;
            }

            /* Float cancel and signup buttons and add an equal width */
            .cancelbtn, .signupbtn {
                float: left;
                width: 50%;
            }

            /* Add padding to container elements */
            .container {
                padding: 40px 10px 80px 80px;
            }

            /* Clear floats */
            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }

            /* Change styles for cancel button and signup button on extra small screens */
            @media screen and (max-width: 300px) {
                .cancelbtn, .signupbtn {
                    width: 100%;
                }
            }
        </style>
    </head> 
    <body>
        <div class="headertop">
            <div class="headertop-right">
                <a href="home.php">หน้าหลัก</a>
                <?php
                if (!empty($_SESSION["cart"])) {
                ?>
                    <a href="showcart.php?action=">ตะกร้าสินค้า(<?=sizeof($_SESSION['cart'])?>)</a>
                <?php } ?>
            </div>
        </div>
        <form method="post" action="register.php">
            <div class="container" style="padding: 60px 100px 0px 100px">
                <h1>Edit</h1>
                <p>กรอกข้อมูลเพื่อแก้ไขข้อมูลสมาชิก</p>
                <hr>
            </div>
            <?php
                $stmt = $pdo->prepare("SELECT * FROM member WHERE username LIKE ?");
                $value = '%'.$_GET["username"].'%';
                $stmt->bindParam(1,$value);
                $stmt->execute();
            ?>
            <div style="display:flex">
            <?php while($row = $stmt->fetch()): ?>
                <div class="column" style="padding: 40px 40px 80px 80px">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="ชื่อผู้ใช้" name="username" value="<?=$row["username"]?>" required>

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="รหัสผ่าน" name="password" value="<?=$row["password"]?>" required>

                    <label for="fnamet"><b>Full Name</b></label>
                    <input type="text" placeholder="ชื่อ" name="fname" value="<?=$row["fname"]?>" required>

                    <label for="lname"><b>Last Name</b></label>
                    <input type="text" placeholder="นามสกุล" name="lname" value="<?=$row["lname"]?>" required>
                </div>
                <div class="column" style="padding: 40px 80px 80px 40px">
                    <label for="Adress"><b>Address</b></label>
                    <input type="text" placeholder="ที่อยู่" name="address" value="<?=$row["address"]?>" required>
                    
                    <label for="mobile"><b>Mobile</b></label>
                    <input type="text" pattern="(0|[+]66)\d{9}" placeholder="เบอร์โทรศัพท์" name="mobile" value="<?=$row["mobile"]?>" required>

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="ที่อยู่อีเมล" name="email" value="<?=$row["email"]?>" required>

                    <div class="clearfix">
                        <button type="submit" class="signupbtn">แก้ไขข้อมูล</button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </form>

    </body>
</html>
