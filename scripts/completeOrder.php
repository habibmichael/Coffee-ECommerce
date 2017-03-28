<?php
/**
 * Created by PhpStorm.
 * User: mh122354
 * Date: 3/28/2017
 * Time: 2:59 PM
 */

include 'db.php';

$id = $_POST['id'];
$order_id=$_POST['order_id'];
$query = "UPDATE orders SET completed='1' WHERE order_id='$order_id' and product_id='$id' LIMIT 1";
mysqli_query($conn,$query);
mysqli_close($conn);
//UPDATE `coffeedb`.`orders` SET `completed`='1' WHERE `order_id`='1' and`user_id`='0' and`product_id`='1';