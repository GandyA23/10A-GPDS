URL_BASE = "http://127.0.0.1:5500";
URL_API = "http://127.0.0.1:8000/api";

async function checkToken() {
    let invalidToken = true;

    try {
        let token = sessionStorage.getItem("token");

        if (token) {
            const response = await $.ajax({
                url: `${URL_API}/user-profile`,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", `Bearer ${token}`);
                },
            });
            
            // Verifica la información del token
            if (response.status && response.data) {
                invalidToken = false;

                if (document.getElementById("spanUserName")) {
                    document.getElementById("spanUserName").innerHTML = `${response.data.name}`;
                }

                if (document.getElementById("spanEmail")) {
                    document.getElementById("spanEmail").innerHTML = `${response.data.email}`;
                }
            }
        }
        
    } catch (ex) {
        console.error(ex);
        invalidToken = true;
    }

    if (window.location.href.includes("profile.html")) {
        if (invalidToken) {
            window.location.href = `${URL_BASE}/`;
        }
    } else {
        if (!invalidToken) {
            window.location.href = `${URL_BASE}/profile.html`;
        }
    }
}
