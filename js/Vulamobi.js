 
 function login()
 {
    alert('login');
    var response = "";
    var form_data = {
        username: $("#username").val(),
        password: $("#password").val()
    };
    
    $.ajax({
        type: "POST", 
        url: "ajax.php?auth/login", 
        data: form_data, 
        success: function(data)
        {
            response = data;
            alert("auth response: "+response);
            if(response == "empty")
            {
                alert("Empty Username or Password");
            }
            else if(response == "incorrect")
            {
                alert("Incorrect Username or Password");
            }
            else if(response == "logged_in") //logged_in
            {
                alert("logged_in");
            }
            else if(response == "logged_out") //logged_out
            {
                alert("logged_out");
            }
        },
        dataType: "text"    
    }) 
 }
      