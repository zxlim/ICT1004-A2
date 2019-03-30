function formValidation() {
    console.log("INSIDE");
    var product_name = document.creating.product_name;
    var product_desc = document.creating.product_desc;
    var price = document.creating.price;
    var condition = document.creating.condition;
    var product_age = document.creating.age;

    if (name_validation(product_name)) {
        if (name_validation(product_desc)) {
            if (allnumeric(price)) {
                if (allnumeric(condition)) {
                    if (allnumeric(product_age)) {
                    }
                }
            }
        }
    }

    return false;
}

function name_validation(uid) {
    var name_len = uid.value.length;
    if (name_len === 0) {
        alert("Field cannot be empty");
        uid.focus();
        return false;
    }
    return true;
}


function allnumeric(num) {
    var numbers = /^[0-9]+$/;
    if (num.value.match(numbers)) {
        return true;
    } else {
        alert('Field must have numeric characters only');
        num.focus();
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