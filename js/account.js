function ValidatePass(pass) {
    if (/[A-Za-z]/.test(pass)&&/[0-9]/.test(pass)) {
        return (true)
    }
    return (false)
}
$('#deactivate').submit(function (evt) {
    
    var r = confirm("Are you sure you want to permanently delete your account!");
        if (r == false) {
          evt.preventDefault();
        }
    
});
$('#password').submit(function (evt) {
     var hasError=false
     var oldPass=$('#opass').val()
     var newPass=$('#npass').val()
     var conPass=$('#cpass').val()
if(!(ValidatePass(oldPass) &&ValidatePass(newPass) &&ValidatePass(conPass))){
    hasError=true;
    
    alert("You have entered an invalid password, it must have atleast one letter and number!")
}

if(newPass!=conPass){
    hasError=true
    alert("Your new passwords must match")
}
       if (hasError) {
          evt.preventDefault();
        }
    
});