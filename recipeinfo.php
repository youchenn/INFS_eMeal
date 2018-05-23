<?php
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
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    <script>
        $(function (){
            $(".like").click(function(){
                var input = $(this).find('.count');
                input.val(parseInt(input.val())+1);
            })
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
                        while($row = 
                        mysqli_fetch_array($result)){
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
            <li><a href="shoppinggeneral.html">SHOPPING</a></li>
        </ul>
        <form id="search-form" method="post" >
            <input type="text" placeholder="Search Here" />
        </form>
    </div>
    <form method="post" action="recipeinfo.php?id=<?php echo $_GET['recipe'];?>">
        <?php if(isset($_GET['recipe'])){
        $sql = "SELECT * FROM recipe WHERE recipeId = '$_GET[recipe]'";
        $result = mysqli_query($connect, $sql);
        while($row=mysqli_fetch_array($result))
        {?>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
                <li><a href="recipegeneral.html">Recipe</a></li>
                <li class="active"><?php echo $row["recipeName"];?></li>
            </ol>
        </div>
        <div class="detail-page">
            <div class="row">
                <div class="col-md-5">
                    <div class="img-wrapper">
                        <img class="item-img" src="recipeimage/<?php echo $row["img"];?>" alt="recipeImg">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="right_detail">
                        <h3 class="recipe_name"><?php echo $row["recipeName"]?></h3>
                        <button class="like">
                            <img class="like-img" src="img/Like.png">
                            <i class="fa fa-thumbs-o-up"></i>Like <input class="count" name="like-count" readonly="readonly" type="text" value="0">
                            <?php echo $row["recipeLikeNum"]?>
                        </button>
                        <table class="recipe_info">
                            <tr>
                                <td>Author:</td>
                                <td><?php 
                                    $userId = $row["userId"];
                                    $query = "SELECT userNickname FROM user WHERE userId = '$userId'";
                                    $author = mysqli_query($connect, $query);
                                    $authorname = mysqli_fetch_array($author);
                                    echo $authorname["userNickname"];
                                    ?></td>
                            </tr>
                            <tr>
                                <td>Date:</td>
                                <td><?php echo $row["recipeTime"]?></td>
                            </tr>
                            <tr>
                                <td>Size:</td>
                                <td><?php echo $row["recipeSize"]?>ml</td>
                            </tr>
                            <tr>
                                <td>Style:</td>
                                <td><?php echo $row["recipeCategory"]?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfloat"></div>
            <div id="goods_detail">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#description" data-toggle="tab">Details</a>
                    </li>
                    <li>
                        <a href="#reviews" data-toggle="tab">Comments</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="description">
                        <p><?php echo $row["recipeContent"]?></p>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <p>Nickname</p>
                        <input class="login-input" onfocus="this.value=''" onblur="this.value='Please enter your nickname'" value="Please enter your nickname">
                        <p>Comment:</p>
                        <textarea onfocus="this value=''" onblur="this.value='Please leave your comment...'">Please leave your comment here ...</textarea>
                        <input class="signup-submit" type="submit">
                        <div class="comment_list">
                            <div class="comment_box">
                                <div class="comment_detail">
                                    <p class="comment_name">John Doe</p>
                                    <p class="comment_date">16 May, 2018</p>
                                    <p class="comment_content">Good recipe!</p>
                                </div>
                            </div>
                            <div class="comment_box">
                                <div class="comment_detail">
                                    <p class="comment_name">John Doe</p>
                                    <p class="comment_date">16 May, 2018</p>
                                    <p class="comment_content">Good recipe!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="viewrecipe">
            <h4>Related recipe:</h4>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
            <div class="recipe-bottom">
                <img src="img/school-lunch1.jpg">
                <p><a class="recipename" href="recipeinfo.html">Simple tortilla rolls</a></p>
            </div>
        </div>     
        <div class="clearfloat"></div>
    </div>
        <?php
        }
        }?>
    </form>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
        </div>
</body>
</html>