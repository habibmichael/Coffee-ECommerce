<?php

include "db.php";

$query = "SELECT orders.order_id,products.display_name,orders.product_id,products.size,products.price,orders.completed,orders.quantity
          FROM products RIGHT JOIN orders ON orders.product_id=products.product_id";
$result = mysqli_query($conn,$query);

$orders =[];

while($row = mysqli_fetch_array($result)){


    array_push($orders,$row['order_id']);
}
$orders = array_unique($orders);

$totalSize=0;
$totalCost=0;


?>


<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="../public/customer-home.html">Tsarbucks</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../public/customer-home.html">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php">Menu</a>
                </li>
                <li class="nav-item active">
                    <a href="customerOrders.php" class="nav-link">My Orders</a>
                </li>
                <li class="nav-item">
                    <p class="navbar-text">Welcome, Customer!</p>
                </li>
                <li class="nav-item">
                    <a href="cart.php"class="nav-link">My Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>My Orders</h1>

    <?php



        for($i=0;$i< sizeof($orders);$i++){

            $orderNum = $i+1;

            $query = "SELECT orders.order_id,products.display_name,orders.product_id,products.size,products.price,orders.completed,orders.quantity
              FROM products RIGHT JOIN orders ON orders.product_id=products.product_id
              WHERE orders.order_id='$orderNum'";
            $result = mysqli_query($conn,$query);



            echo "<div  id='order_num'class='row'><h2>Order ".$orderNum."</h2></div>";
            echo "<table class='$orderNum table'>";
            echo "<th>Product Name</th>";
            echo "<th>Size(oz)</th>";
            echo "<th>Quantity</th>";
            echo "<th>Price</th>";
            echo "<th>Status</th>";



            while($row=mysqli_fetch_array($result)){

                $totalCost+=$row['price'];
                $totalSize+=$row['size'];


                if($row['completed']==0){
                    $status='pending';
                    $data = "<td class=".$row['product_id']."><span class='badge badge-default'>".$status."</span></td>";
                }else{
                    $status='completed';
                    $data ="<td class=".$row['product_id']."><span class='badge badge-success'>".$status."</span></td>";
                }

                echo "<tr class=".$row['product_id'].">";
                echo "<td>".$row['display_name']."</td>";
                echo "<td>".$row['size']." oz</td>";
                echo "<td>".$row['quantity']."</td>";
                echo "<td>$".$row['price']."</td>";
                echo $data;
                echo "</tr>";

            }
            $totalCost=number_format((float)$totalCost, 2, '.', '');

            echo "</table>";
            echo "<div class='row'><div class='col-md-3 offset-9'>";
            echo "<strong>Total Cost: </strong>$".$totalCost;
            echo "<br/><strong>Total Size: </strong>".$totalSize." oz</div></div>";
            $totalCost=0;
            $totalSize=0;
        }

    ?>



</div>
<script src="jquery-3.2.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
<script src="../tether-1.3.3/dist/js/tether.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
    client={
        id:''
    };
    var socket = io('http://localhost:3000');
    socket.on('hello',function(data){
        console.log(data);
        socket.emit('customer',data);
    });
    socket.on('updateStatus',function(data){
        var orderId = data.orderId;
        var prodId = data.prodId;

        $table = $("table."+orderId);
        $td = $table.find("td."+prodId);
        $td.html("<span class='badge badge-success'>completed</span>");





    });

</script>
</body>
</html>
