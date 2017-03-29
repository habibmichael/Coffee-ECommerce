<?php
session_start();
if(($_SESSION['username']=='' &&!($_SESSION['login']))|| $_SESSION['username']=='Barista'){
    header("Location: ../public/login.html");
}


include "db.php";
$query = "SELECT display_name,price,product_id,size FROM products";
$result = mysqli_query($conn,$query);

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
        <a class="navbar-brand" href="../public/customer-home.php">Tsarbucks</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../public/customer-home.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a href="customerOrders.php" class="nav-link">My Orders</a>
                </li>
                <li class="nav-item">
                    <p class="navbar-text">Welcome, Customer!</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">My Cart</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-2">
            <h1 id="menu-title">Menu</h1>
        </div>
        <div  id="cart-alert"class="col-md-6">
            <div class="alert alert-success align-content-center">

            </div>
        </div>
    </div>
    <table class="table">

        <th>Product Name</th>
        <th>Price</th>
        <th>Size(oz)</th>
        <th></th>

        <?php
        while($row = mysqli_fetch_array($result)){

            echo "<tr>";
            echo "<td id='display-name'>".$row['display_name']."</td>";
            echo "<td>$".$row['price']."</td>";
            echo "<td>".$row['size']."</td>";
            echo "<td><button id=".$row['product_id']." class='btn btn-primary'>Add to Cart</button></td>";
            echo "</tr>";

        }

        ?>
    </table>

    <?php
    $query = "SELECT order_id FROM orders ORDER BY order_id DESC";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0){

        $row = mysqli_fetch_array($result);
        $orderId=$row['order_id']+1;
        echo $orderId;
    }else{

        $orderId =1;
    }

    ?>

</div>
<script src="../scripts/jquery-3.2.0.js"></script>
<script src="../tether-1.3.3/dist/js/tether.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>

    $alert = $(".alert-success");
    $alert.hide();
    var order_id = parseInt(<?php echo $orderId; ?>);

    $(".btn").click(function(){
        var id = this.id;
        $tr = $(this).closest("tr");
        $displayName = $tr.find("#display-name").text();
        $.ajax({
            url:'updateCart.php',
            data:{
                id:id,
                op:"add",
                orderId:order_id
            },
            type:'post',
            success: function(){


                $alert.html($displayName+' Added to Cart');
                $alert.fadeIn(1000,function(){
                    $alert.fadeOut(1000,function () {});
                });

           }


        });

    });

</script>
</body>
</html>
