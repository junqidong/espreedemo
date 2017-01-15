$(document).ready(function(){
	$('.coupon').click(function(e){
			e.preventDefault();
			$(this).find('input[type=checkbox]').prop("checked", !$(this).find('input[type=checkbox]').prop("checked"));
	});
});

function confirmPassword() {
    var pass1 = document.getElementById("password").value;
    var pass2 = document.getElementById("confirm-password").value;
    var ok = true;
    if (pass1 != pass2) {
        //alert("Passwords Do not match");
        document.getElementById("password").style.borderColor = "#E34234";
        document.getElementById("confirm-password").style.borderColor = "#E34234";
        ok = false;
    }
    return ok;
}