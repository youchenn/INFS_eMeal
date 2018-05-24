<?php
    include "includes/db.php";
    session_start();
    if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
    echo "Login successfully " .$_SESSION['user'];
    $con = mysqli_connect("localhost","root","","emeal");
    $sql = "SELECT * FROM user";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result)){
        if($_SESSION['user']== $row['userEmail'])
        {
            $_SESSION['user']=$row['userNickname'];
        }
    }
    }else{
        echo "Login failed";
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
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/banner.js"></script>
    <script type="text/javascript">
        <?php  if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
        $(document).ready(function(){
            $("#sign").hide(); 
            $("#user").show();
        });
        <?php }?>
    </script>
<!--
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
-->
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
        <div id="get_recipe"></div>
    </div>
    <div class="clearfloat"></div>
        <div class="gray">
        <p class="subtitle">FIND WHAT'S NEW</p>
        <p class="title"><span>LATEST</span> RECIPE</p>
        <div id="get_latest_recipe"></div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>

</body>
</html>