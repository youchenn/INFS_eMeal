<?php
session_start();
if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
    echo "Login successfully " .$_SESSION['user'];
}else{
    echo "Login failed";
}

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
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/banner.js"></script>
    <script type="text/javascript">
       $(document).ready(function(){
           $("#user").hide();
       });
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
                    <li><a href="signup.html">Sign up</a></li>
                </ul>
            </div>
            <div id="user">
                <ul>
                    <li>
                       <?php 
                        $sql = "SELECT * FROM user";
                        $result = mysqli_query($connect, $sql);
                        while($row = mysqli_fetch_array($result)){
                        if($_SESSION['user']== $row['userEmail'])
                            {
                                $_SESSION['user']=$row['userNickname'];
                            }
                        }
                        ?>
                        Welcome, <a><?php echo $_SESSION['user']?></a>
                            <ul class="subnav2">
                                <li><a href="userProfile.html">Profile</a></li>
                                <li><a href="includes/logout.php">Log out</a></li>
                            </ul>
                    </li>                
                </ul>
            </div>
        </div>
        
        <ul id="nav">
            <li class="active"><a href="homepage.php">HOME</a>
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
            <li><a href="shoppinggeneral.php">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <div class="banner">
        <div class="slider">
            <img class="img im" src="img/school-lunches-social.jpg">
            <img class="img" src="img/mailchimp-image-26.png">
            <img class="img" src="" alt="">
        </div>
        <div class="dotbar">
        <div class="dot dt"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        </div>
        <div class="btn btn_l">&lt;</div>
        <div class="btn btn_r">&gt;</div>
    </div>
    <div class="white">
        <p class="subtitle">FIND WHAT'S POPULAR</p>
        <p class="title">RECIPE OF THE <span>WEEK</span></p>
        <div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">232342342342343234234234242342\\423432432fafa</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div>
        <div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">1111</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div>
        <div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">1111</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div>
    </div>
    <div class="clearfloat"></div>
    <div class="gray">
        <p class="subtitle">FIND WHAT'S NEW</p>
        <p class="title"><span>LATEST</span> RECIPE</p>
        <div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">1111</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div>
        <div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">1111</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div><div class="recipe-box">
            <p class="autherbox">Auther</p>
            <img class="recipe-img" src="img/mailchimp-image-26.png">
            <p class="recipe-brief">1111</p>
            <a class="recipe-btn" href="#">Detail</a>
        </div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>
</body>
</html>