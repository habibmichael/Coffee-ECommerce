<?php
/**
 * Created by PhpStorm.
 * User: mh122354
 * Date: 3/27/2017
 * Time: 1:42 PM
 */


include "db.php";

//$id = $_POST['id'];
//$query = "INSERT INTO orders (product_id,quantity) VALUES ('$id','1')";
//mysqli_query($conn, $query);

$query =" SELECT * FROM cart";
$result=mysqli_query($conn,$query);

while($cart_row = mysqli_fetch_array($result)){
    $order_id = $cart_row['order_id'];
    $product_id=$cart_row['product_id'];
    $user_id=$cart_row['user_id'];
    $quantity=$cart_row['quantity'];

    $order_query = "INSERT INTO orders (product_id,quantity,user_id,order_id,completed) VALUES('$product_id','$quantity',
                    '$user_id','$order_id',0)";

    $cart_query ="DELETE FROM cart where user_id='$user_id' AND order_id='$order_id' AND product_id='$product_id'";

    mysqli_query($conn,$order_query);
    mysqli_query($conn,$cart_query);

}

mysqli_close($conn);
header("Location: customerOrders.php");

?>

