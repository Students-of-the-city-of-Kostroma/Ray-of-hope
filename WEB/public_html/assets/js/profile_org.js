$(document).ready(function () {
    var tmpAllDocText;
    $('.all-doc').click(function(){
        if (!$('.all-doc').hasClass('view')){
            tmpAllDocText= $('.all-doc').html();
            $('.profileInfo>.docs>.list-doc').css({"max-height": "unset", "overflow": "unset"});
            $('.all-doc').html('Cкрыть');
            $('.all-doc').addClass('view');
        }
        else{
            $('.profileInfo>.docs>.list-doc').css({"max-height": "", "overflow": ""});
            $('.all-doc').html(tmpAllDocText);
            $('.all-doc').removeClass('view');
        }
    });
});