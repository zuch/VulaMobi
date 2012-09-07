/*
* Sascha Watermeyer - WTRSAS001
* Vulamobi CS Honours project
* sascha.watermeyer@gmail.com  */

/* Globals*/

//nightmare
//var base_url = 'http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/';
var base_url = 'http://localhost/VulaMobi/';

/********************************** login *************************************/
function login()
{
    var response = "";
    var form_data = {
        username: $("#username").val(),
        password: $("#password").val()
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

                //your code here!
            }
            else if(response == "incorrect")//username or password incorrect
            {
                alert("incorrect");
                //your code here!
            }
            else if(response == "already")//already logged in - reroute to home page
            {
                alert("already");

                //your code here!
            }
            else if(response == "logged_in") //logged_in
            {
                alert("logged_in");

                //your code here!
            }
            else if(response == "logged_out") //logged_out
            {
                alert("logged_out");

                //your code here!
            }
        },
        dataType: "text"    
    })    
}

/************************************* logout *********************************/
function logout()
{
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?auth/logout",  
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
}

/********************************** sites *************************************/
function sites()
{  
    //get JSON- jQuery
    var json = $.getJSON(base_url + "ajax.php?student/sites") 
    //alert(json);
    
    //your code here!
    
    //get Text
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?student/sites", 
        success: function(response)
        {
            alert(response);


        },
        dataType: "text"    
    })
}

/********************************** grade *************************************/
function grade(site_id)
{  
    //get JSON- jQuery
    var json = $.getJSON(base_url + "ajax.php?grade/site/" + site_id + "/1")
    //alert(json);
    
    //get Text
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?grade/site/" + site_id + "/0", 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
}

/********************************** name **************************************/
function username()
{  
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?student/name/", 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
} 

/********************************** id ****************************************/
function user_id()
{  
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?student/id/", 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
} 

/********************************** gallery *************************************/
function gallery()
{
    //get JSON - jQuery
    var json = $.getJSON(base_url + "ajax.php?gallery/dir")
    //alert(json);
    
    //get Text
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?gallery/dir", 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
}

/********************************** role ****************************************/
function role(site_id)
{  
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?role/site/" + site_id, 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
}

/********************************** roster *************************************/
function roster(site_id)
{
    //get JSON - jQuery
    var json = $.getJSON(base_url + "ajax.php?role/roster/" + site_id)
    //alert(json);
    
    //get Text
    $.ajax({
        type: "GET", 
        url: base_url + "ajax.php?role/roster/" + site_id, 
        success: function(response)
        {
            alert(response);

            //your code here!

        },
        dataType: "text"    
    })
}