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

/********************************** login *************************************/
function login(user, pwd)
{
    username = $('#username').val();//get value of div(id = username)
    password = $('#password').val();//get value of div(id = password)
    
    /* uncomment if pass you through parameters! */
    //username = user;
    //password = pwd;
    
    if((username == "") || (password == ""))
    {
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
                if(response == "empty")//username or password empty
                {
                    alert("empty");
                    return "empty";
                }
                else if(response == "incorrect")//username or password incorrect
                {
                    alert("incorrect");
                    return "incorrect";
                }
                else if(response == "already")//already logged in - reroute to home page
                {
                    alert("already");
                    return "already";
                }
                else if(response == "logged_in") //logged_in
                {
                    alert("logged_in");
                    return "logged_in";
                }
                else if(response == "logged_out") //logged_out
                {
                    alert("logged_out");
                    return "logged_out";
                }
            },
            dataType: "text"    
        })
    }
    else
    {
        alert('logged_in')
        return 'logged_in';
    }
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
            alert(response);
            return "logged_out";
        },
        dataType: "text"    
    })
    
    username = "";
    password = "";
}

/********************************** sites *************************************/
function sites()
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"    
        })
    }
}

/********************************** grade *************************************/
function grade(site_id)
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"//set to JSON    
        })
    }
}

/********************************** name **************************************/
function user_name()
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"    
        })
    }
} 

/********************************** id ****************************************/
function user_id()
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"    
        })
    } 
} 

/********************************** gallery ***********************************/
function gallery()
{
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"//set to JSON    
        })
    }

}

/********************************** role **************************************/
function role(site_id)
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"  
        })
    }
}

/********************************** roster ************************************/
function roster(site_id)
{
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response; 
            },
            dataType: "text"//set to JSON    
        })
    }
}

/****************************** announcements_all *****************************/
function announcements(site_id)
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"//set to JSON   
        })
    }    
}

/********************************** chat *************************************/
function chat(site_id)
{  
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
                return response;
            },
            dataType: "text"//set to JSON      
        })
    }
}

/********************************** resources *********************************/
function resource(site_id)
{
    if((username == "") || (password == ""))
    {
        alert('logged_out')
        return "logged_out";
    }
    else
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
                alert(response);
            }
        });
    }
}

function folderSelected(id)
{
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
    $.ajax({
        type: "POST", 
        url: "getfolder.php", 
        data: form_data, 
        success: function(data){
            $('#metainfo').html(data);
        }
    });
}

function resourceSelected(id)
{
    //$("#secretIFrame").attr("src","getoneitem.php?username="+$("#username").val()+"&password="+$("#password").val()+"&item="+id);
    var form_data = {
        username: username,
        password: password,
        is_ajax: 1
    };
	
    $.ajax({
        type: "POST", 
        url: "getoneitem.php", 
        data: form_data, 
        success: function(data){
            $.mobile.changePage('#page3');
            $("#superlinks").html(data);
        }
    });
}

/********************************** test **************************************/
function test()
{
    $.ajax({
        type: "GET", 
        url: "http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/ajax.php?test/t",
        success: function(response)
        {
            console.log(response)
            alert(response);

        //your code here!

        }
    })    
}
