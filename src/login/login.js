document.addEventListener("DOMContentLoaded", function() {
    var $loginForm = document.getElementById("login-form");

    $loginForm.addEventListener("submit", submitLogin)

    function submitLogin(e)
    {
        var valideEmail = validateEmail(document.getElementById("email").value);
        var validePassword = validatePassword(document.getElementById("password").value);

        if(!valideEmail)
        {
            let labelEmail = document.querySelector("label[for='email']");
            setErrorLabel(labelEmail);

            e.preventDefault();
            return false;
        }
        else
        {
            let labelEmail = document.querySelector("label[for='email']");
            unSetErrorLabel(labelEmail);
        }

        if(!validePassword)
        {
            let labelPassword = document.querySelector("label[for='password']");
            setErrorLabel(labelPassword);

            e.preventDefault();
            return false;
        }
        else
        {
            let labelPassword = document.querySelector("label[for='password']");
            unSetErrorLabel(labelPassword)
        }

        return true;
    }
});

