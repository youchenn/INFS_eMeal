<?php

include "db.php";
//load the sizes at the side
if(isset($_POST["size"])){
    $size_query = "SELECT * FROM size";
    $size_result = mysqli_query($conn, $size_query) or die(mysqli_error($conn));
    echo "<div class='sidebar'><section class='sidebar-form'><h4>Box Size</h4>";
    if(mysqli_num_rows($size_result)>0){
        while($row = mysqli_fetch_array($size_result)){
            $sid= $row["sizeId"];
            $size_name = $row["sizeTitle"];
            echo "<a href='#' class='size' sid='$sid'>$size_name</a>";
        }
        echo "<section>";
        echo "</div>";
    }
}

//load the product when the page is loaded
if(isset($_POST["getProduct"])){	
	$product_query = "SELECT * FROM product";
	$run_query = mysqli_query($conn,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['productId'];
			$pro_size   = $row['productSize'];
			$pro_name = $row['productName'];
			$pro_price = $row['productPrice'];
			$pro_image = $row['productImage'];
			echo "<div class='recipe-box'>";
            echo "<a href='shoppingdetail.php?item=$pro_id'><img class='recipe-img' src='productimage/$pro_image' alt='$pro_name'></a>";
            echo "<p class='recipe-brief'>$pro_name</p><p>$$pro_price</p>";
            echo "<input type='hidden' name='hidden_name' value='$pro_name'>";
            echo "<input type='hidden' name='hidden_price' value='$pro_price'>";
            echo "<div class='row'><button pid='$pro_id' id='product' class='recipe-btn'>AddToCart</button></div>";
            echo "</div>";
		}
	}
}

//load the product review
if(isset($_POST["getProductReview"])){
    $pid = $_POST['review_id'];
    $productReview_query = "SELECT * FROM productReview a, user b WHERE a.userId = b.userId AND a.productId = $pid";
    $run_query = mysqli_query($conn,$productReview_query);
    if(mysqli_num_rows($run_query) > 0){
       while($row = mysqli_fetch_array($run_query)){
           $rid=$row['pReviewId'];
           $comment=$row['reviewComment'];
           $name = $row['userNickname'];
           $date = $row['reviewTime'];
           echo "<div class='comment_box'>";
           echo "<div class='comment_detail'><p class='comment_name'>$name</p><p class='comment_date'>$date</p><p class='comment_content'>$comment</p></div></div>";
       }
   }
}

//filter products display
if(isset($_POST["get_selected_Category"])){
	$id = $_POST["size_id"];
	$sql = "SELECT * FROM product WHERE productSize = '$id'";
    $run_query = mysqli_query($conn,$sql);
    
	while($row=mysqli_fetch_array($run_query)){
			$pro_id = $row['productId'];
			$pro_size = $row['productSize'];
			$pro_name = $row['productName'];
			$pro_details = $row['productDetails'];
			$pro_price = $row['productPrice'];
			$pro_image = $row['productImage'];
            echo "<div class='recipe-box'>";
            echo "<a href='shoppingdetail.php?item=$pro_id'><img class='recipe-img' src='productimage/$pro_image' alt='$pro_name'></a>";
            echo "<p class='recipe-brief'>$pro_name</p><p>$$pro_price</p>";
            echo "<input type='hidden' name='hidden_name' value='$pro_name'>";
            echo "<input type='hidden' name='hidden_price' value='$pro_price'>";
            echo "<div class='row'><button pid='$pro_id' id='product' class='recipe-btn'>AddToCart</button></div>";
            echo "</div>";
    }
}

//add product to database
if(isset($_POST["addToCart"])){

	$p_id = $_POST["proId"];
	$user_id = 1;
	$ip_add = "thisisipadd";

	$sql = "SELECT * FROM cart WHERE `pId` = '$p_id' AND `uId` = '$user_id'";
	$run_query = mysqli_query($conn,$sql);
	$count = mysqli_num_rows($run_query);

	if($count > 0){
		echo "
			<div class='alert alert-warning'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Product is already added into the cart Continue Shopping..!</b>
			</div>
		";//not in video
	} else {
		$sql = "INSERT INTO `cart`
		(`pId`, `ipAdd`, `uId`, `quantity`) 
		VALUES ('$p_id','$ip_add','$user_id','1')";
		if(mysqli_query($conn,$sql)){
			echo "
				<div class='alert alert-success'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Product is Added..!</b>
				</div>
			";
		}
    }
}

//Insert review
if(isset($_POST["add_review"])){
    $pid = $_POST["pid"];
    $username = $_POST["uname"];
    $review = $_POST["review"];
    $date = $_POST["date"];
    $user_query = "SELECT * FROM user WHERE userNickname = '$username'";
    $run_query = mysqli_query($conn,$user_query);
    while($row = mysqli_fetch_array($run_query)){
        $uid = $row["userId"];
    }
    $insert_sql = "INSERT INTO `productReview` (`reviewComment`, `productId`, `userId`, `reviewTime`) VALUES ('$review', '$pid', '$uid', '$date')";
    $insert_result = mysqli_query($conn, $insert_sql);
    $productReview_query = "SELECT * FROM productReview a, user b WHERE a.userId = b.userId AND a.productId = $pid";
    $run_query2 = mysqli_query($conn,$productReview_query);
    if(mysqli_num_rows($run_query2) > 0){
       while($row = mysqli_fetch_array($run_query2)){
           $rid=$row['pReviewId'];
           $comment=$row['reviewComment'];
           $name = $row['userNickname'];
           $date = $row['reviewTime'];
           echo "<div class='comment_box'>";
           echo "<div class='comment_detail'><p class='comment_name'>$name</p><p class='comment_date'>$date</p><p class='comment_content'>$comment</p></div></div>";
       }
   }
}

//get top3 recipe when page loads
if(isset($_POST["recipe"])){
    $recipe_query = "SELECT a.recipeName, a.img, a.recipeId, b.userId, b.userNickname FROM recipe a, user b WHERE a.userId = b.userId ORDER BY recipeLikeNum DESC LIMIT 3";
    $run_query = mysqli_query($conn,$recipe_query);
    if(mysqli_num_rows($run_query) > 0){
        while($row = mysqli_fetch_array($run_query)){
            $rec_uid = $row["userId"];
            $rec_id = $row["recipeId"];
            $rec_name = $row["recipeName"];
            $rec_image = $row["img"];
            $rec_author = $row["userNickname"];
            echo "
            <div class='recipe-box'>
            <p class='autherbox'>$rec_author</p >
            <img class='recipe-img' src='$rec_image'>
            <p class='recipe-brief'>$rec_name</p >
            <a class='recipe-btn' href='recipeinfo.php?recipe=$rec_id'>Detail</a >
            </div>
            ";
        }
    }
}

//navigation bar
if(isset($_POST["getnav"])){
    echo "<ul id='nav'>";
    echo "<li><a href='homepage.php' class='active'>HOME</a>";
    echo "<li><a href='recipegeneral.php?cate=all'>STYLE</a>";
    echo "<ul class='subnav'>";
    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        echo '<li><a href="recipegeneral.php?cate='.$row["category"].'" name="categoryname" value=>' .$row["category"].'</a></li>';
    }
    echo "</ul></li>";
    echo "<li><a href='recipegeneral.php?pur=all'>PURPOSE</a>";
    echo "<ul class='subnav'>";
    $sql = "SELECT * FROM purpose";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        echo '<li><a href="recipegeneral.php?pur='.$row["purposeName"].'">' .$row["purposeName"].'</a></li>';
    }
    echo "</ul></li>";
    echo "<li><a href='recipegeneral.php?size=all'>SIZE</a>";
    echo "<ul class='subnav'>";
    $sql = "SELECT * FROM size";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        echo '<li><a href="recipegeneral.php?size='.$row["sizeTitle"].'">' .$row["sizeTitle"].'</a></li>';   
    }
    echo "</ul></li>";
    echo "<li><a href='shoppinggeneral.php'>SHOPPING</a></li></ul>";
}

//get latest recipe when page loads
if(isset($_POST["lrecipe"])){
    $recipe_query = "SELECT a.recipeName, a.img, a.recipeId, b.userId, b.userNickname FROM recipe a, user b WHERE a.userId = b.userId ORDER BY recipeId DESC LIMIT 3";
    $run_query = mysqli_query($conn,$recipe_query);
    if(mysqli_num_rows($run_query) > 0){
        while($row = mysqli_fetch_array($run_query)){
            $rec_uid = $row["userId"];
            $rec_id = $row["recipeId"];
            $rec_name = $row["recipeName"];
            $rec_image = $row["img"];
            $rec_author = $row["userNickname"];
            echo "
            <div class='recipe-box'>
            <p class='autherbox'>$rec_author</p >
            <img class='recipe-img' src='$rec_image'>
            <p class='recipe-brief'>$rec_name</p >
            <a class='recipe-btn' href='recipeinfo.php?recipe=$rec_id'>Detail</a >
            </div>
            ";
        }
    }
}