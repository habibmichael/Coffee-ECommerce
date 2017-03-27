<?php
/**
 * Created by PhpStorm.
 * User: mh122354
 * Date: 3/23/2017
 * Time: 1:09 PM
 */

include "db.php";

$op = $_POST['op'];

if($op=="add") {
    $id = $_POST['id'];
    $query = "INSERT INTO cart (product_id,quantity) VALUES ('$id','1')";
    mysqli_query($conn, $query);

} else if($op=="del"){
    $id=$_POST['id'];
    $query = "DELETE FROM cart WHERE product_id='$id'";
    mysqli_query($conn,$query);
}

mysqli_close($conn);
