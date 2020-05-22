//change arrow direction
$('.user-heading  button').click(function(){
    var icon=$(this).children('i');
    if($(icon).hasClass('fa-chevron-circle-right')){
        $(icon).removeClass('fa-chevron-circle-right')
        $(icon).addClass('fa-chevron-circle-down')
    }else if($(icon).hasClass('fa-chevron-circle-down')){
        $(icon).removeClass('fa-chevron-circle-down')
        $(icon).addClass('fa-chevron-circle-right')
    }
});