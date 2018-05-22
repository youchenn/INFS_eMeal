<?php
    session_start();
    $_SESSION["userId"] = 1;
    $con = mysqli_connect("localhost","root","","emeal");
 function fill_size($con)  
 {  
      $output = '';  
      $sql = "SELECT * FROM size";  
      $result = mysqli_query($con, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '<option value="'.$row["sizeId"].'">'.$row["sizeTitle"].'</option>';  
      }  
      return $output;  
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
                echo '<script>window.location="shoppinggeneral.php"</script>';
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

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){

                    $uid = $_SESSION["userId"];
                    $pid = $_GET["id"];
                    $deletecart_query = "DELETE FROM `cart` WHERE `pId` = '$pid' AND `uId` = '$uid'";
                    $delete_result = mysqli_query($con, $deletecart_query);

                    unset($_SESSION["cart"][$keys]);


                    echo '<script>alert("Product has been Removed...!")</script>';
                    echo '<script>window.location="shoppinggeneral.php"</script>';
                }
            }
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
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
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
        })
        
    </script>
</head>
<body>
    <div id="navigation">
        <div id="title">
            <div class="addthis_inline_share_toolbox_20fu"></div>
            <p>e<span>MEAL</span></p>
            <div id="sign">
            <ul>
                <li><a href="#">Sign in</a></li>
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
            <li class="active"><a href="">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
	           <li class="active">Shopping</li>
            </ol>
        </div>
                <div class="col col-md-2">
                    <div class="sidebar">
                        <section class="sidebar-form">
                            <h4>Categories</h4>
                            <label class="checkbox"><input class="bento" type="checkbox" name="checkbox"><i></i>Bento Box</label>
				            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Accessories</label>
				            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Bento Bag</label>
                        </section>
                    </div>
            </div>
            <div class="col col-md-10">
                <div class="shopping-list">
                    <?php
            $query = "SELECT * FROM product ORDER BY productId ASC ";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    ?>
                    <form method="post" action="shoppinggeneral.php?action=add&id=<?php echo $row["productId"]; ?>">
                    <div class="recipe-box">
                        <a href="shoppingdetail.php?item=<?php echo $row["productId"];?>"><img class="recipe-img" src="productimage/<?php echo $row["productImage"];?>" alt=""></a>
                        <p class="recipe-brief"><?php echo $row["productName"];?></p>
                        <p>$<?php echo $row["productPrice"]; ?></p>
                        <div class="quantity_num">
                        <em class="min">-</em>
                        <input type="text" name="quantity" value="1" class="num"/>
                        <em class="add">+</em>
                        </div>
                        <input type="hidden" name="hidden_name" value="<?php echo $row["productName"];?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["productPrice"];?>">
                        <div class="row">
                            <input type="submit" name="add" style="margin-top: 5px;" class="recipe-btn"
                                       value="Add to Cart">                   
                    </div>
                    </div>
                    </form>
                    <?php
                }
            }
                ?>
                </div>
            </div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>

</body>
</html>