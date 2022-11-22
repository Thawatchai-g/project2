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
        <title>ตะกร้า Sneakers</title>
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
            <style>
            table { width: 800px; border: solid 1px gray; border-collapse: collapse; font: 16px tahoma; }
            caption { font: bold 18px tahoma; color: brown; }
            th:first-child { width: 10%; }
            th:last-child { width: 30%; }
            td { background: white; }
            th { background: gray; color: white; }
            td, th { border: solid 1px  white; padding: 3px; vertical-align: top; }
        </style>
        <script>
            // ใช้สำหรับปรับปรุงจำนวนสินค้า
            function update(pid) {
                var qty = document.getElementById(pid).value;
                // ส่งรหัสสินค้า และจำนวนไปปรับปรุงใน session
                document.location = "cart.php?action=update&pid=" + pid + "&qty=" + qty; 
            }
        </script>
    </head>
    <body>
        <div class="headertop">
            <div class="headertop-right">
                <a href="home.php">หน้าหลัก</a>
            </div>
        </div>
        <form action="checkout.php">
            <div style="display:flex">
                <div class="column" style="padding: 40px 30px 80px 150px">
                    <p style="font-size:22px" >ตะกร้าสินค้า</p>
                    <hr>
                    <?php
                        $stmt = $pdo->prepare("SELECT * FROM product");
                        $stmt->execute();
                    ?>
                    <table style="padding-bottom: 40px">
                        <?php 
                            $sum = 0;
                            foreach ($_SESSION["cart"] as $item) {
                                $sum += $item["price"] * $item["qty"];
                        ?>
                            <tr>
                                <td><img src='img/<?=$item["pid"]?>.jpg' width='100'></td>
                                <td><?=$item["pname"]?><br><br><?=$item["ptype"]?><br><br><?=$item["psize"]?> US</td>
                                <td><?=formatMoney($item["price"])?></td>
                                <td>			
                                    <input type="number" id="<?=$item["pid"]?>" value="<?=$item["qty"]?>" min="1" max="9">
                                    <a href="#" onclick="update(<?=$item["pid"]?>)">แก้ไข</a>
                                    <a href="cart.php?action=delete&pid=<?=$item["pid"]?>">ลบ</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="column" style="padding: 40px 150px 80px 30px">
                    <p style="font-size:22px" >สรุป</p>
                    <hr>
                    <p>ยอดรวมทั้งหมด <?=formatMoney($sum)?> บาท</p>
                    <p>ฟรีค่าธรรมเนียมการจัดส่งและดำเนินการ</p>
                    <hr>
                    <div class="clearfix">
                        <button type="submit" class="signupbtn">เช็คเอาท์</button>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>