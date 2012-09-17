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
            console.log(response);
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
            return response;
        },
        dataType: "text"    
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
            return response;
        },
        dataType: "text"//set to JSON    
    })
    
}

/********************************** name **************************************/
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
            alert(response);
            return response;
        },
        dataType: "text"    
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
            return response;
        },
        dataType: "text"    
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
            return response;
        },
        dataType: "text"//set to JSON    
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
            return response;
        },
        dataType: "text"  
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
            return response; 
        },
        dataType: "text"//set to JSON    
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
            return response;
        },
        dataType: "text"//set to JSON   
    })
    
    $.getJSON( base_url + "ajax.php?announce/all/" , function(data) 
    {
        
  });
    
       
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
            return response; 
        },
        dataType: "text"//set to JSON    
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
            return response;
        },
        dataType: "text"//set to JSON      
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
            alert(response);
        }
    });
    
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

/********************************** test_t **************************************/
function test_t()
{
    $.ajax({
        type: "GET", 
        url: "http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/ajax.php?test/t",
        success: function(response)
        console.log(response);
        {
            console.log(response)
            alert(response);
        },
        dataType: "text"//set to JSON 
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

/********************************** grade example **************************************/
function grade_example(site_id)
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
            
	    var json_obj = $.parseJSON(response);//parse JSON
            
            var output="<ul>";
            for (var i in json_obj.grades) 
            {
                output+="<li>" + json_obj.grades[i].name + ",  " + json_obj.grades[i].date + ",  " + json_obj.grades[i].mark + "</li>";
            }
            output+="</ul>";
            
            $('span').html(output);
        },
        dataType: "json"//set to JSON   
    })    
}
