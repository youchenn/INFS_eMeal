$(document).ready(function(){
	var t;
	var index=-1;
	var times=3000;
	t=setInterval(play,times);
	
	function play(){
		index++;
		if(index>2){
            index=0
        }		$('.img').eq(index).fadeIn(1000).siblings().fadeOut(1000)
		$('.dot').eq(index).addClass('dt').siblings().removeClass('dt')        
	}
	
	$('.dot').click(function(){
		$(this).addClass('dt').siblings().removeClass('dt')
		var index=$(this).index()
		$('.img').eq(index).fadeIn(600).siblings().fadeOut(600)
	})
	
	$('.btn_l').click(function(){
		index--
		if(index<0){index=2}
		$('.img').eq(index).fadeIn(1000).siblings().fadeOut(1000)
        $('.dot').eq(index).addClass('dt').siblings().removeClass('dt')
	})
    
	$('.btn_r').click(function(){
		index++
		if(index>2){index=0}
		$('.img').eq(index).fadeIn(1000).siblings().fadeOut(1000)
		$('.dot').eq(index).addClass('dt').siblings().removeClass('dt')
	})
	
	$('.banner').hover(
		function(){
			clearInterval(t)
		},
		function(){
			t=setInterval(play,times)
			function play(){
				index++
				if(index>3){index=0}
				$('.img').eq(index).fadeIn(1000).siblings().fadeOut(1000)
				$('.dot').eq(index).addClass('dt').siblings().removeClass('dt')
			}
		}
	);
	
});
	

