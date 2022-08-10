<<<<<<< HEAD
$(document).ready(function(){		
	var pageId = window.location.href.split('/').pop().replace('.php', '');
	$(".menu-link").parent('li').removeClass('active');
	if($('#'+pageId).length) {
		$('#'+pageId).addClass('active');
	} else {
		$('#dashboard').addClass('active');
	}	
=======
$(document).ready(function(){		
	var pageId = window.location.href.split('/').pop().replace('.php', '');
	$(".menu-link").parent('li').removeClass('active');
	if($('#'+pageId).length) {
		$('#'+pageId).addClass('active');
	} else {
		$('#dashboard').addClass('active');
	}	
>>>>>>> 847975b5614be2f62da387430666c63a7654217f
});