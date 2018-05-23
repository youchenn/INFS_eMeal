$(document).ready(function(){
    cat();
    product();
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
    
})