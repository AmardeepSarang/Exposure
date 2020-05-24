//////////////////////
//image preview 
/////////////////////
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            //insert image into preveiw 
            $('.image-preview img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$("#imginput").change(function () {
    readURL(this);

    //for error checking
    $('#filediv').removeClass('error-red')
});

/////////////////////////////////////
//error checking for empty title
/////////////////////////////////////

$(".form-box form button").click(function () {
    
    var hasError = false
    var val = $('#titleInput input').val();
    
    if (val == "") {
        hasError = true
    }

    if (hasError) {
        //stop default button action if there an error
        $('#titleInput').addClass('error-red')
       alert("Title cannot be empty!")
        event.preventDefault()
    }

    hasError = false
    if ($('#imginput').get(0).files.length === 0) {
        hasError=true
    }
    if (hasError) {
        //stop defalt button action if there an error
        $('#filediv').addClass('error-red')
       alert("No files selected!")
        event.preventDefault()
    }
    
});

$('#titleInput input').change(function () {
    //remove error when title is changed
    var val = $(this).val();
    console.log(val)
    if (val != "") {
        $('#titleInput').removeClass('error-red')
    }
    
})
