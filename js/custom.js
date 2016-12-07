$(document).ready(function(){
	$('.checkbox').click(function(){
		if($(this).find("input").attr("checked")) {
                $(this).find("input").removeAttr("checked");
            } else {
                $(this).find("input").attr("checked", "checked");
            }
	});
});