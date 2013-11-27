getCliqueUsers();
getCliqueQuestions();


function messageBox(){

}


function questionBox(){
    var html = '<div class="pop-dialog full" id="questionBox" style="position:fixed;width:50%;margin-left:25%;top:200px"><div class="body"><div class="settings"><a href="javascript:;" onclick="$(\'#questionBox\').remove()" class="close-icon"><i class="icon-remove-sign"></i></a><div class="items"><div class="item"><input id="titleField" style="width:100%;margin-bottom:10px" class="form-control" placeholder="title"><textarea placeholder="question" id="messageField" style="width:100%;margin-bottom:10px" class="form-control" rows="4"></textarea><a class="btn-flat success" onclick="askQuestion($(\'#userdata\').attr(\'userid\'),$(\'#content\').attr(\'ref\'),$(\'#titleField\').val(),$(\'#messageField\').val());">SEND</a>&nbsp;&nbsp;<a class="btn-flat danger" onclick="$(\'#questionBox\').remove()">CANCEL</a></div></div></div></div></div>'
    $("#content").before(html)

}

function askQuestion(userID,cliqueID,title,message){
    console.log("user ID: " + userID);
    console.log("clique ID: " + cliqueID);
    console.log("title: " + title);
    console.log("Message: " + message);
    console.log("http://clique.raspi.pw/cbe/index.php/question?askQuestion=true&userID=" + userID + "&cliqueID=" + cliqueID + "&title=" + escape(title) + "&content=" + escape(message));

    $.ajax({
        url: "http://clique.raspi.pw/cbe/index.php/question?askQuestion=true&userID=" + userID + "&cliqueID=" + cliqueID + "&title=" + escape(title) + "&content=" + escape(message),
        type: "GET",
    });

    $('#questionBox').remove()

}

function getCliqueUsers(){
    $.ajax({
      url: "http://clique.raspi.pw/cbe/index.php/clique?getCliqueUsers=true&id=" + $("#content").attr("ref"),
      type: "GET",
    }).success(function(response) {
        var response = $.parseJSON(response);

        var r = new Array(), j = -1;
        if(response.length > 0){
            for (var i = 0, size=response.length; i<size; i++){
                if(j==-1)
                    r[++j] = '<tr class="first">'
                else
                    r[++j] = '<tr>'
                r[++j] ='<td><a href="javascript:;" onclick="changepage(\'user-profile.html\',\'' + response[i]["id"] + '\')"><h5>';
                r[++j] = response[i]["username"];
                r[++j] = '</h5></a></td>';
                r[++j] = '<td><a class="btn-flat success" disabled>Student</a></td>'    
                r[++j] = '<td>'
                r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Invite</a></li><li><a href="#">Private Message</a></li><li></ul></div>';
                r[++j] = "</td>"
                r[++j] = '</tr>';
            }
        }
        else{
            r[++j] = '<tr class="first"><td><h4>Somehow you reached this page...</h4></td></tr>'
        }
        $('#usersTable').html(r.join('')); 
    });
}

function getCliqueQuestions(){
    $.ajax({
      url: "http://clique.raspi.pw/cbe/index.php/question?getQuestions=true&cliqueID=" + $("#content").attr("ref"),
      type: "GET",
    }).success(function(response) {
        var response = $.parseJSON(response);

        var r = new Array(), j = -1;
        if(response.length > 0){
            for (var i = 0, size=response.length; i<size; i++){
                //console.log(JSON.stringify(response[i]))
                if(j==-1)
                    r[++j] = '<tr class="first">'
                else
                    r[++j] = '<tr>'
                r[++j] ='<td><h4><a href="javascript:;" onclick="changepage(\'question.html\',' + response[i]['questionID'] + ')">';
                r[++j] = response[i]['questionName']
                r[++j] = '</a></h4></td><td><h4><a href="javascript:;">'
                r[++j] = response[i]['username']
                r[++j] = '</a></h4></td>';
                r[++j] = '</tr>';
            }
        }
        else{
            r[++j] = '<tr class="first"><td><h4>There currently aren\'t any questions waiting to be answered.</h4></td></tr>'
        }
        $('#questionsTable').html(r.join('')); 
    });
}