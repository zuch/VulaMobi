 
 function login()
 {
    var response = "";
    var form_data = {
        username: $("#username").val(),
        password: $("#password").val()
    };
    
    $.ajax({
        type: "POST", 
        url: "ajax.php?auth/login", 
        data: form_data, 
        success: function(response)
        {
            if(response == "empty")
            {
                alert("empty");
            }
            else if(response == "incorrect")
            {
                alert("incorrect");
            }
            else if(response == "already")
            {
                alert("already");
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
      