getCliqueUsers();
getCliqueQuestions();

function getCliqueUsers(){
    $.ajax({
      url: "http://clique.raspi.pw/cbe/index.php/clique?getCliqueUsers=true&id=" + $("#content").attr("ref"),
      type: "GET",
      cache: false,
    }).success(function(response) {
        var response = $.parseJSON(response);
        userID = $('#userdata').attr('userID')
        var r = new Array(), j = -1;
        if(response.length > 0){
            for (var i = 0, size=response.length; i<size; i++){
                if(response[i]["id"] == userID){
                    $('#userdata').attr('courserole',response[i]["roleType"])
                }
                if(j==-1)
                    r[++j] = '<tr class="first" '
                else
                    r[++j] = '<tr '
                r[++j] = 'userid='
                r[++j] = response[i]["userID"]
                r[++j] = "><td>"
                if($('#userdata').attr('courserole') != 'STUD' || $('#userdata').attr('userid') == response[i]['userID']){
                    r[++j] ='<a href="javascript:;" onclick="changepage(\'user-profile.html\',\''
                    r[++j] = response[i]["userID"]
                    r[++j] = '\')">'
                }
                r[++j] = '<h5>';
                r[++j] = response[i]["username"]
                //r[++j] = response[i]["firstName"]
                //r[++j] = " "
                //r[++j] = response[i]["lastName"];
                r[++j] = '</h5></a></td>';

                if(response[i]["userID"] != userID){
                    r[++j] = '<td>'
                    r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:;" onclick="messageBox(' + i + ',$(this).closest(\'tr\').attr(\'userid\'))">Private Message</a></li>';
                    
                    if(response[i]["roleType"] == "STUD"){
                        r[++j] = '<li><a href="javascript:;" onclick="inviteBox(' + i + ',$(this).closest(\'tr\').attr(\'userid\'))">Invite</a></li>';
                    }
                    r[++j] = '</ul></div>';
                    r[++j] = "</td>"
                }
                else{
                    r[++j] = "<td></td>"
                }

                
                if(response[i]['userID'] != userID)
                    r[++j] = '<td><a class="btn-flat success" disabled>Member</a></td>'
                else
                    r[++j] = '<td><a class="btn-flat primary" disabled>YOU</a></td>';


                r[++j] = '</tr>';
            }
        }
        else{
            r[++j] = '<tr class="first"><td><h4>It looks like theres been an error. Try logging out and logging back in.</h4></td></tr>'
        }
        $('#usersTable').html(r.join('')); 
    });
}

function getCliqueQuestions(){
    $.ajax({
      url: "http://clique.raspi.pw/cbe/index.php/question?getQuestions=true&cliqueID=" + $("#content").attr("ref"),
      type: "GET",
      cache: false,
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


/*
message box popup
*/
function messageBox(index,userid){
    //alert(index)
    if(!($("#messageBox").length) && !($("#inviteBox").length)){
        var box='<div class="pop-dialog full" id="messageBox" style="position:absolute;width:80%"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div><div class="body"><div class="settings"><a href="javascript:;" onclick="$(\'#messageBox\').remove()" class="close-icon"><i class="icon-remove-sign"></i></a><div class="items"><div class="item"><textarea id="messageField" style="width:100%;margin-bottom:10px" class="form-control" rows="4"></textarea><a class="btn-flat success" onclick="sendMessage($(\'#messageField\').val(),' + userid + ');">SEND</a>&nbsp;&nbsp;<a class="btn-flat danger" onclick="$(\'#messageBox\').remove()">CANCEL</a></div></div></div></div></div>'
        $('#usersTable tr:nth-child(' + (index + 1)+ ')').after(box);
    }
    else{
        $("#messageBox").remove()
        $("#inviteBox").remove()
        messageBox(index)
    }
}


/*
send message function
*/
function sendMessage(message,userID)
{   

    //console.log(message)
    //console.log(userID)
    $.ajax({
        url: "http://clique.raspi.pw/cbe/index.php/thread?sendMessage=true&recieverID="+ userID + "&message=" + escape(message),
        cache: false,
    })

    $('#messageBox').remove()
    return true;
}



function questionBox(){
    var html = '<div class="pop-dialog full" id="questionBox" style="position:fixed;width:50%;margin-left:25%;top:200px"><div class="body"><div class="settings"><a href="javascript:;" onclick="$(\'#questionBox\').remove()" class="close-icon"><i class="icon-remove-sign"></i></a><div class="items"><div class="item"><input id="titleField" style="width:100%;margin-bottom:10px" class="form-control" placeholder="title"><textarea placeholder="question" id="messageField" style="width:100%;margin-bottom:10px" class="form-control" rows="4"></textarea><a class="btn-flat success" onclick="askQuestion($(\'#userdata\').attr(\'userid\'),$(\'#content\').attr(\'ref\'),$(\'#titleField\').val(),$(\'#messageField\').val());">SEND</a>&nbsp;&nbsp;<a class="btn-flat danger" onclick="$(\'#questionBox\').remove()">CANCEL</a></div></div></div></div></div>'
    $("#content").before(html)

}

function askQuestion(userID,cliqueID,title,message){
    console.log("http://clique.raspi.pw/cbe/index.php/question?askQuestion=true&userID=" + userID + "&cliqueID=" + cliqueID + "&title=" + escape(title) + "&content=" + escape(message));

    $.ajax({
        url: "http://clique.raspi.pw/cbe/index.php/question?askQuestion=true&userID=" + userID + "&cliqueID=" + cliqueID + "&title=" + escape(title) + "&content=" + escape(message),
        type: "GET",
        cache: false,
    });

    $('#questionBox').remove()

}