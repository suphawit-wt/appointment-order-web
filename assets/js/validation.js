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
        error = "กรุณากรอก Username \n";
        alert(error);
        usrname.focus();
        return false;
    } else if ((usrname.value.length < min) || (usrname.value.length > max)) {
        usrname.style.borderColor = "red";
        error = "User ID ต้องมีความยาว " + min + "-" + max + " ตัวอักษร\n";
        alert(error);
        usrname.focus();
        return false;
    } else if (illegalChars.test(usrname.value)) {
        usrname.style.borderColor = "red";
        error = "User ID มีตัวอักษรที่ไม่ได้รับอนุญาติ\n";
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
        error = "กรุณาป้อน Password\n";
        alert(error);
        pwd.focus();
        return false;
    } else if ((pwd.value.length < min) || (pwd.value.length > max)) {
        error = "Password ต้องมีความยาว " + min + "-" + max + " ตัวอักษร\n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if (illegalChars.test(pwd.value)) {
        error = "Password มีตัวอักษรที่ไม่ได้รับอนุญาติ\n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if ((pwd.value.search(/[a-zA-Z]+/) == -1) || (pwd.value.search(/[0-9]+/) == -1)) {
        error = "Password ต้องมีทั้งตัวเลขและตัวอักษร\n";
        pwd.style.borderColor = "red";
        alert(error);
        pwd.focus();
        return false;
    } else if (pwd.value != uconfirmpwd.value) {
        error = "Password ไม่ตรงกัน\n";
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
        error = "กรุณากรอก ชื่อ-นามสกุล\n";
        alert(error);
        name.focus();
        return false;
    } else if (name.value.match(letters)) {
        return true;
    } else {
        alert('ชื่อ-นามสกุล ต้องเป็นตัวอักษรเท่านั้น');
        name.focus();
        return false;
    }
}
