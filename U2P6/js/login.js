URL_BASE = "http://127.0.0.1:5500";
URL_API = "http://127.0.0.1:8000/api";

/**
 * Function to show and hide the input password
*/
function showPassword() {
    var pwd = $(".pwd");
    var valueType = document.getElementById("password");
    if (valueType.type == "password") {
        valueType.type = "text";
        document.getElementById("seePasswordButton").innerHTML =
            "<ion-icon name='eye-off'></ion-icon>";
    } else {
        valueType.type = "password";
        document.getElementById("seePasswordButton").innerHTML =
            "<ion-icon name='eye'></ion-icon>";
    }
}

$("#login-form").submit((e) => {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: `${URL_API}/login`,
        data: {
            email: $("#username").val(),
            password: $("#password").val(),
            device_name: navigator.userAgent
        }
    }).done((response) => {
        console.log(response);
        
        if (response.status) {
            swal({
                title: "Welcome",
                text: response.message,
                icon: "success"
            });

            sessionStorage.setItem("token", response.data.token);

            window.location.href = `${URL_BASE}/profile.html`;
        } else {
            swal({
                title: "Error",
                text: response.error,
                icon: "error"
            });
        }
    }).fail((jqXHR, textStatus) => {
        swal({
            title: "Error",
            text: "Ha fallado la sesión!",
            icon: "error"
        });
    }); 
});
