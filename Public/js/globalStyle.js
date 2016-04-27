$(function(){

	// for(var i in window){
	// 	console.log(i);
	// }

	$(".action").click(function(){
		$(".action").removeClass("active");
		$(this).addClass("active");
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
