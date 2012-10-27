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

//++++++++++++++++++++++++++++++++++ DEMO ++++++++++++++++++++++++++++++++++++++

/********************************** login *************************************/
function login(user, pwd)
{
    username = $('#username').val();//get value of div(id = username)
    password = $('#password').val();//get value of div(id = password)
    
    /* uncomment if pass you through parameters! */
    //username = user;
    //password = pwd;
    
    var response = "";
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
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
            $('#demo_heading').html('');
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
        password: password,
        is_ajax: 1
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
            var json_obj = $.parseJSON(response);//parse JSON
               
            var output='<ul>';
            for (var i in json_obj.sup_tools) 
            {
                var type = json_obj.sup_tools[i].type; 
                var site_title = json_obj.sup_tools[i].site_title;
                
                if(type == "announcements")
                {
                    output+='<li><a onclick="announcement_site_demo('+ site_id +');">' + "Announcements" + '</a></li>';
                }
                else if(type == "chatroom")
                {
                    output+='<li><a onclick="chat_demo('+ site_id +');">' + "Chatroom" + '</a></li>';
                }
                else if(type == "gradebook")
                {
                    output+='<li><a onclick="grade_demo('+ site_id +');">' + "Gradebook" + '</a></li>';
                }
                else if(type == "participants")
                {
                    output+='<li><a onclick="role_demo('+ site_id +');">' + "Participants" + '</a></li>';
                }
                else//resources
                {
                    output+='<li><a onclick="resource_demo('+ site_id +');">' + "Resources" + '</a></li>';
                }
            }
            output+="</ul>";

            $('#demo_heading').html(site_title);
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
            if(response == "Empty Username or Password")//username or password empty
            {
                $('#status').fadeIn('slow').text('Logged Out').fadeOut(1500);
            }
            else
            {
                $('#demo_heading').html(response);
            }
        }   
    })
    
}

/*********************************** show *************************************/
function show()
{
    if(on)
    {
        getElementById('docs').style.display = 'hidden';
        on = false
    }
    else
    {
        getElementById('docs').style.display = 'block';
        on = true
    }
}

//+++++++++++++++++++++++++++++++++END DEMO+++++++++++++++++++++++++++++++++++++


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
    //var body = $.('#chattext'   ).text();
    var response = "";
    var form_data = {
        username: username,
        password: password,
        body: body,
        is_ajax: 1
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
