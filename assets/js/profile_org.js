function countLines(text){
    var tmpSpanWidth=document.createElement('span');
    tmpSpanWidth.innerHTML = text;
    tmpSpanWidth.className = 'text';
    $(tmpSpanWidth).appendTo('.description-wrapper2').css({
        display: 'none'
    }); 
    
    var lines = 0,
        outerWrap = $('<div class="outer_wrapper">'),
        innerWrap = $('<div class="inner_wrapper">');
    innerWrap.text(text+"... Больше").css({'display':'inline', 'white-space':'pre-line'}).appendTo(outerWrap);
    outerWrap.appendTo('.description-wrapper2').css({
        opacity: 0,
    });    
    lines = innerWrap[0].getClientRects().length;
    
    tmpSpanWidth.remove();
    outerWrap.remove();
    return lines;
}
function spanToMax3str(span){
    var arrStr = span.html().split(/\r*\n/);
    arrStr3=[];
    for (var i=0;i<arrStr.length && i<3;i++){
        arrStr3[i]=arrStr[i];
    }
    return arrStr3;
}
function resizeDescription(span){
    var arrStr = spanToMax3str(span);
    var totalLines=0;
    var resultStr="";
    for (var i=0; i<arrStr3.length && totalLines<3; i++){
        if (countLines(arrStr3[i])==1){
            resultStr+=arrStr3[i]+"\n";
            totalLines++;
        }
        if (countLines(arrStr3[i])==2){
            resultStr+=arrStr3[i]+"\n";
            totalLines++;
            totalLines++;
        }
        if (countLines(arrStr3[i])>=3){
            while(countLines(arrStr3[i])>(3-totalLines)){
                arrStr3[i]=arrStr3[i].substring(0, arrStr3[i].length - 1);
            }
            resultStr+=arrStr3[i]+"\n";
            totalLines=3;
        }
    }
    if (resultStr.length<span.attr('data-full').length){
        span.attr('data-min',resultStr.trim()+"...");
        $('.description-wrapper2>span.text').html(resultStr.trim()+"...");
        $('span.moreTextBtn').css('display','unset');
    }
}

resizeDescription($('.description-wrapper2>span.text'));

$('span.moreTextBtn').click(function(){
    if ($('span.moreTextBtn').hasClass('noclick')){
        $('.description-wrapper2>span.text').html($('.description-wrapper2>span.text').attr("data-full"));
        $('span.moreTextBtn').removeClass('noclick');
        $('span.moreTextBtn').html("Скрыть");
        
        $('span.moreTextBtn').css({'display':'block'});
    }
    else{
        $('.description-wrapper2>span.text').html($('.description-wrapper2>span.text').attr("data-min"));
        $('span.moreTextBtn').addClass('noclick');
        $('span.moreTextBtn').html("Больше");
        $('span.moreTextBtn').css({'display':'unset'});
    }
});




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