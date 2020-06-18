nameError = false;
emailError = false;
passError = false;
passConError = false;
function ValidateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
    }
    alert("You have entered an invalid email address!")
    return (false)
}

function ValidatePass(pass) {
    if (/[A-Za-z]/.test(pass)&&/[0-9]/.test(pass)) {
        return (true)
    }
    alert("You have entered an invalid password, it must have atleast one letter and number!")
    return (false)
}
$(document).ready(function () {
    $("#sign-up-form form div input[name='name'] ").change(function () {
        var val = $(this).val()
        //check for empty string
        
        if (val == "") {
            alert("Name feild cannot be left empty")
            $(this).parent().addClass("error-red")

            nameError = true;

        } else {
            $(this).parent().removeClass("error-red")
            nameError = false;
        }


    });
});
$(document).ready(function () {
    $("#sign-up-form form div input[name='email'] ").change(function () {
        var val = $(this).val()
        //check for empty string
        
        if (val == "") {
            alert("email feild cannot be left empty")
            $(this).parent().addClass("error-red")
            emailError = true;

        } else {
            $(this).parent().removeClass("error-red")
            emailError = false;

            //check email format
            if (ValidateEmail(val)) {
                $(this).parent().removeClass("error-red")
                emailError = false;
            } else {
                $(this).parent().addClass("error-red")
                emailError = true;
            }
        }


    });
});

$(document).ready(function () {
    $("#sign-up-form form div input[name='password'] ").change(function () {
        var val = $(this).val()
        //check for empty string
        
        if (val == "") {
            alert("password feild cannot be left empty")
            $(this).parent().addClass("error-red")
            passError = true;

        } else {
            $(this).parent().removeClass("error-red")
            passError = false;

            //check email format
            if (ValidatePass(val)) {
                $(this).parent().removeClass("error-red")
                passError = false;
            } else {
                $(this).parent().addClass("error-red")
                passError = true;
            }
        }


    });
});

//validate confirm password
$(document).ready(function () {
    $("#sign-up-form form div input[name='confirm-password'] ").change(function () {
        var val = $(this).val()
        var passVal=$("#sign-up-form form div input[name='password'] ").val()
        //check for empty string
        //console.log(passVal)
        if (val != passVal) {
            alert("password feilds must match.")
            $(this).parent().addClass("error-red")
            passConError = true;

        } else {
            $(this).parent().removeClass("error-red")
            passConError = false;
        }


    });
});

$(document).ready(function () {
    $("#sign-up-form form button").click(function () {

        if (passConError||passError||emailError||nameError) {
            //stop defalt button action if there an error

            alert("The errors must be fixed!")
            event.preventDefault()
        }

    });
});
