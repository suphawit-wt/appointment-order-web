function formValidation() {
    var usrname = document.person_form.username;
    var pwd = document.person_form.password;
    var conpwd = document.person_form.confirm_password;
    var name = document.person_form.fullname;

    checked = false;
    if (validateUserName(usrname, 5, 45)) {
        if (validatePassword(pwd, conpwd, 5, 45)) {
            if (validateName(name)) {
                return !checked;
            }
        }
    }
    return checked;
}

function validateUserName(usrname, min, max) {
    var error = "";
    var illegalChars = /\W/;

    if (usrname.value == "") {
        usrname.style.borderColor = "red";
        error = "*Please enter username. \n";
        alert(error);
        usrname.focus();
        return false;
    } else if ((usrname.value.length < min) || (usrname.value.length > max)) {
        usrname.style.borderColor = "red";
        error = "*Username must be in length " + min + "-" + max + " character. \n";
        alert(error);
        usrname.focus();
        return false;
    } else if (illegalChars.test(usrname.value)) {
        usrname.style.borderColor = "red";
        error = "*Username must not have special character. \n";
        alert(error);
        usrname.focus();
        return false;
    } else {
        usrname.style.borderColor = "#CEDADA";
    }
    return true;
}

function validatePassword(pwd, uconfirmpwd, min, max) {
    var error = "";
    var illegalChars = /[\W_]/;

    if (pwd.value == "") {
        pwd.style.borderColor = "red";
        error = "*Please enter password. \n";
        alert(error);
        pwd.focus();
        return false;
    } else if ((pwd.value.length < min) || (pwd.value.length > max)) {
        error = "*Password must be in length " + min + "-" + max + " character. \n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if (illegalChars.test(pwd.value)) {
        error = "*Password must not have special character. \n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if ((pwd.value.search(/[a-zA-Z]+/) == -1) || (pwd.value.search(/[0-9]+/) == -1)) {
        error = "*Password must have Alphabet and Number. \n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if (pwd.value != uconfirmpwd.value) {
        error = "*Password and Confirm Password must be match. \n";
        pwd.style.borderColor = "red";
        uconfirmpwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else {
        pwd.style.borderColor = "#CEDADA";
        uconfirmpwd.style.borderColor = "#CEDADA";
    }
    return true;
}

function validateName(name) {
    var letters = /^[A-Za-zก-๏ ]+$/;
    if (name.value == "") {
        name.style.borderColor = "red";
        error = "*Please enter full name. \n";
        alert(error);
        name.focus();
        return false;
    } else if (name.value.match(letters)) {
        return true;
    } else {
        alert('*Full Name must have only Alphabet.');
        name.focus();
        return false;
    }
}
