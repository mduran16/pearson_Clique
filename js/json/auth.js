function auth(){
	$.ajax({
		url: "/cbe/index.php/auth",
		type: "json",
		}).complete(function(response) {
			var response = $.parseJSON(response.responseText);
			if(response.logged_in == true){
				if(!$.trim( $('#sidebar').html() ).length)
					$("#sidebar").load("sidebar.html");

				if(!$.trim( $('#navbar_menu').html() ).length)
				$("#navbar_menu").load("navbar_menu.html")

				if(!$.trim( $('#content').html() ).length)
				$("#content").load("home.html")

				if($("#content").attr("class") != "content")
					$("#content").attr("class","content")

			}
			else {
				$('#sidebar').empty();
				$("#content").attr("class","")
				$("#content").load("signin.html")

			}
		})
}

function changepage(link, id){
	$(function(){
		auth();
		$("#content").load(link)
		$("#content").attr("class","content")
	});
}

$(function(){
	auth();
});