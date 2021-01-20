document.addEventListener("DOMContentLoaded", function() {
    var $hideShowPassword = document.getElementById("hide-show-password");
    var $passwordField = document.getElementById("password");


    $hideShowPassword.addEventListener("click", showHidePassword);

    function showHidePassword() {
        var eyeOffSrc = "/images/icons/eye-off.svg";
        var eyeOnSrc = "/images/icons/eye-on.svg";

        if($passwordField.type == "password")
        {
            $hideShowPassword.src = eyeOnSrc;
            $passwordField.type = "text"
        }
        else
        {
            $hideShowPassword.src = eyeOffSrc;
            $passwordField.type = "password";
        }
    }
});
