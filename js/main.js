$(document).ready(function(){
    $("#user").hide();
    cat();
    product();
    productReview();
    getrecipe();
    getnav();
    getlatestrecipe();
    signstatus();
    showcomment();
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
    
    function showcomment(){
        var recipeid = $(".recipeID").val();
        $.ajax({
            url :'includes/action.php',
            method:	"POST",
            data	:	{getRecipe:1, rid:recipeid},
            success	:   function(data){
                $("#get_comment").html(data);
            }
        })
    }
    
    //show the signup status
    function signstatus(){
    var sid = $(".signupID").val();
    $.ajax({
        url :'includes/action.php',
        method:	"POST",
        data	:	{getsignup:1, sid:sid},
        success	:   function(data){
            $("#get_signup").html(data);
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
    
    //add review into database
  $("body").delegate(".commentSubmit","click",function(event){
        var rid = $(".recipeID").val();
        var uname = $(".getUser").val();
        var comment = $(".comment").val();
        var date = $(".date").val();
		event.preventDefault();
        $.ajax({
            url		:	'includes/action.php',
			method	:	"POST",
			data	:	{add_comment:1,rid:rid,uname:uname, comment:comment,date:date},
			success	:	function(data){
            $("#get_comment").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
        })
    })
    getlikenum();
    //get like number to be displayed when page is loaded
    function getlikenum(){
    var rid = $(".getlike").val();
        $.ajax({
            url :'includes/action.php',
            method: "POST",
            data    :   {likenum:1, recipe_id:rid},
            success : function(data){
            $("#get_LikeNum").html(data);
            }
        })
    }
    
    //add 1 to recipeLikeNum in database
    $("body").delegate(".getlike","click",function(event){
        var rid = $(".getlike").val();
        event.preventDefault();
        $.ajax({
            url     :   'includes/action.php',
            method  :   "POST",
            data    :   {add_like:1,recipe_id:rid},
            success :   function(data){
                $("#get_LikeNum").html(data);
                
            }
        })
    })
    
    //confirm shipping information
    $("body").delegate(".confirm-btn","click",function(event){
        var name = $(".name").val();
        var address = $(".address").val();
        var postcode = $(".postcode").val();
        var number = $(".phone").val();
        var email = $(".email").val();
        var uid = $(".getUID").val();
		event.preventDefault();
        $.ajax({
            url		:	'includes/action.php',
			method	:	"POST",
			data	:	{confirm:1,name:name,address:address, postcode:postcode, number:number, email:email, uid:uid},
			success	:	function(data){
            $("#getshipinfo").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
            $(".confirm_info").hide();
			}
        })
    })
    
})