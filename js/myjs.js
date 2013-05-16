$(document).ready(function(){

	$("#hide_menu").toggle(
		function () {
			$(this).html(">>");
			$(".grade_hide").fadeIn("slow");
			$(".high_grade").fadeIn("slow");
		},
		function () {
			$(this).html("<<");
			$(".grade_hide").fadeOut("slow");
			$(".high_grade").fadeOut("slow");
		}
	);

	$(".high_grade").click(function(){
		alert("只面向高年级开放！");
		});

});