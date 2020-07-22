// Will use the PHP proxy in the proxies folder.
Caman.remoteProxy = Caman.IO.useProxy('php');
var img = new Image();
var canvas = document.getElementById('editor-can');
var ctx = canvas.getContext('2d');

//controls for upload pop-up
$("#edit-up").click(function () {
    $('.upload-popup').toggleClass('upload-show')

});

$("#up-can").click(function () {
    $('.upload-popup').removeClass('upload-show')

});

//////////////////////////
//import the image 
/////////////////////////
function displayReset() {
    
    //delete previous canvas and create fresh container
    $('#editor-img').remove();
    $(".inner").append('<img id="editor-img" src="" alt="">');
    $(".display .inner").css('width', "")
    $(".display .inner").css("height", "")

}
function importImg(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();
//insert image
            
        reader.onload = function (e) {
            img = new Image();
            img.src = reader.result;
            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
                $("#editor-can").removeAttr("data-caman-id");
            }
            
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$("#imageLoader").change(function () {

    importImg(this);

});
/*
$("#up-ok").click(function () {
    
    importImg($("#imageLoader"));

});*/

//////////////////////
//listen for change in sliders
////////////////////////
$("#slide-exp").change(function () {
    var val = $(this).val()
    console.log(val)
    Caman("#editor-can", function () {
        this.exposure(val).render();
    });
})