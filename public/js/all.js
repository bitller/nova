$(document).ready(function(){
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();
    if (startchange.length){
        $(document).scroll(function() {
            scroll_start = $(this).scrollTop();
            if(scroll_start > offset.top) {
                $(".navbar-default").css('background-color', '#f0f0f0');
                console.log('first');
            } else {
                console.log('second');
                $('.navbar-default').css('background-color', '#ff0000');
            }
        });
    }
});
//# sourceMappingURL=all.js.map