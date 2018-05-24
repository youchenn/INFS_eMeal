   <?php
    include "includes/db.php";
    session_start();
    $connect = mysqli_connect("localhost", "root", "", "emeal");  
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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript">
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
        <ul id="nav">
            <li><a href="homepage.php">HOME</a>
            <li><?php echo"<a href='recipegeneral.php?cate=all'>STYLE</a>"?>
                <ul class="subnav">
                   <?php 
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($connect, $sql);
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
                        $result = mysqli_query($connect, $sql);
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
                        $result = mysqli_query($connect, $sql);
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
    <div class="gray">
       <div id="product_msg"></div>
        <div class="tabbar">
            <ol class="breadcrumb">
	           <li class="active">Shopping</li>
            </ol>
        </div>
                <div class="col col-md-2">
                <div id="get_size"></div>
            </div>
            <div class="col col-md-10">
                <div class="shopping-list">
                <div id="get_product"></div>
                </div>
            </div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>

</body>
</html>