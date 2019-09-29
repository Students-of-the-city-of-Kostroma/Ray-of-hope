function deleteActiveClass(){
    if ($(".nav-link").hasClass("active")){
        $(".nav-link").removeClass("active");
    }
    if ($(".avatar-link").hasClass("active")){
        $(".avatar-link").removeClass("active");
    }
}
function changeActiveLink(el){
    deleteActiveClass();
    $(el).addClass("active");
}
$(document).ready(function () {
    if (window.location.href=="https://rayofhope-opensource.000webhostapp.com/edit" || window.location.href=="https://rayofhope-opensource.000webhostapp.com/org/"+document.getElementById('org_id') || window.location.href=="https://rayofhope-opensource.000webhostapp.com/citizen/"+document.getElementById('citizen_id')){
        $('#nav-avatar').addClass("active");
    }
    if (window.location.href=="https://rayofhope-opensource.000webhostapp.com/feed"){
            $('#nav-feed').addClass("active");
    }
    if (window.location.href=="https://rayofhope-opensource.000webhostapp.com/"){
            $('.nav-link>a').removeClass("active");
            $('.nav-link>a').removeClass("active");
    }
    if (window.location.href=="https://rayofhope-opensource.000webhostapp.com/registration/org"){
            $('.nav-link#reg>a').addClass("active");
    }
    if (window.location.href=="https://rayofhope-opensource.000webhostapp.com/login/org"){
            $('.nav-link#login>a').addClass("active");
    }
    
    $('.nav-link').click(function(){
        if (!$(this).hasClass('sub')) changeActiveLink(this);
    });
    $('.avatar-link').click(function(){
        changeActiveLink(this);
    });
    
});