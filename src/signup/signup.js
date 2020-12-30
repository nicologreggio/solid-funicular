document.addEventListener("DOMContentLoaded", function() {
    var $signupForm = document.getElementById("signup-form");

    $signupForm.addEventListener("submit", submitSignup)

    function submitSignup(e)
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

