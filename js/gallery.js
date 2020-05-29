//////////////////////////////////////////////////////
// Script for show/hide tool bar
///////////////////////////////////////////////////////
$(".img_box").click(function () {

    //remove from all other pics
    $(".img_box .pic-control-bar").removeClass("pic-control-bar-show")
    //show control for this control bar
    $(this).children('.pic-control-bar').addClass("pic-control-bar-show")
})


$(".edit-sl-bn").click(function () {
    //toggle the edit selector bar
    $(this).parent().parent().parent().children(".pic-edit-picker").toggleClass("pic-edit-picker-show")
})

//////////////////////////////////////////////////////
// Script for slecting edit by hovering/click
///////////////////////////////////////////////////////

//image
mainSrc = "";
$(".pic-edit-picker span img").hover(
    function () {
        //hover in
        var mainImg = $(this).parent().parent().parent().children('img')
        mainSrc = mainImg.attr('src')//store the src of the main image


        mainImg.attr('src', $(this).attr('src'));//swap to image
    }, function () {
        //hover out, change back to origina;
        var mainImg = $(this).parent().parent().parent().children('img')
        var editBar =$(this).parent().parent().parent().children('.pic-edit-picker')
        mainImg.attr('src', mainSrc)
        setActive(editBar, mainSrc)
    }
);

$(".pic-edit-picker span img").click(
    function () {
        //permanently change the main image to the new edit
        var mainImg = $(this).parent().parent().parent().children('img')
        mainSrc = mainImg.attr('src')

    }
);

//////////////////////////////////////////////////////
// Script for slecting edit using arrows
///////////////////////////////////////////////////////
function getSrcList(editBar) {
    var srcList = new Array();
    $(editBar).children('span').each(function () {

        var imgsrc = $(this).children('img').attr('src');
        //console.log(imgsrc);
        srcList.push(imgsrc);
    });

    return srcList;
}
function arrowClickHandle(target,direction) {
    //get main image and edit bar objects
    var mainImg = $(target).parent().parent().parent().children('img')
    var src = mainImg.attr('src')
    var editBar = $(target).parent().parent().parent().children('.pic-edit-picker')
    //get the src path for all edits in the bar
    var srcList = getSrcList(editBar);
    //find current place in list
    var i = srcList.indexOf(src)
    
    //get next index with wrap
    if (direction == 'r') {
        //right arrow click
        i = (i + 1) % srcList.length
    } else {
        //left arrow click
        i=i-1
        if(i<0){
            i=srcList.length-1;
        }
        
    }
    //assign new image to main image
    mainImg.attr('src', srcList[i])
    setActive(editBar, srcList[i])
}
$(".edit-sl-arw-r").click(function(){arrowClickHandle(this,'r')}
);

$(".edit-sl-arw-l").click(function(){arrowClickHandle(this,'l')}
);

function setActive(editBar, mainImgSrc){
    //set the image to have selected style if it is the one selected
    $(editBar).children('span').each(function () {

        var img = $(this).children('img');
        
        if(img.attr('src')==mainImgSrc){
            //added selected class
            img.addClass('pic-edit-picked')
        }else{
            //remove selected class
            img.removeClass('pic-edit-picked')
        }
    });
}

//////////////////////////////////////////////////////
// Script for full screen button 
///////////////////////////////////////////////////////
$('.fullscreen-bt').click(function(){
    //put current image in full screen div
    var mainImg = $(this).parent().parent().parent().children('img')
    var src = mainImg.attr('src')
    $('.gal-full-view img').attr('src',src)
    //show div
    $('.gal-full-view').addClass('gal-full-view-show')

});

$('.fullscreen-close-bt').click(function(){
    $('.gal-full-view').removeClass('gal-full-view-show')
});



//////////////////////////////////////////////////////
// Script for sorting and search
///////////////////////////////////////////////////////
function searchAndOrder(item){
    
    //get values
    var sortVal=$('.gal-contr[name ="sort"]').val()
    var orderVal=$('.gal-contr[name ="order"]').val()
    var searchVal=$('input[name ="gal-search"]').val()
    //construct url
    url='gallery.php?sort='+sortVal+'&order='+orderVal
    if(searchVal!=""){
        //add search to url
        url=url+"&search="+encodeURIComponent(searchVal)
    }
    console.log(url)
    //go to url with pramas (reload page)
    window.location.href = url;

}
$( ".gal-contr" ).change(function() {searchAndOrder(this)
  });

  $( "#gal-search-bt" ).click(function() {searchAndOrder(this)
  });