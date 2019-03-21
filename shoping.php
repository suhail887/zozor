<?php
    include 'user.php';
    $query2 = "SELECT product,img,price,Id FROM phone ORDER BY Id";
    $result = $connection->query($query2);
?>
<!DOCTYPE html>
<html>
    <head>
    <style>
    div.pro{
        border: 1px solid black;
        margin: 10px;
        padding: 5px
        
    }
    #img{
        margin-left:50px;
    }
    div.cart{
        border: 1px solid black;
        margin: 10px;
        padding: 5px
    }
    div.cart_item{
        border: 1px solid black;
        margin: 10px;
        padding: 5px
    }

    </style>
    </head>
    <body>
        <div id="body">
           
                        <div>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <form method="post" action="shoping.php">
                        <div class="pro">
                        <div class="image">
                            
                           <img id="img" src="<?=$row['img']?>" width='45px' height='45px'>
                        </div>
                        <div class="name">
                        <label>Product Name:</label>
                            <?=$row['product']?>
                             </div>
                        <div> 
                        <label>Product Price:</label>
                        <?=$row['price']?> 
                        </div>
                        <div>
                            <label> Quantity: </label><br>
                            <input type="number" name="quantity" min="1" max="10">
                        </div>
                        <div>
                            <label>AddtoCart</label><br>
                            <input type="submit" name="submit" value="<?=$row['product']?>">
                        </div>
                        </div>
                        </form>
                        <?php endWhile;?>
                    
                        </div>
           
            
        </div>
        <?php
                
                $x=$_POST['submit'];
                $query="SELECT * FROM phone WHERE product='$x'";
                $pro = $connection->query($query);
                $c=$pro->fetch_array();
                $price=$c['Price'];
                $product=$c['product'];
                $quantity=$_POST['quantity'];
               
                function cart($connection,$price,$product,$quantity){
                    $total=$price * $quantity;
                    $query3="INSERT INTO temp_cart (name,price,quantity,total) VALUES ('$product',$price,$quantity,$total)";
                    $temp = $connection->query($query3);
               }
               $query5="SELECT * FROM temp_cart";
               $item = $connection->query($query5);
               $del=$_GET['delete'];

               function delete($connection,$i){
                   $query7="DELETE FROM temp_cart WHERE name='$i'";
                   $connection->query($query7);
               }
               delete($connection,$del);

            ?>
        <div class="cart">
            
                <h1>Cart_Items</h1>
                <div class="insert">
                    <?php cart($connection,$price,$product,$quantity);?>
              
                    <?php while($it= $item->fetch_assoc()):?>
                    <form method="get" action="shoping.php" >
                    <div class="cart_item">
                        <?php echo "Product Name: ".$it['name']."<br> Product Price: ".$it['price']."<br> Product Quantity: ".$it['quantity']."<br> Product Total:".$it['total']?>
                       <div>
                        <input type="submit" name="delete" value="<?=$it['name']?>">
                        </div>
                    </div>
                    <form>
                <?php endWhile;?>
                <form action="cart.php" method="post">
                    <input type="submit" name="cart" value="checkout">
            </form>
            </div>
            
        </div>
    </body>
</html>

<?php
$result->close();
$connection->close();
?>
