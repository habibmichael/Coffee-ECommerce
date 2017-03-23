<?php
/**
 * Created by PhpStorm.
 * User: mh122354
 * Date: 3/23/2017
 * Time: 1:09 PM
 */

include "db.php";

$id = $_POST['id'];
$query = "INSERT INTO orders (product_id,quantity) VALUES ('$id','1')";
mysqli_query($conn,$query);
mysqli_close($conn);
