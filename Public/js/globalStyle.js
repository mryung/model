$(function(){
	$(".action").click(function(){
		$(".action").removeClass("active");
		$(this).addClass("active");
		alert($(this).children("a").attr("data-class"));
	});

	function ajaxReturn(data,url,action){
			$.post(
				url,
				{search:data},
				action
			);
	};
	$(".target").click(function(event) {
		var target = $(this).attr('data-target');
		$("iframe").attr("src", target);
	});

})
