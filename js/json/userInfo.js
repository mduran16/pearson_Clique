$.ajax({
  url: "unit/user.php",
  type: "json",
}).success(function(response) {
	response = $.parseJSON(response)
	$("#firstname").val(response.firstname)
	$("#lastname").val(response.lastname)
	$("#email").val(response.email)
	$("#username").val(response.username)
	$("#company").val(response.company)
	$("#password").val(response.password)
	$("#confpassword").val(response.password)
});