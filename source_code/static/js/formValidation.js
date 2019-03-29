function formValidation() {
    var first_name = document.registration.first;
    var last_name = document.registration.last;
    var email = document.registration.email;
    var pwd = document.registration.pwd;
    var pwd2 = document.registration.pwd2;
    var checkbox = document.getElementById("gridCheck1").checked;

    if (name_validation(first_name) && allLetter(first_name)) {
        if (name_validation(last_name) && allLetter(last_name)) {
            if (ValidateEmail(email)) {
                if (pass_validation(pwd, 8, 14)) {
                    if (pass_validation(pwd2, 8, 14) && pass_same(pwd, pwd2)) {
                        if(checkbox_validation(checkbox)) {}
                    }
                }
            }
        }
    }

    return false;
}

function name_validation(uid) {
    var name_len = uid.value.length;
    if (name_len == 0) {
        alert("First / Last Name should not be empty");
        uid.focus();
        return false;
    }
    return true;
}

function pass_validation(pass, mx, my) {
    var pass_len = pass.value.length;
    if (pass_len == 0 || pass_len >= my || pass_len < mx) {
        alert("Password should not be empty / length be between " + mx + " to " + my);
        pass.focus();
        return false;
    }
    return true;
}

function pass_same(pwd, pwd2) {
    if (pwd2.stringify() !== pwd.stringify()) {
        return true;
    } else {
        alert("Password does not match");
        pwd2.focus();
        return false;
    }
}

function allLetter(uname) {
    var letters = /^[A-Za-z]+$/;
    if (uname.value.match(letters)) {
        return true;
    } else {
        alert('First / Last name must have alphabet characters only');
        uname.focus();
        return false;
    }
}

function ValidateEmail(uemail) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (uemail.value.match(mailformat)) {
        return true;
    } else {
        alert("You have entered an invalid email address!");
        uemail.focus();
        return false;
    }
}
function checkbox_validation(check_box) {
    if (check_box === false) {
        alert('Check Box must be checked!');
        return false;
    }
    return true;
}
// Cde3Xsw2Zaq1