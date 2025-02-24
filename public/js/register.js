document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const passwordError = document.getElementById("passwordError");
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        const password = passwordInput.value;
        const passwordRegex = /^(?=.*[A-Z])(?=.*[\W_]).{8,}$/;

        if (!passwordRegex.test(password)) {
            event.preventDefault(); // Evita el envío si la contraseña no es válida
            passwordError.style.display = "block";
            passwordError.textContent = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un símbolo.";
        } else {
            passwordError.style.display = "none";
        }
    });

    // Mostrar/Ocultar contraseña
    togglePassword.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePassword.src = "./img/ojo.png"; 
        } else {
            passwordInput.type = "password";
            togglePassword.src = "./img/invisible.png"; 
        }
    });
});
