/****************************************
 *   Sascha Watermeyer - WTRSAS001       *
 *   Vulamobi CS Honours project         *
 *   sascha.watermeyer@gmail.com         *
 *   ----------------------------------  *
 *   Client Side Javascript to           *
 *   interact with the VulaMobi Backend  *
 *****************************************/


    
/* Globals*/
var base_url = 'http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/';//production
//var base_url = 'http://localhost/VulaMobi/';//development

var username = "";//global username set when you initially login
var password = "";//global password set when you initially login
var on = false;

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++ DEMO ++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

/********************************** login *************************************/
function login()
{
    username = $('#username').val();//get value of div(id = username)
    password = $('#password').val();//get value of div(id = password)
    
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?auth/login", 
        data: form_data, 
        success: function(response)
        {
            console.log(response);
            if(response == "Empty Username or Password")//username or password empty
            {
                $('#status').fadeIn('slow').text(response).fadeOut(1500);
            }
            else if(response == "Incorrect Username or Password")//username or password incorrect
            {
                $('#status').fadeIn('slow').text(response).fadeOut(1500);
            }
            else if(response == "logged_in") //logged_in
            {
                $('#status').fadeIn('slow').text('Logged In').fadeOut(1500);
                home();
            }
        },
        dataType: "text"    
    })
}

/************************************* logout *********************************/
function home()
{
    $('#home').html('');
    user_name();
    active_sites();
}

/************************************* logout *********************************/
function logout()
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };
    
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?auth/logout", 
        data: form_data,
        success: function(response)
        {
            $('#home').html('');
            $('#demo_title').html('');
            $('#demo_content').html('');
            $('#status').fadeIn('slow').text('Logged Out').fadeOut(1500);
            username = "";
            password = "";
        } 
    })
}

/********************************** active_sites *************************************/
function active_sites()
{  
    var response = "";
    var form_data = {
        username: username,
        password: password
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?student/sites", 
        data: form_data,
        success: function(response)
        {
            if(response == "Empty Username or Password")//username or password empty
            {
               $('#status').fadeIn('slow').text('Logged Out').fadeOut(1500);
            }
            else
            {
                var json_obj = $.parseJSON(response);//parse JSON
            
                console.log(response);
                
                var output="<ul>";
                for (var i in json_obj.active_sites) 
                {
                    var site_id = json_obj.active_sites[i].site_id;
                    var title = json_obj.active_sites[i].title;
                    var site_id_temp = "'"+site_id+"'";
                    var onclick = 'onclick="sup_tools(' + site_id_temp + ');"';   
                    output += "<li><a " + onclick +     ">" + title + "</a></li>";
                }
                output+="</ul>";

                $('#demo_content').html(output);
            }
        }  
    }) 
}

/********************************** sup_tools *************************************/
function sup_tools(site_id)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?student/sup_tools/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='<ul>';
            for (var i in json_obj.sup_tools) 
            {
                var type = json_obj.sup_tools[i].type; 
                var site_title = json_obj.sup_tools[i].site_title;
                var temp = "'"+site_id+"'";
                var temp2 = "'"+site_title+"'";
                
                if(type == "announcements")
                {
                    output+='<li><a onclick="announcement_site_demo('+ temp +');">' + "Announcements" + '</a></li>';
                }
                else if(type == "resources")
                {
                    output+='<li><a onclick="resource_demo('+ temp + ','+ temp2 +');">' + "Resources" + '</a></li>';
                }
                else if(type == "gradebook")
                {
                    output+='<li><a onclick="grade_demo('+ temp + ','+ temp2 +');">' + "Gradebook" + '</a></li>';
                }
                else if(type == "assignments")
                {
                    output+='<li><a onclick="assign_demo('+ temp + ','+ temp2 +');">' + "Assignments" + '</a></li>';
                }
                else if(type == "chatroom")
                {
                    output+='<li><a onclick="chat_demo('+ temp + ','+ temp2 + ');">' + "Chatroom" + '</a></li>';
                }
                else if(type == "participants")
                {
                    output+='<li><a onclick="role_demo('+ temp + ','+ temp2 +');">' + "Participants" + '</a></li>';
                }
                else
                    {}
            }
            output+="</ul>";

            $('#demo_title').html(site_title);
            $('#demo_content').html(output);
            $('#home').html('<button type="button" onclick="home();">Home</button> ');
        }  
    })
}

/********************************** user_name **************************************/
function user_name()
{  
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?student/name", 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            if(response == "Empty Username or Password")//username or password empty
            {
                $('#status').fadeIn('slow').text('Logged Out').fadeOut(1500);
            }
            else
            {
                $('#demo_title').html(response);
            }
        }   
    })
    
}

/*********************************** announcement *************************************/
function announcement_site_demo(site_id)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?announce/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
            var siteTitle = "";  
                
            var output='<ul>';
            for (var i in json_obj.announcements_site) 
            {
                siteTitle = json_obj.announcements_site[i].siteTitle[0];
                var title = json_obj.announcements_site[i].title[0];
                var announce_id = json_obj.announcements_site[i].announce_id[0];
                var createdByDisplayName = json_obj.announcements_site[i].createdByDisplayName[0];
                var createdOn = json_obj.announcements_site[i].createdOn[0];
                
                var temp = "'"+site_id+"'";
                var temp2 = "'"+announce_id+"'";
                var temp3 = "'"+title+"'";
                
                output+='<li><a onclick="announce_body_demo('+ temp +','+ temp2 +','+ temp3+');">'+title+'</a></li>';
            }
            output+="</ul>";
            
            $('#demo_title').html(siteTitle);
            var temp4 = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp4 +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

/*********************************** announcement body*************************************/
function announce_body_demo(site_id, announce_id, announce_title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?announce/body/" + site_id + "/" + announce_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            
            $('#demo_title').html(announce_title);
            var temp = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="announcement_site_demo('+ temp +');">Back</button> ');
            $('#demo_content').html(response);
        }   
    })
}

/*********************************** chatroom *************************************/
function chat_demo(site_id, title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?chat/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='';
            for (var i in json_obj.chat) 
            {
                var message = json_obj.chat[i];
                
                output += message + "</br>";
            }
            
            $('#demo_title').html(title);
            var temp = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

/*********************************** chatroom *************************************/
function grade_demo(site_id, title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?grade/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='<table>';
            output+='<tr>';
            output+='<th>Name</th><th>Date</th><th>Mark</th>';
            output+='</tr>';
            for (var i in json_obj.grades) 
            {
                var name = json_obj.grades[i].name;
                var date = json_obj.grades[i].date;
                var mark = json_obj.grades[i].mark;
                
                output+='<tr>';
                output+='<td>' + name + '</td>';
                output+='<td>' + date + '</td>';
                output+='<td>' + mark + '</td>';
                output+='</tr>';
            }
            output+='</table>';
            
            $('#demo_title').html(title);
            var temp = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

/*********************************** role *************************************/
function role_demo(site_id, title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?role/roster/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='<table>';
            output+='<tr>';
            output+='<th>Name</th><th>ID</th>';
            output+='</tr>';
            for (var i in json_obj.roster) 
            {
                var name = json_obj.roster[i].name;
                var id = json_obj.roster[i].id;
                var email = json_obj.roster[i].email;
                var role = json_obj.roster[i].role;
                
                output+='<tr>'
                output+='<td>' + name + '</td>';
                output+='<td>' + email + '</td>';
                output+='</tr>'
            }
            output+='</table>'
            
            $('#demo_title').html(title);
            var temp = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

/*********************************** resource *************************************/
function resource_demo(site_id, site_title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/page/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
                
            var output='<ul>';
            for (var i in json_obj.resources) 
            {
                var type = json_obj.resources[i].type;
                var title = json_obj.resources[i].title;
                var href = json_obj.resources[i].href;
                
                var temp = "'"+href+"'";
                var temp2 = "'"+title+"'";
                var temp3 = "'"+site_id+"'";
                var temp4 = "'"+site_title+"'";
                
                if(type == "folder")
                {
                    output+='<li><a class="folder" onclick="folderSelected('+ temp +','+ temp2 + ','+ temp3 + ','+ temp4 + ');">'+title+'</a></li>';
                }
                else
                {
                    //output+='<li><a  style="color:green;" onclick="resourceSelected('+ temp +','+ temp2 + ','+ temp3 + ','+ temp4 + ');">'+title+'</a></li>';
                    output+='<li><a  style="color:green;" href="'+href+';">'+title+'</a></li>';
                }
            }
            output+="</ul>";
            
            $('#demo_title').html(site_title);
            var temp5 = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp5 +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

function folderSelected(href, title, site_id, site_title)
{   
    var form_data = {
        username: username,
        password: password,
        folderid: href
    };
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/folder", 
        data: form_data, 
        success: function(response){
             console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
                
            var output='<ul>';
            for (var i in json_obj.resources) 
            {
                var type = json_obj.resources[i].type;
                var title = json_obj.resources[i].title;
                var href = json_obj.resources[i].href;
                
                var temp = "'"+href+"'";
                var temp2 = "'"+title+"'";
                var temp3 = "'"+site_id+"'";
                var temp4 = "'"+site_title+"'";
                
                if(type == "folder")
                {
                    output+='<li><a class="folder" onclick="folderSelected('+ temp +','+ temp2 + ','+ temp3 + ','+ temp4 + ');">'+title+'</a></li>';
                }
                else
                {
                    //output+='<li><a  style="color:green;" onclick="resourceSelected('+ temp +','+ temp2 + ','+ temp3 + ','+ temp4 + ');">'+title+'</a></li>';
                    output+='<li><a  style="color:green;" href="'+href+';">'+title+'</a></li>';
                }
            }
            output+="</ul>";
            
            $('#demo_title').html(site_title);
            var temp5 = "'"+site_id+"'";
            var temp6 = "'"+site_title+"'";
            $('#home').html('<button type="button" onclick="resource_demo('+ temp5 +','+ temp6 +');">Resources</button> ');
            $('#demo_content').html(output);
        }
    });
}

function resourceSelected(href, title, site_id, site_title)
{
    var form_data = {
        username: username,
        password: password,
        item: href
    };
	
    $('#demo_title').html(site_title);
    var temp = "'"+site_id+"'";
    var temp2 = "'"+site_title+"'";
    $('#home').html('<button type="button" onclick="resource_demo('+ temp +','+ temp2 +');">Back</button> ');
    $('#demo_content').html('<a href="'+href+'">'+title+'</a>');
        
    /*$.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/item", 
        data: form_data, 
        success: function(response){
            console.log(response);
            
            $('#demo_title').html(site_title);
            var temp = "'"+site_id+"'";
            var temp2 = "'"+site_title+"'";
            $('#home').html('<button type="button" onclick="resource_demo('+ temp +','+ temp2 +');">Back</button> ');
            $('#demo_content').html(href);
        }
    });*/
}

/*********************************** role *************************************/
function assign_demo(site_id, site_title)
{
    var response = "";
    var form_data = {
        username: username,
        password: password
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?assign/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='<table>';
            output+='<tr>';
            output+='<th>Title</th><th>Status</th><th>Due</th>';
            output+='</tr>';
            for (var i in json_obj.assignments_site) 
            {
                var title = json_obj.assignments_site[i].title;
                var status = json_obj.assignments_site[i].status;
                var due = json_obj.assignments_site[i].due;
                                
                output+='<tr>'
                output+='<td>' + title + '</td>';
                output+='<td>' + status + '</td>';
                output+='<td>' + due + '</td>';
                output+='</tr>'
            }
            output+='</table>'
            
            $('#demo_title').html(site_title);
            var temp = "'"+site_id+"'";
            $('#home').html('<button type="button" onclick="sup_tools('+ temp +');">Back</button> ');
            $('#demo_content').html(output);
        }   
    })
}

/*********************************** show *************************************/
function show()
{    
    //$.('#docs').css(display, hidden);
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++END DEMO+++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


/********************************** sites *************************************/
function sites()
{
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST",
        url: base_url + "ajax.php?student/sites",
        data: form_data,
        success: function(response)
        {            
            console.log(response);
            alert(response);   
        }
    })
    
}

/********************************** grade *************************************/
function grade(site_id)
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?grade/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);
        }
    })
    
}


/********************************** grade_all *************************************/
function grade_all()
{  
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?grade/all", 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }
    })
}

/********************************** s_name **************************************/
function s_name()
{
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST",
        url: base_url + "ajax.php?student/name",
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }
    })
    
} 

/********************************** id ****************************************/
function user_id()
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?student/id", 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }  
    })
     
} 

/********************************** sup_tools ****************************************/
function sup_tools_s(site_id)
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?student/sup_tools/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }  
    })
     
} 

/********************************** gallery ***********************************/
function gallery()
{
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?gallery/dir", 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }    
    })
    

}

/********************************** role **************************************/
function role(site_id)
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?role/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        } 
    })
    
}

/********************************** roster ************************************/
function roster(site_id)
{
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?role/roster/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }  
    })
    
}

/****************************** announcement_all *****************************/
function announcement_all()
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?announce/all/", 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        } 
    })   
}

/*********************** announcement_site ************************************/
function announcement_site(site_id)
{
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?announce/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        } 
    })
    
}

/*********************** announcement_body ************************************/
function announcement_body(site_id, announce_id)
{
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };

    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?announce/body/" + site_id + "/" + announce_id , 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }   
    })
    
}

/********************************** chat *************************************/
function chat(site_id)
{  
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?chat/site/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }  
    })
    
}

/********************************** submit *************************************/
function submit(site_id)
{  
    var body = $("#msg").val();
    var response = "";
    var form_data = {
        username: username,
        password: password,
        body: body
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?chat/submit/" + site_id, 
        data: form_data,
        success: function(response)
        {
            console.log(response);
            alert(response);   
        }   
    })
    
}

/********************************** resources *********************************/
function resource(site_id)
{
    
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/site/" + site_id, 
        data: form_data, 
        success: function(response){
            console.log(response);
            alert(response);
        }
    }); 
}

/********************************** resources_page *********************************/
function resource_page(site_id)
{
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/page/" + site_id, 
        data: form_data, 
        success: function(response){
            console.log(response);
            alert(response);
        }
    }); 
}

/********************************** assign ************************************/
function assign(site_id)
{ 
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?assign/site/" + site_id, 
        data: form_data, 
        success: function(response){
            console.log(response);
            alert(response);
            
        }
    });
    
}
/********************************** assign_all *********************************/
function assign_all()
{
    
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?assign/all", 
        data: form_data, 
        success: function(response){
            console.log(response);
            alert(response);
        }
    });
    
}

/********************************** test_t **************************************/
function test_t()
{
    $.ajax({
        type: "GET", 
        url: "http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/ajax.php?test/t",
        success: function(response)
        {
            console.log(response)
            alert(response);
        },
        dataType: "text"
    })    
}

/********************************** example **************************************/
function example()
{
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?test/json", 
        data: form_data,
        success: function(response)
        {
            /*response = '[{"Language":"jQuery","ID":"1"},{"Language":"C#","ID":"2"},
                           {"Language":"PHP","ID":"3"},{"Language":"Java","ID":"4"},
                           {"Language":"Python","ID":"5"},{"Language":"Perl","ID":"6"},
                           {"Language":"C++","ID":"7"},{"Language":"ASP","ID":"8"},
                           {"Language":"Ruby","ID":"9"}]'*/
            console.log(response);
            
            var json_obj = $.parseJSON(response);//parse JSON
            
            var output="<ul>";
            for (var i in json_obj) 
            {
                output+="<li>" + json_obj[i].Language + ",  " + json_obj[i].ID + "</li>";
            }
            output+="</ul>";
            
            $('span').html(output);
        },
        dataType: "json"//set to JSON    
    })    
}
