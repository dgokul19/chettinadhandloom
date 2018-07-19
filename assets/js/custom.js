 $(document).ready(function(){
	$('.carousel').carousel({
	  interval: 9000
	});

	$(window).scroll(function(){
		var scroll = $(window).scrollTop();
		if(scroll >= 55){
			$('.origMenu').css({
				'background' : '#fff',
				'height'	: '60px'
			}) ;
			$('.origMenu ul.headUl li a').css('color','#282828');
			$('.origMenu .fa-barr').css('background','#282828');
			$('.origMenu .logoLi img').attr('src','assets/images/logo_1.png').css('width','200px');
			$('.origMenu ul.userActivity a').css('color','#282828');
			$('.origMenu button.sideTooge').css({'top' : '10px','left':'10px'});
			$('.origMenu ul.userActivity').css({'top' : '12px'});
			$('.origMenu.detailsPage').css({'position' : 'fixed'});		
		} else{
			$('.origMenu').css({
				'background' : 'none',
				'height'	: '90px'
			});
			$('.origMenu .logoLi img').attr('src','assets/images/logo.png').css('width','auto');
			$('.origMenu.detailsPage .logoLi img').attr('src','assets/images/logo_1.png').css('width','auto');
			$('.origMenu ul.headUl li a').css('color','#fff');
			$('.origMenu .fa-barr').css('background','#fff');
			$('.origMenu ul.userActivity a').css('color','#fff');
			$('.origMenu button.sideTooge').css({'top' : '17px','left':'20px'});
			$('.origMenu ul.userActivity').css({'top' : '23px'});
			$('.origMenu.detailsPage').css({'position' : 'relative'});
			$('.origMenu.detailsPage ul.headUl li a').css('color','#282828');
			$('.origMenu.detailsPage ul.userActivity a').css('color','#282828');
			$('.origMenu.detailsPage .fa-barr').css('backgroundColor','#282828');
		}
	})

	$('#logSoc').click(function(){
		$('.gen_ogin').removeClass('hideMe')
		$('.soc_login').addClass('hideMe');
	})
	

		// GOOGLE PLUS LOGIN

		
})