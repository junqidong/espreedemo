$(document).ready(function(){
	$('.checkbox').click(function(){
			$(this).find('input[type=checkbox]').prop("checked", !$(this).find('input[type=checkbox]').prop("checked"));
	});
});