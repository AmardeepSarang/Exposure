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
function resetSlider() {
    $('.slider').each(function () {
        //reset slider to middle value
        var min = parseInt($(this).prop("min"), 10);
        var max = parseInt($(this).prop("max"), 10)
        //console.log(min)
        var mid = (max + min) / 2
        $(this).val(mid)
    })
}
function importImg(input) {
    //prints img  file from file input on to canvas
    if (input.files && input.files[0]) {
        resetSlider()
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

$("#up-ok").click(function () {
    var input = $("#imageLoader")[0];
    importImg(input);
    $('.upload-popup').removeClass('upload-show')

});

///////////////////////
// start 
//////////////////////
function importStartImg(path) {
    //prints img path from gallery onto canvas
    resetSlider()

    img = new Image();
    img.src = path;
    img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0, img.width, img.height);
        $("#editor-can").removeAttr("data-caman-id");
    }

}
$( window ).on("load", function() {
   var url_string = window.location.href
    var url = new URL(url_string);
    var path = url.searchParams.get("path");
    
    
    importStartImg(path)
});

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



////////////////////////////
//submit button handler
////////////////////////////
$("#edit-sub").click(function () {
    var url_string = window.location.href
    var url = new URL(url_string);
    //get parameters
    var id = url.searchParams.get("id");
    var img    = canvas.toDataURL("image/png");
    
    //window.location.href=new_url

    //add to post param by adding to form
    $('#upload-form').submit(function(){ //listen for submit event
        $('<input />').attr('type', 'hidden')
                .attr('name', "img")
                .attr('value', img)
                .appendTo('#upload-form');
    
        return true;
    }); 
})
