function validateLogin() {
    // Validar el formulario en el lado del cliente (puedes agregar más validaciones según tus necesidades)

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if (username === "" || password === "") {
        alert("Por favor, complete todos los campos.");
        return;
    }

    // Enviar los datos al servidor (PHP) para su validación
    sendLoginRequest(username, password);
}

function sendLoginRequest(username, password) {
    // Usar AJAX para enviar los datos al servidor (PHP)
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // Manejar la respuesta del servidor
            if (this.responseText === "success") {
                // Redirigir a la página de conexión.php
                window.location.href = "../conexion.phop";
            } else {
                alert("Credenciales incorrectas. Inténtelo de nuevo.");
            }
        }
    };

    xhttp.open("POST", "login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username + "&password=" + password);
}
