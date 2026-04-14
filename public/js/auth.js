document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("showPassword");
    const password = document.getElementById("password");

    if (checkbox && password) {
        checkbox.addEventListener("change", function () {
            password.type = this.checked ? "text" : "password";
        });
    }
});
