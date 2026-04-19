/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Handles client-side Javascript logic for toggling the authentication portal forms.
 */
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const resetForm = document.getElementById("resetForm");

const showRegister = document.getElementById("showRegister");
const showReset = document.getElementById("showReset");
const showLoginFromRegister = document.getElementById("showLoginFromRegister");
const showLoginFromReset = document.getElementById("showLoginFromReset");

function hideAllForms() {
    loginForm.classList.add("hidden");
    registerForm.classList.add("hidden");
    resetForm.classList.add("hidden");
}

showRegister.addEventListener("click", function (e) {
    e.preventDefault();
    hideAllForms();
    registerForm.classList.remove("hidden");
});

showReset.addEventListener("click", function (e) {
    e.preventDefault();
    hideAllForms();
    resetForm.classList.remove("hidden");
});

showLoginFromRegister.addEventListener("click", function (e) {
    e.preventDefault();
    hideAllForms();
    loginForm.classList.remove("hidden");
});

showLoginFromReset.addEventListener("click", function (e) {
    e.preventDefault();
    hideAllForms();
    loginForm.classList.remove("hidden");
});