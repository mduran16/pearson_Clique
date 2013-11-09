$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/user?userdata=true",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	$("#id").val(response.id)
	$("#firstname").val(response.firstName)
	$("#lastname").val(response.lastName)
	$("#email").val(response.emailAddress)
	$("#username").val(response.userName)
	$("#company").val(response.clientString)
	$("#password").val(response.password)
	$("#confpassword").val(response.password)
});