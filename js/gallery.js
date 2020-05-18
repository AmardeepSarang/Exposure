
$(".img_box").click(function(){

    //remove from all other pics
    $(".img_box .pic-control-bar").removeClass("pic-control-bar-show")
    //show control for this control bar
    $(this).children('.pic-control-bar').addClass("pic-control-bar-show")
})


$(".edit-sl-bn").click(function(){
    console.log($(this).parent().parent().parent().children(".pic-edit-picker").html())
    //toggle the edit selector bar
    $(this).parent().parent().parent().children(".pic-edit-picker").toggleClass("pic-edit-picker-show")
})