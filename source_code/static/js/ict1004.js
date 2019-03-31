/**
 * ict1004.js
 *
 * Contains useful functions for use in FastTrade.
 */

function HtmlSpecialChars(str) {
    /**
     * Encodes certain characters into HTML entities.
     * A layer to reduce success rates of XSS attacks.
     */
    const entities = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "/": "&#x2F;",
        "`": "&#x60;",
        "=": "&#x3D;"
    };

    return String(str).replace(/[&<>"'`=\/]/g, function (c) {
        return entities[c];
    });
}

function notify(msg, type) {
    /**
     * Notification banner popup.
     * Makes use of `bootstrap-notify.js`.
     */
    const valid_types = ["info", "success", "warning", "danger"];

    if (type === null || valid_types.includes(String(type)) == false) {
        type = "info";
    }

    if (msg !== null || String(msg).trim().length !== 0) {
        $.notify({
            message: "<span class='text-center'>" + String(msg) + "</span>"
        }, {
            allow_dismiss: true,
            type: String(type),
            placement: {
                from: "bottom",
                align: "right"
            },
            width: "400px",
        });
    }
}

function validate_form_notempty(form_data) {
    /**
     * Function to check that all form inputs are filled.
     *
     * @param    form_data    array        Form data serialised into an array.
     *
     * @return    result        Boolean        True if form is not empty else false.
     */
    if (form_data === null) {
        return false;
    }

    for (var i = 0; i < form_data.length; i++) {
        if (form_data[i].value === null || String(form_data[i].value).length === 0) {
            return false;
        }
    }
    return true;
}

function validate_email(str) {
    /**
     * Function to check if string has a valid email format.
     *
     * @param    form_data    String        Input to check.
     *
     * @return    result        Boolean        True if string is valid else false.
     */
    const email_format = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
    return Boolean(str.match(email_format, "i"));
}

function allnumeric(num) {
    var numbers = /^[0-9]+$/;
    if (num.match(numbers)) {
        return true;
    } else {
        return false;
    }
}

function decimals(num) {
    var numbers = /^[-+]?[0-9]+\.[0-9]+$/;
    if (num.match(numbers)) {
        return true;
    } else {
        return false;
    }
}

function select(val) {
    if (val === "Default") {
        return false;
    } else {
        return true;
    }
}

$(document).ready(function () {
    $(".no-click, .no-click-pointer, .no-click-event").on("click touchend", function (e) {
        e.preventDefault();
        return false;
    });

    $("#form-login").on("submit", function (e) {
        if (validate_form_notempty($(this).serializeArray()) === false) {
            notify("Please fill in all required fields.", "warning");
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    });

    $("#form-register").on("submit", function (e) {
        const form_data = $(this).serializeArray();
        const result = zxcvbn($("#password1").val());

        $("#error-password2").text("");

        if (validate_form_notempty(form_data) === false) {
            notify("Please fill in all required fields.", "warning");
            e.preventDefault();
            return false;
        } else if (validate_email($("#email").val()) === false) {
            notify("Please enter a valid email address.", "warning");
            e.preventDefault();
            return false;
        } else if ($("#password1").val() !== $("#password2").val()) {
            $("#error-password2").text("Confirm your password again.");
            notify("Please check that you have entered the correct password.", "warning");
            $("#password2").val("");
            e.preventDefault();
            return false;
        } else if ($("#password1").val().length < 8) {
            $("#error-password2").text("Your password must have 8 characters or more.");
            notify("Please enter a stronger password.", "warning");
            $("#password1").val("");
            $("#password2").val("");
            e.preventDefault();
            return false;
        } else if (result.score < 3) {
            $("#error-password2").text(result.feedback.warning + ". " + result.feedback.suggestions);
            notify("Please enter a stronger password.", "warning");
            $("#password1").val("");
            $("#password2").val("");
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    });

    $("#form-verification").on("submit", function (e) {
        if (validate_form_notempty($(this).serializeArray()) === false) {
            notify("Please enter your verification code.", "warning");
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    });

    $("#form_selling").on("submit", function (e) {
        const form_data = $(this).serializeArray();
        var link_array = $("input[name='imgur_link[]']").map(function () {
            return $(this).val();
        }).get();

        if (validate_form_notempty(form_data) === false) {
            notify("Please fill in all required fields.", "warning");
            e.preventDefault();
            return false;
        } else if (link_array.length === 0) {
            notify("No image uploaded. Please upload some images to the product", "warning");
            e.preventDefault();
            return false;
        }
        else if (allnumeric($("#price").val()) === false || decimals($("#price").val() === false)) {
            notify("Product Price is not in the correct format.", "warning");
            e.preventDefault();
            return false;
        } else if (allnumeric($("#condition").val()) === false) {
            notify("Product Condition is not in the correct format.", "warning");
            e.preventDefault();
            return false;
        } else if (allnumeric($("#age").val()) === false) {
            notify("Product Age is not in the correct format.", "warning");
            e.preventDefault();
            return false;
        } else if (select($("#categorySelection").val()) === false) {
            notify("Product Category is required.", "warning");
            e.preventDefault();
            return false;
        } else if (select($("#locationSelection").val()) === false) {
            notify("Meetup Location is required.", "warning");
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    });
});