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
        site_id: site_id,
        is_ajax: 1
    };
        
    $.ajax({
        type: "POST", 
        url: base_url + "ajax.php?resource/site", 
        data: form_data, 
        success: function(response){
            console.log(response)
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

/********************************** grade example **************************************/
function active_sites_example()
{
    //$.ajaxSetup({ dataType: 'json' });
    
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
        dataType: "json",
        cache: false,
        success: function(response, status)
        {
           console.log(response);
           console.log(status);
            //var json_str = '[{"title":"CS Honours, 2012","site_id":"fa532f3e-a2e1-48ec-9d78-3d5722e8b60d"},{"title":"Major Project","site_id":"43271a70-b78e-460b-a5b8-8356d0989a85"},{"title":"CS agents","site_id":"69e9386d-a772-47c6-8842-4d1d14a7650c"},{"title":"DBS","site_id":"0fecefa0-3afb-4504-a888-4bb4b48523a3"},{"title":"CSC3002F,2011","site_id":"e193c143-9d00-402b-811b-58ae999498c9"},{"title":"- more sites -","site_id":false}]';
            
	    var json = $.parseJSON(response);//parse JSON
            
            var output="<ul>";
            for (var i = 0; i < json.length; i++) 
            {
                var site = json[i];
                output+="<li>" + site.title + ",  " + site.site_id + "</li>";
            }

            output+="</ul>";
            
            var t = "<h1>test</h1>";
            
            $('span').html(output);
        }   
    })   
}
