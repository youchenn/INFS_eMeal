<?php
    session_start();
    $_SESSION["userId"] = 1;
    $con = mysqli_connect("localhost","root","","emeal");
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
        });
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
                <li><a href="#">Sign up</a></li>
            </ul>
            </div>
        </div>
        <ul id="nav">
            <li><a href="homepage.php">HOME</a>
            <li><a href="">STYLE</a>
                <ul class="subnav">
                    <li><a href="#">Western</a></li>
                    <li><a href="#">Chinese</a></li>
                    <li><a href="#">Japanese</a></li>
                </ul>
            </li>
            <li><a href="">PURPOSE</a>
                <ul class="subnav">
                    <li><a href="#">Fitness</a></li>
                    <li><a href="#">Meat lover</a></li>
                    <li><a href="#">Vegetarian</a></li>
                </ul>
            </li>
            <li><a href="">BOX SIZE</a></li>
            <li class="active"><a href="shoppinggeneral.php">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
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
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <p>Nickname</p>
                        <input class="login-input" onfocus="this.value=''" onblur="this.value='Please enter your nickname'" value="Please enter your nickname">
                        <p>Review</p>
                        <textarea onfocus="this.value=''" onblur="this.value='Please leave your review'">Please leave your review</textarea>
                        <input class="signup-submit" type="submit">
                        <div class="comment_list">
                          <div class="comment_box">
                           <div class="comment_detail">
                           <p class="comment_name">John Doe</p>
                           <p class="comment_date">15 May, 2018</p>
                           <p class="comment_content">Good product！</p> 
                              </div>
                           </div>
                           <div class="comment_box">
                           <div class="comment_detail">
                           <p class="comment_name">John Doe</p>
                           <p class="comment_date">15 May, 2018</p>
                           <p class="comment_content">Good product！</p> 
                              </div>
                           </div>
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