function showHint(e) {
    $(".hint#" + e.id).addClass("open");
    $(".hint#" + e.id).fadeIn(100);
}
function hideHint(e) {
    $(".hint#" + e.id).removeClass("open");
    $(".hint#" + e.id).fadeOut(200);
}

jQuery(document).ready(function () {
    $(window).scroll(function() {
        if ($(this).scrollTop() <= 1){
            $('.navbar-wrapper').removeClass("navbar-wrapper-show");
            $('.navbar-wrapper').css({"min-height": ""});
            $('.navbar').css({"min-height": ""});
            $('.logo>.hand').css({"fill": "white"});
            $('.logo>.heart').css({"fill": "white"});
            $('.nav-link>a').css({"color":""});
            
            $('.nav-link>a').css({"color":""});
            
            $('.sub-menu').css({"box-shadow": "", "border-radius":"", "background-color":"", "top":""});
            $('.sub-menu>a').css({"color": "", "border":""});
            $('.sub-menu>a:first-of-type').css({"margin-top": ""});
            $('.sub-menu>a:hover').css({"color": "", "border":""});
            
        }
        else{
            
            $('.navbar-wrapper').addClass("navbar-wrapper-show");
            $('.navbar-wrapper').css({"min-height": "4.729167vw"});
            $('.navbar').css({"min-height": "4.729167vw"});
            $('.logo>.hand').css({"fill": "#5BACD3"});
            $('.logo>.heart').css({"fill": "#EF245B"});
            
            $('.nav-link>a').css({"color":"#a3a3a3"});
            
            $('.sub-menu').css({"box-shadow": "0 0.34375vw 1.04375vw #00000012", "border-radius":"0.98125vw", "background-color":"white", "top":"3.2vw"});
            $('.sub-menu>a').css({"color": "rgb(163, 163, 163)", "border":"none"});
            $('.sub-menu>a:first-of-type').css({"margin-top": "0.78125vw"});
            $('.sub-menu>a:hover').css({"color": "#5bacd3", "border":"none"});

        }
    });
    $('#avatar-link').on('click', function(e){
        $('html,body').stop().animate({ scrollTop: $('.header').offset().top }, 350);
        e.preventDefault();
    });
    
    
    $('#about-button').on('click', function(e){
        
        $('html,body').stop().animate({ scrollTop: $('.about').offset().top }, 350);
        e.preventDefault();
    });
    
    $('.nav-link.sub').click(function () {       

        if ($(this).find('.sub-menu').hasClass("open")) {        
            $('.sub-menu').removeClass("open");
            $('.sub-menu').hide();                
            $(this).find('.sub-menu').css({ "display": "none" });
        }
        else{
            $('.sub-menu').removeClass("open");
            $('.sub-menu').hide();             
            $(this).find('.sub-menu').addClass("open");
            $(this).find('.sub-menu').css({ "display": "flex" });
        }
    });
});
function hideAllHint() {
    $(".hint").fadeOut(200);
}


$(document).click(function (e) {
    if ($(e.target).attr("id")) {
        $(".hint").not("#" + (e.target).id).fadeOut(200);
    }
    else {
        $(".hint").fadeOut(200);
    }

    var container = $(".nav-link.sub");
    if (container.has(e.target).length === 0) {
        container.find('.sub-menu').hide();
    }
});


