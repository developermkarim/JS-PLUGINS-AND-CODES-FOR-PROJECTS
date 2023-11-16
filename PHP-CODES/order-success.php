<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* after Order Sucess Page Code Here */
/* body {
    background: rgb(213, 217, 233);
    min-height: 100vh;
    vertical-align: middle;
    display: flex;
    font-family: Muli;
    font-size: 14px
} */

.card {
    margin: auto;
    width: 320px;
    max-width: 600px;
    border-radius: 20px
}

.mt-50{
    margin-top:50px;
}

.mb-50{
    margin-bottom:50px;
}

@media(max-width:767px) {
    .card {
        width: 80%
    }
}

@media(height:1366px) {
    .card {
        width: 75%
    }
}

#orderno {
    padding: 1vh 2vh 0;
    font-size: smaller
}

.gap .col-2 {
    background-color: rgb(213, 217, 233);
    width: 1.2rem;
    padding: 1.2rem;
    margin-top: -2.5rem;
    border-radius: 1.2rem
}

.title {
    display: flex;
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    padding: 12%
}

.main {
    padding: 0 2rem
}

.main img {
    border-radius: 7px
}

.main p {
    margin-bottom: 0;
    font-size: 0.75rem
}

#sub-title p {
    margin: 1vh 0 2vh 0;
    font-size: 1rem
}

.row-main {
    padding: 1.5vh 0;
    align-items: center
}

hr {
    margin: 1rem -1vh;
    border-top: 1px solid rgb(214, 214, 214)
}

.total {
    font-size: 1rem
}

@media(height: 1366px) {
    .main p {
        margin-bottom: 0;
        font-size: 1.2rem
    }

    .total {
        font-size: 1.5rem
    }
}

/* .btn {
    background-color: rgb(3, 122, 219);
    border-color: rgb(3, 122, 219);
    color: white;
    margin: 7vh 0;
    border-radius: 7px;
    width: 60%;
    font-size: 0.8rem;
    padding: 0.8rem;
    justify-content: center
} */

.btn:focus {
    box-shadow: none;
    outline: none;
    box-shadow: none;
    color: white;
    -webkit-box-shadow: none;
    -webkit-user-select: none;
    transition: none
}

.btn:hover {
    color: white
}
    </style>
</head>
<body>
    
<?php

include 'config.php';
session_start();


/* if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'user')
     */
include './header.php';

$db = new Database;

$db->select('orders','*,order_details.price as product_price',' order_details ON orders.id = order_details.order_id JOIN products ON order_details.product_id = products.product_id',"orders.user_id = {$_SESSION['user_id']}");
$order_products = $db->getResult();
// echo count($order_details);
// print_r($order_details);
?>
<div class="card mt-50 mb-50">
    <div class="col d-flex"><span class="text-muted" id="orderno">order <?= $order_products[0]['order_code'];?></span></div>
    <div class="gap">
        <div class="col-2 d-flex mx-auto"> </div>
    </div>
    <div class="title mx-auto"> Thank you for your order! <?php
// Online PHP compiler to run PHP program online
// Print "Hello World!" message
/*  $random = strtoupper('#' .substr(bin2hex(random_bytes(3)), 0, 6));
echo $random; */
?> 
</div>
    <div class="main"> <span id="sub-title">
            <p><b>Payment Summary</b></p>
        </span>         
      <?php
      foreach ($order_products as $key => $order_product):
      ?>
        <div class="row row-main">
            <div class="col-3 "> <img class="img-fluid" src="https://i.imgur.com/hOsIes2.png"> </div>
            <div class="col-6">
                <div class="row d-flex">
                    <p><b><?= $order_product['product_title'];?></b></p>
                </div>
                <div class="row d-flex">
                    <p class="text-muted"><?= strlen($order_product['product_desc']) > 15 ? substr($order_product['product_desc'],0,15) . '...' : $order_product['product_desc'];?></p>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <p><b>$<?= $order_product['product_price'];?></b></p>
            </div>
        </div>
        <?php
        endforeach;
        ?>
        <hr>
        <div class="total">
            <div class="row">
                <div class="col"> <b> Total:</b> </div>
                <div class="col d-flex justify-content-end"> <b>$ <?= $_SESSION['total'];?></b> </div>
            </div> <a href="order-tracking.php" class="btn btn-outline-dark text-center ml-5 my-3" style="cursor:pointer"> Track your order </a>
        </div>
    </div>
</div>


</body>
</html>