function doPasswordReset() {
    $.ajax({
        url: '/api/changePassword',
        type: 'POST',
        dataType: 'JSON',
        data: {
            password: $('#reset_password').val(),
            password_confirmation: $('#reset_password_confirmation').val()
        },
        success: function(response) {
            if(response.success == 1) {
                closeAndClearResetPass();
            } else {
                alert("There was an error! Please try again!");
            }
        }
    });
}

function closeAndClearResetPass() {
    $('#resetPassModal').modal('hide');
    $('#reset_password').val('');
    $('#reset_password_confirmation').val('');  
}

var client1 = new XMLHttpRequest();
function saveLogo() {
    var file = document.getElementById("avatar");
     
    /* Create a FormData instance */
    var formData = new FormData();
    
    /* Add the file */ 
    formData.append("avatar", file.files[0]);

    client1.open("post", "/api/changeAvatar", true);
    //client.setRequestHeader("Content-Type", "multipart/form-data");
    client1.send(formData);  /* Send to server */ 
}


/* Check the response status */  
client1.onreadystatechange = function() {
    if (client1.readyState == 4 && client1.status == 200) {
        var response = JSON.parse(client1.response);

        if(response.success == 1) {
            alert("Logo changed successfully!");
        } else {
            alert(response.message);
        }

    }
}