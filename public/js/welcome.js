$(document).ready(function(){
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();
    if (startchange.length){
        $(document).scroll(function() {
            scroll_start = $(this).scrollTop();
            if(scroll_start > offset.top) {
                $(".navbar-default").css({
                    backgroundColor: '#C3416E',
                    transition: 'background-color 0.5s'
                });
            } else {
                $('.navbar-default').css('background-color', '#D2527F');
            }
        });
    }
});
//# sourceMappingURL=welcome.js.map
