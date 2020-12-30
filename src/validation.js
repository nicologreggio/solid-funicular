var redColor = "#B71C1C";

function validateEmail(email)
{
    var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;

    return regex.test(email);
}

function validatePassword(password)
{
    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;

    return regex.test(password);
}

function setErrorLabel(label)
{
    label.style.color = redColor;
}

function unSetErrorLabel(label)
{
    label.style.color = "black";
}
