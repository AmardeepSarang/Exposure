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
mainId = ""
$(".pic-edit-picker span img").hover(
    function () {
        //hover in
        var mainImg = $(this).parent().parent().parent().children('img')
        mainSrc = mainImg.attr('src')//store the src of the main image
        mainId = mainImg.attr('data-img')
        mainImg.attr('src', $(this).attr('src'));//swap to image
        mainImg.parent().attr('data-img', $(this).attr('data-img'));
    }, function () {
        //hover out, change back to original
        var mainImg = $(this).parent().parent().parent().children('img')
        var editBar = $(this).parent().parent().parent().children('.pic-edit-picker')
        mainImg.attr('src', mainSrc)
        mainImg.parent().attr('data-img', mainId)

        setActive(editBar, mainSrc)
      
    var btn=$(mainImg).parent().find(".like-bt")
    checkLike(btn)
    }
);

$(".pic-edit-picker span img").click(
    function () {
        //permanently change the main image to the new edit
        var mainImg = $(this).parent().parent().parent().children('img')
        mainSrc = mainImg.attr('src')
        mainId = mainImg.parent().attr('data-img')

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
function getIdList(editBar) {
    var idList = new Array();
    $(editBar).children('span').each(function () {

        var imgid = $(this).children('img').attr('data-img');
        //console.log(imgsrc);
        idList.push(imgid);
    });

    return idList;
}
function arrowClickHandle(target, direction) {
    //get main image and edit bar objects
    var mainImg = $(target).parent().parent().parent().children('img')
    var src = mainImg.attr('src')
    var editBar = $(target).parent().parent().parent().children('.pic-edit-picker')
    //get the src path for all edits in the bar
    var srcList = getSrcList(editBar);
    var idList = getIdList(editBar);
    //find current place in list
    var i = srcList.indexOf(src)

    //get next index with wrap
    if (direction == 'r') {
        //right arrow click
        i = (i + 1) % srcList.length
    } else {
        //left arrow click
        i = i - 1
        if (i < 0) {
            i = srcList.length - 1;
        }

    }
    //assign new image to main image
    mainImg.attr('src', srcList[i])
    mainImg.parent().attr('data-img', idList[i])
    setActive(editBar, srcList[i])

    //reset like btn
    var temp = $(target).parent().parent().parent()    
    var btn=$(temp).find(".like-bt")
    checkLike(btn)
}
$(".edit-sl-arw-r").click(function () { arrowClickHandle(this, 'r') }
);

$(".edit-sl-arw-l").click(function () { arrowClickHandle(this, 'l') }
);

function setActive(editBar, mainImgSrc) {
    //set the image to have selected style if it is the one selected
    $(editBar).children('span').each(function () {

        var img = $(this).children('img');

        if (img.attr('src') == mainImgSrc) {
            //added selected class
            img.addClass('pic-edit-picked')
        } else {
            //remove selected class
            img.removeClass('pic-edit-picked')
        }
    });
}

//////////////////////////////////////////////////////
// Script for full screen button 
///////////////////////////////////////////////////////
$('.fullscreen-bt').click(function () {
    //put current image in full screen div
    var mainImg = $(this).parent().parent().parent().children('img')
    var src = mainImg.attr('src')
    $('.gal-full-view img').attr('src', src)
    //show div
    $('.gal-full-view').addClass('gal-full-view-show')

});

$('.fullscreen-close-bt').click(function () {
    $('.gal-full-view').removeClass('gal-full-view-show')
});



//////////////////////////////////////////////////////
// Script for sorting and search
///////////////////////////////////////////////////////
function searchAndOrder(item) {

    //get values
    var sortVal = $('.gal-contr[name ="sort"]').val()
    var orderVal = $('.gal-contr[name ="order"]').val()
    var searchVal = $('input[name ="gal-search"]').val()
    //construct url
    url = 'gallery.php?sort=' + sortVal + '&order=' + orderVal
    if (searchVal != "") {
        //add search to url
        url = url + "&search=" + encodeURIComponent(searchVal)
    }
    console.log(url)
    //go to url with pramas (reload page)
    window.location.href = url;

}
$(".gal-contr").change(function () {
    searchAndOrder(this)
});

$("#gal-search-bt").click(function () {
    searchAndOrder(this)
});

$("#gal-clear-bt").click(function () {
    //console.log("clear")
    $('input[name ="gal-search"]').val("")//clear search
    searchAndOrder(this)
});
/////////////////////////////////////////////////////////////////////
///script for like bt
///////////////////////////////////////////////////////////////////// 

function checkLike(btn) {
    //change like btn based on like exits
    var icon = $(btn).children("i")
    var user = $(btn).parent().parent().parent().attr("data-user")
    var img = $(btn).parent().parent().parent().attr("data-img")
    // remove like to db
    $.ajax({
        url: "like.php",
        type: "POST",
        data: {
            user: user,
            img: img,
            insert: 2
        },
        cache: false,
        success: function (dataResult) {
            
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
                //toggle on like
                btn.addClass("like-color")//change color

                //make icon  solid
                icon.removeClass("far")
                icon.addClass("fas")

            }
            else if (dataResult.statusCode == 201) {
                //toggle off like
                btn.removeClass("like-color")//change color

                //make icon not solid
                icon.removeClass("fas")
                icon.addClass("far")
            }

        }
    });

}
$(".like-bt").click(function () {
    var icon = $(this).children("i")
    var user = $(this).parent().parent().parent().attr("data-user")
    var img = $(this).parent().parent().parent().attr("data-img")
    var btn = $(this);
    console.log(user)
    console.log(img)
    if (user != -1) {

        if (btn.hasClass("like-color")) {

            console.log("remove")

            // remove like to db
            $.ajax({
                url: "like.php",
                type: "POST",
                data: {
                    user: user,
                    img: img,
                    insert: 0
                },
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult)
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        //toggle off like
                        btn.removeClass("like-color")//change color

                        //make icon not solid
                        icon.removeClass("fas")
                        icon.addClass("far")

                    }
                    else if (dataResult.statusCode == 201) {
                        alert("Can't remove like!");
                    }

                }
            });


        } else {
            //add like to db
            console.log("Add")
            $.ajax({
                url: "like.php",
                type: "POST",
                data: {
                    user: user,
                    img: img,
                    insert: 1
                },
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult)
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        //toggle on like
                        btn.addClass("like-color")//change color

                        //make icon solid
                        icon.removeClass("far")
                        icon.addClass("fas")


                    }
                    else if (dataResult.statusCode == 201) {
                        console.log("Can't add like")
                    }

                }
            });



        }

    }
})