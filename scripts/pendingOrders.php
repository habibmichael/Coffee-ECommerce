<?php
session_start();
if(($_SESSION['username']=='' &&!($_SESSION['login']))|| $_SESSION['username']=='Customer'){
    header("Location: login.html");
}

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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="../public/barista-home.php">Tsarbucks</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../public/barista-home.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../scripts/pendingOrders.php">Pending Orders</a>
                </li>
                <li class="nav-item">
                    <p class="navbar-text">Welcome, Barista!</p>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>Pending Orders</h1>

    <?php



    for($i=0;$i< sizeof($orders);$i++){

        $orderNum = $i+1;

        $query = "SELECT orders.order_id,products.display_name,orders.product_id,products.size,products.price,orders.completed,orders.quantity
              FROM products RIGHT JOIN orders ON orders.product_id=products.product_id
              WHERE orders.order_id='$orderNum'";
        $result = mysqli_query($conn,$query);



        echo "<div  id='order_num'class='row'><h2>Order ".$orderNum." for Customer</h2></div>";
        echo "<table class='table'>";
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
                $data = "<td><button id=".$row['product_id']." class='btn btn-success'>Mark as Complete</button></td>";
            }else{
                $status='completed';
                $data ="<td id='status'><span class='badge badge-success'>".$status."</span></td>";
            }

            echo "<tr class=".$orderNum.">";
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
    var socket = io('http://localhost:3000');
    socket.on('updatedStatus',function (data) {
        console.log(data);
    });
    socket.on('news',function(data){
        console.log(data);
    });
    $(".btn-success").click(function () {
        var id = this.id;
        var $tr = $(this).closest("tr");
        var order_id = $tr.attr('class');
        $.ajax({
            url:'completeOrder.php',
            data:{
                id:id,
                order_id:order_id
            },
            type:'post',
            success: function(res){
                var buttonData = JSON.stringify($(this)[0].data);
                var pattern = /\d+/g;
                var match = buttonData.match(pattern);
                console.log(buttonData);
                console.log(match);
                socket.emit('completed',match);
                $tr.find(".btn").replaceWith("<span class='badge badge-success'>completed</span>");


            }

        });
    });
</script>
</body>
</html>
