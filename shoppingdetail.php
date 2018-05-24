<?php
    include "includes/db.php";
    session_start();
    $con = mysqli_connect("localhost","root","","emeal");
    $sql = "SELECT * FROM user";
    $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result)){
            if($_SESSION['user']== $row['userEmail'])
            {
                $_SESSION['user']=$row['userNickname'];
            }
        }
    if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            $uid = $_SESSION["userId"];
            $pid = $_GET["id"];
            $qty = $_POST["quantity"];
            $ipadd = "thisistheipaddress";

            //check if item exists
            $getqty_query = "SELECT * FROM `cart` WHERE pId = '$pid'";
            $getqty_result = mysqli_query($con, $getqty_query);
            $getqtyrow = mysqli_fetch_array($getqty_result);

            if($getqtyrow<1){
                $addtocart_query = "INSERT INTO `cart` (`pId`, `uId`, `quantity`, `ipAdd`) VALUES ('$pid','$uid' , '$qty', '$ipadd')";
                $result = mysqli_query($con, $addtocart_query);
            }
            else {
                $oldqty = $getqtyrow["quantity"];
                $updatecart_query = "UPDATE `cart` SET `quantity`=$oldqty+$qty WHERE pId = '$pid'";
                $updatecart_result = mysqli_query($con, $updatecart_query);
                echo '<script>alert("Product is updated in the Cart")</script>';
                echo '<script>window.location="shoppingdetail.php?item='.$pid.'</script>';
            }
                
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
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
    <script type="text/javascript" src="js/main.js"></script>
    <script>
        $(document).ready(function(){
            $(".add").click(function(){
                var n=$(this).prev().val();
                var num=parseInt(n)+1;
                if(num==0){
                    return;
                }
                $(this).prev().val(num);
            });
            $(".min").click(function(){
                var n=$(this).next().val();
                var num=parseInt(n)-1;
                if(num==0){ return}
                $(this).next().val(num);
            });
            $("#user").hide();
        });
        <?php if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
            $(document).ready(function(){
                $("#sign").hide(); 
                $("#user").show();
                });
        <?php }?>
    </script>
</head>
<body>
  <input class="getUser" type="hidden" name="hidden_id" value="<?php echo $_SESSION['user']?>">
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
                    <li>
                        Welcome, <a><?php echo $_SESSION['user']?></a>                           
                            <ul class="subnav2">
                                <li><a href="userProfile.php">Profile</a></li>
                                <li><a href="includes/logout.php">Log out</a></li>
                            </ul>
                    </li>                
                </ul>
            </div>
        </div>
        <ul id="nav">
            <li><a href="homepage.php">HOME</a>
            <li><?php echo"<a href='recipegeneral.php?cate=all'>STYLE</a>"?>
                <ul class="subnav">
                   <?php 
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($result)){
                            echo '<li><a href="recipegeneral.php?cate='.$row["category"].'" name="categoryname" value=>' .$row["category"].'</a></li>';
                        }
                    ?>
                </ul>
            </li>
            <li><?php echo"<a href='recipegeneral.php?pur=all'>PURPOSE</a>"?>
                <ul class="subnav">
                   <?php 
                        $sql = "SELECT * FROM purpose";
                        $result = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($result)){
                            echo '<li><a href="recipegeneral.php?pur='.$row["purposeName"].'">' .$row["purposeName"].'</a></li>';
                        }
                    ?>
                </ul>
            </li>
            <li><?php echo"<a href='recipegeneral.php?size=all'>SIZE</a>"?>
                <ul class="subnav">
                    <?php 
                        $sql = "SELECT * FROM size";
                        $result = mysqli_query($con, $sql);
                        while($row = 
                        mysqli_fetch_array($result)){
                            echo '<li><a href="recipegeneral.php?size='.$row["sizeTitle"].'">' .$row["sizeTitle"].'</a></li>';   
                        }
                    ?>
                </ul>
            </li>
            <li><a class="active" href="shoppinggeneral.php">SHOPPING</a></li>
        </ul>
        <div id="shoppingcart">
           <a href="shoppingcart.php">
            <img src="img/713b83a7ab70e1a79d66d49efc33aff6.png">
            <p>Shopping cart</p>
            </a>
        </div>
    </div>
    <form method="post" action="shoppingdetail.php?item=<?php echo $_GET['item'];?>action=add&id=<?php echo $_GET['item']; ?>">
    <?php
        if(isset($_GET['item'])){
        $sql = "SELECT * FROM product WHERE productID = '$_GET[item]'";
        $result = mysqli_query($con, $sql);
        while($row=mysqli_fetch_array($result)){?>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
               <li><a href="shoppinggeneral.php">Shopping</a></li>
	           <li class="active"><?php echo $row["productName"]?></li>
            </ol>
        </div>
        <div class="detail-page">
            <div class="row">
                <div class="col-md-5">
                    <div class="img-wrapper">
                    <img class="item-img" src="productimage/<?php echo $row["productImage"];?>" alt="itemImg">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="right_detail">
                    <h3 class="item_name"><?php echo $row["productName"]?></h3>
                    <p class="dollar_sign">&#36;</p><p class="item_price"><?php echo $row["productPrice"]?></p>
                    <P class="quantity">Quantity</P>
                    <div class="quantity_num">
                        <em class="min">-</em>
                        <input name="quantity" type="text" value="1" class="num"/>
                        <em class="add">+</em>
                    </div>
                    <input class="getID" type="hidden" name="hidden_id" value="<?php echo $row["productId"];?>">
                    <input type="hidden" name="hidden_name" value="<?php echo $row["productName"];?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["productPrice"];?>">
                    <input type="submit" name="add" style="margin-top: 5px;" class="recipe-btn" value="Add to Cart">
                    </div>
                </div>
            </div>
            <div class="clearfloat"></div>
            <div id="goods_detail">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#description" data-toggle="tab">
                            Description
                        </a>
                    </li>
                    <li>
                        <a href="#reviews" data-toggle="tab">Reviews</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="description">
                        <p><?php echo $row["productDetails"]?></p>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <p>Review</p>
                        <textarea class="review"></textarea>
                        <input type="hidden" class="date" name="hidden_name" value="<?php date_default_timezone_set('Australia/Brisbane');
                        echo date('Y-m-d');
                        ?>">
                        <button class="signup-submit reviewSubmit">Submit</button>
                        <div class="comment_list">
                        <div id="get_productReview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfloat"></div>
    </div>
                               <?php
                        }
            }
        ?>
    </form>
    <div id="footer">
        <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>
    

</body>
</html>