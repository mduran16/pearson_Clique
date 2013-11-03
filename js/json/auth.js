function auth(){
	$.ajax({
  url: "/cbe/index.php/auth/",
  type: "json",
}).success(function(response) {
	response = $.parseJSON(response)
	if(response.logged_in == false){
		if($("#center").attr('src') != "signin.html"){
			$("#center").attr('src','signin.html')
		}
	}
	else {
		if($("#center").attr('src') == "javascript:;")
			$("#center").attr('src','index_old.html')
		if($("#sidebar").html() == "")
			$("#sidebar").html(response.sidebar);
		if($("#navbar").html() == "")
			$("#navbar").html(response.navbar);
	}
});
}