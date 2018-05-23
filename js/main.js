$(document).ready(function(){
    $("#user").hide();
    cat();
    product();
    productReview();
    getrecipe();
    getnav();
    getlatestrecipe();
    //get categories to be displayed at the side when page is loaded
    function cat(){
        $.ajax({
            url: 'includes/action.php',
            method: "POST",
            data: {size:1},
            success: function(data){
                $("#get_size").html(data);
            }
        })
    }
    
    //product() is a funtion fetching product record from database whenever page is load
    function product(){
        $.ajax({
            url	:	'includes/action.php',
            method:	"POST",
            data	:	{getProduct:1},
            success	:	function(data){
                $("#get_product").html(data);
            }
        })
    }
    
    //get top3 recipe for homepage
    function getrecipe(){
        $.ajax({
            url :   'includes/action.php',
            method: "POST",
            data    : {recipe:1},
            success : function(data){
            $("#get_recipe").html(data);
            }
        })
    }
    
    //productReview() shows the detail review of each product
    function productReview(){
        var pid = $(".getID").val();
        $.ajax({
            url :'includes/action.php',
            method:	"POST",
            data	:	{getProductReview:1, review_id:pid},
            success	:   function(data){
                $("#get_productReview").html(data);
            }
        })
    }
    //showNavigation
    function getnav(){
        var getuser = $(".getUser").val();       
        $.ajax({
            url :'includes/action.php',
            method:	"POST",
            data	:	{getnav:1,getuser:getuser},
            success	:   function(data){
                $("#get_nav").html(data);
            } 
        })
    }
    
    //showLatestRecipe
    function getlatestrecipe(){
        $.ajax({
            url :   'includes/action.php',
            method: "POST",
            data    : {lrecipe:1},
            success : function(data){
            $("#get_latest_recipe").html(data);
            }
        })
    }
    //get products filtered when categories are clicked
    $("body").delegate(".size","click",function(event){
		event.preventDefault();
		var sid = $(this).attr('sid');
			$.ajax({
			url		:	'includes/action.php',
			method	:	"POST",
			data	:	{get_selected_Category:1,size_id:sid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
    })
    
    //add product to database
 $("body").delegate("#product","click",function(event){
		var pid = $(this).attr("pid");
		event.preventDefault();
		$.ajax({
			url : 'includes/action.php',
			method : "POST",
			data : {addToCart:1,proId:pid},
			success : function(data){
				$('#product_msg').html(data);
			}
		})
	})
    
    //add review into database
    $("body").delegate(".reviewSubmit","click",function(event){
        var pid = $(".getID").val();
        var uname = $(".getUser").val();
        var review = $(".review").val();
        var date = $(".date").val();
		event.preventDefault();
        $.ajax({
            url		:	'includes/action.php',
			method	:	"POST",
			data	:	{add_review:1,pid:pid,uname:uname, review:review,date:date},
			success	:	function(data){
            $("#get_productReview").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
        })
    })
      
})