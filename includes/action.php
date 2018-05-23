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
            echo "<div class='quantity_num'><em class='min'>-</em><input type='text' name='quantity' value='1' class='num'/><em class='add'>+</em></div>";
            echo "<input type='hidden' name='hidden_name' value='$pro_name'>";
            echo "<input type='hidden' name='hidden_price' value='$pro_price'>";
            echo "<div class='row'><button pid='$pro_id' id='product' class='recipe-btn'>AddToCart</button></div>";
            echo "</div>";
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
            echo "<div class='quantity_num'><em class='min'>-</em><input type='text' name='quantity' value='1' class='num'/><em class='add'>+</em></div>";
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