<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");  
error_reporting(0);
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
       <?php if($_GET['cate'])
            {?>
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
            <li><a href="homepage.php">HOME</a>
            <li><?php echo"<a href='recipegeneral.php?cate=all' class='active'>STYLE</a>"?>
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
            <li><a href="shoppinggeneral.html">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
            <?php
                    echo "<li><a href='recipegeneral.php?cate=all'>Style</a></li>";
                    echo "<li class='active'>".$_GET[cate]."</li>";
            ?>
            </ol>
        </div>
        <?php 
            if($_GET[cate]=='all'){
                $sql = "SELECT * FROM recipe";
            }
            else{
            $sql = "SELECT * FROM recipe WHERE recipeCategory = '$_GET[cate]'";
            }
            $result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($result)){?>
        <div class="recipe-list">
            <div class="recipe-box">
                <img class="recipe-img" src="<?php echo $row["img"]?>" alt="">
                <p class="recipe-brief"><?php echo $row["recipeName"]?></p>
                <a class="recipe-btn" href="#">More</a>
            </div>
        </div>
        <?php }?>
        <div class="clearfloat"></div>
    </div>
    <?php }else if($_GET['pur'])
    {?>
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
            <li><?php echo"<a class='active' href='recipegeneral.php?pur=all'>PURPOSE</a>"?>
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
            <li><a href="shoppinggeneral.html">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
            <?php
                    echo "<li><a href='recipegeneral.php?pur=all'>Purpose</a></li>";
                    echo "<li class='active'>".$_GET[pur]."</li>";
            ?>
            </ol>
        </div>
        <?php 
        if($_GET[pur]=='all'){
            $sql = "SELECT * FROM recipe";
        }else{
        $sql = "SELECT * FROM recipe WHERE Purpose = '$_GET[pur]'";
        }
            $result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($result)){?>
        <div class="recipe-list">
            <div class="recipe-box">
                <img class="recipe-img" src="<?php echo $row["img"]?>" alt="">
                <p class="recipe-brief"><?php echo $row["recipeName"]?></p>
                <a class="recipe-btn" href="#">More</a>
            </div>
        </div>
        <?php }?>
        <div class="clearfloat"></div>
    </div>
    <?php }else if($_GET['size'])
    {?>
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
            <li><?php echo"<a class='active' href='recipegeneral.php?size=all'>SIZE</a>"?>
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
            <li><a href="shoppinggeneral.html">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
            <?php
                    echo "<li><a href='recipegeneral.php?size=all'>Size</a></li>";
                    echo "<li class='active'>".$_GET[size]."</li>";
            ?>
            </ol>
        </div>
        <?php 
        if($_GET[size]=='all'){
            $sql="SELECT * FROM recipe";
        }else{
            $sql = "SELECT * FROM recipe WHERE recipeSize = '$_GET[size]'";
        }
            $result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($result)){?>
        <div class="recipe-list">
            <div class="recipe-box">
                <img class="recipe-img" src="<?php echo $row["img"]?>" alt="">
                <p class="recipe-brief"><?php echo $row["recipeName"]?></p>
                <a class="recipe-btn" href="#">More</a>
            </div>
        </div>
        <?php }?>
        <div class="clearfloat"></div>
    </div>
    <?php }?>
    
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>
    

</body>
</html>