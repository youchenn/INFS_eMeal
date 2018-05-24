<?php
    session_start();
    $con = mysqli_connect("localhost","root","","emeal");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    <?php  if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
        $(document).ready(function(){
            $("#sign").hide(); 
            $("#user").show();
        });
        <?php }?>
    </script>
</head>
<body>
    <div id="navigation">
        <div id="title">
            <div class="addthis_inline_share_toolbox_20fu"></div>
            <p>e<span>MEAL</span></p>
            <div id="sign">
            <ul>
                <li><a href="login.html">Sign in</a></li>
                <li><a href="signup.php">Sign up</a></li>
            </ul>
            </div>
        <div id="user">
                <ul>
                    <li>Welcome, <a><?php echo $_SESSION['user']?></a>
                        <ul class="subnav2">
                            <li><a href="userProfile.php">Profile</a></li>
                            <li><a href="includes/logout.php">Log out</a></li>
                        </ul>
                    </li>                
                </ul>
            </div>
        </div>
        <div id="get_nav"></div>
        <div id="shoppingcart">
           <a href="shoppingcart.php">
            <img src="img/713b83a7ab70e1a79d66d49efc33aff6.png">
            <p>Shopping cart</p>
            </a>
        </div>
    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
               <li><a href="shoppinggeneral.php">Shopping</a></li>
               <li><a href="shoppingcart.php">Cart</a></li>
	           <li class="active">Information confirmation</li>
            </ol>
        </div>
    
    <div class="detail-page">
    <div id="confirm">
        <div class="list_title">
                <div class="row">
                    <div class="col-md-2"><p>Item</p></div>
                    <div class="col-md-4"><p>Name</p></div>
                    <div class="col-md-2"><p>Price</p></div>
                    <div class="col-md-2"><p>Quantity</p></div>
                    <div class="col-md-2"><p>Total</p>
                    </div>
                </div>
        </div>
  
<?php
                $uid = $_SESSION['userId'];
                $total = 0;
                $retrievefromcart_query = "SELECT a.pId, b.productName, a.quantity, b.productPrice, b.productImage FROM cart a,product b WHERE a.pId = b.productId AND a.uId = '$uid'";
                $totalprice_query = "SELECT SUM(a.quantity * b.productPrice) as Total_Price FROM cart a,product b WHERE a.pId = b.productId AND a.uId = '$uid'";
                $retrieve_result = mysqli_query($con,$retrievefromcart_query);
                $totalprice=mysqli_query($con,$totalprice_query);
                if(mysqli_num_rows($totalprice) > 0){
                    while($total=mysqli_fetch_array($totalprice)){
                        $tnum=$total["Total_Price"];
                    }
                }
                if(mysqli_num_rows($retrieve_result) > 0) {
    
                    while ($cartrow = mysqli_fetch_array($retrieve_result)) {
                        ?>
                <div class="list_box">
                   <input class="getUID" type="hidden" value="<?php echo $uid?>">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="productimage/<?php echo $cartrow["productImage"];?>" alt="Item img">
                        </div>
                        <div class="col-md-4">
                            <p class="item_name"><?php echo $cartrow['productName']; ?></p>
                        </div>
                        <div class="col-md-2"><p>&#36;<?php echo $cartrow['productPrice']; ?></p>
                        </div>
                        <div class="col-md-2">
                            <p><?php echo $cartrow['quantity']; ?></p>
                        </div>
                        <div class="col-md-2">
                            <p>&#36;<?php echo $cartrow['productPrice']*$cartrow['quantity'];?></p>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }?>

        <div class="checkout">
            <div class="check_price">
                <p><span>Total price</span></p>
                <div class="sign_price">
                    <p class="dollar_sign">&#36;</p><p id="price_total"><?php echo $tnum?></p>
                </div>
            </div>
            <div class="clearfloat"></div>
        </div>
    </div>
    <div id="addressinfo">
     <div id="getshipinfo"></div>
    <?php
    $shipquery = "SELECT * FROM user WHERE userId = '$uid'";
    $result =mysqli_query($con, $shipquery);
    if(mysqli_num_rows($result) > 0){
        while($ship=mysqli_fetch_array($result)){
            $name = $ship["userNickname"];
            $address = $ship["userAddress"];
            $postcode = $ship["userPostalcode"];
            $cell = $ship["userContact"];
            $email = $ship["userEmail"];
        }}
    ?>
     <div class="confirm_info">
      <div class="row">
       <div class="col-md-8">
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <p>Name</p>
            </div>
            <div class="col-md-7 col-xs-6">
                <input class="name" type="text" value="<?php echo $name?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <p>Address</p>
            </div>
            <div class="col-md-7 col-xs-6">
                <input class="address" type="text" value="<?php echo $address?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <p>Postcode</p>
            </div>
            <div class="col-md-7 col-xs-6">
                <input class="postcode" type="text" value="<?php echo $postcode?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <p>Cell Number</p>
            </div>
            <div class="col-md-7 col-xs-6">
                <input class="phone" type="text" value="<?php echo $cell?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <p>E-mail</p>
            </div>
            <div class="col-md-7 col-xs-6">
                <input class="email" type="text" value="<?php echo $email?>">
            </div>
            <div class="col-md-3 col-xs-6">
                <input type="button" class="confirm-btn" value="Confirm">
            </div>
        </div>
    </div>
        </div>
        </div>
        <div class="row">
        <div class="checkout">
            <input type="button" class="recipe-btn" value="Check out">
        </div>
        </div>
        <div class="clearfloat"></div>
    </div>
</div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
        <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>
    

</body>
</html>