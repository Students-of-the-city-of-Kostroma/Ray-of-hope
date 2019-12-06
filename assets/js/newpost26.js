var curDate=new Date();
$('[name="date-start"]').val(curDate.getDate()+curDate.getMonth()+curDate.getFullYear());
$('[name="date-start"]').val(43543);

$(".date").mask("99/99/9999");
$(".time").mask("99/99");
$('button.new_post').click(function(){
    if ($('.newpost-wrapper').hasClass('open')){
        $('.newpost-wrapper').css('display','none');
        $('.newpost-wrapper').removeClass('open');
        document.body.style.overflow = 'visible';
    }
    else{
        $('.newpost-wrapper').css('display','block');
        $('.newpost-wrapper').addClass('open');
         document.body.style.overflow = 'hidden';
    }
});

$('.closenewpost').click(function(){
    if ($('.newpost-wrapper').hasClass('open')){
        $('.newpost-wrapper').css('display','none');
        $('.newpost-wrapper').removeClass('open');
        document.body.style.overflow = 'visible';
    }
});


$('#file').on('change', function(){
    $('.imagelist_newpost').html("");
    if (this.files.length>0) {$('.imagelist_newpost').css('display','flex');}
    for (var i = 0; i < this.files.length; i++) {
            previewImg(this.files[i]);
    }
    
});

function previewImg(file){
    console.log(file.type);
    if (!(file.type=="image/jpeg")){
        open_dialog("Ошибка","Неверный тип файлов.<br><span>Загрузите изображение в формате jpg</span>");
        return;
    }
    var reader = new FileReader();
    reader.addEventListener('load', function(event){
        var newimg=document.createElement("img");
        newimg.setAttribute("src", event.target.result);
        $('.imagelist_newpost').append(newimg);
        newimg.onload = function() { $(".contentnewpost").scrollTop($(".contentnewpost")[0].scrollHeight); };
    });
    reader.readAsDataURL(file);
}

function open_dialog(title, message){
    if (title !== "")
    {
        $(".dialog-title").html(title);
	}	
	$(".dialog-message").html(message);    
    $(".dialog-wrapper").css({"display":"flex"});
}
function hide_dialog() {
	$(".dialog-wrapper").css({"display":"none"});
	$(".dialog-title").html("");
	$(".dialog-message").html("");
}



$('.listtypepost_item').click(function(){
    if (!$(this).hasClass('active')){
        $('.listtypepost_item').removeClass('active');
        $(this).addClass('active');
        $('.newpost_controls').css('display','none');
        if (this.id=='nuzhd'){
            $('.newpost_controls.nuzhd').css('display','block');
        }
        else{
            if (this.id==='meropr'){
                $('.newpost_controls.meropr').css('display','block');
            }
        }
    }
});