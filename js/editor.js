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

        reader.onload = function (e) {
            displayReset()
            //insert image
            $('#editor-img').attr('src', e.target.result);
            $('#editor-img').on('load', function (event) {
                //properly size canvas container

                var imgW = $(this).width()
                var imgH = $(this).height()

                $(".display .inner").height(imgH)
                $(".display .inner").width(imgW)

                //render canvas

                Caman("#editor-img",function () {
                    this.render();
                });
            });

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
    Caman("#editor-img", function () {
        this.exposure(val).render();
    });
})