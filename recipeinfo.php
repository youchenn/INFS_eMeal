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
    <script src="js/main.js"></script>
    <script type="text/javascript">
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
        <div id="get_nav"></div>
        <div id="shoppingcart">
           <a href="shoppingcart.php">
            <img src="img/713b83a7ab70e1a79d66d49efc33aff6.png">
            <p>Shopping cart</p>
            </a>
        </div>  
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
                <li><a href="recipegeneral.php?rec=all">Recipe</a></li>
                <li class="active"><?php echo $row["recipeName"];?></li>
            </ol>
        </div>
        <div class="detail-page">
            <div class="row">
                <div class="col-md-5">
                    <div class="img-wrapper">
                        <img class="item-img" src="<?php echo $row["img"];?>" alt="recipeImg">
                        <input class="recipeID" type="hidden" name="hidden_id" value="<?php echo $row["recipeId"];?>">
                        <input class="getUser" type="hidden" name="hidden_id" value="<?php echo $_SESSION['user']?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="right_detail">
                        <h3 class="recipe_name"><?php echo $row["recipeName"]?></h3>
                        <input class="getlike" type="image" name="hidden_id" src="img/Like.png" value="<?php echo $row["recipeId"];?>">
                        <div id="get_LikeNum"></div>
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
                            <tr>
                                <td>Purpose:</td>
                                <td><?php echo $row["Purpose"]?></td>
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
                        <p>Comment</p>
                        <textarea class="comment"></textarea>
                        <input type="hidden" class="date" name="hidden_name" value="<?php date_default_timezone_set('Australia/Brisbane');
                        echo date('Y-m-d');
                        ?>">
                        <button class="signup-submit commentSubmit">Submit</button>
                        <div class="comment_list">
                            <div id="get_comment"></div>
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