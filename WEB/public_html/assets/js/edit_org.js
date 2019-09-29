var avatar;
var queue={};
var previewQueue={};

function previewAvatar(file){
if (!(file.type=="image/jpeg")){
open_dialog("Ошибка","Неверный тип файлов.<br><span>Загрузите изображение в формате jpg</span>");
            return;
}
    var reader = new FileReader();
    reader.addEventListener('load', function(event){
        $('.avatar-wrapper').find('.avatar-doublewrapper').find('.avatar').attr('src', event.target.result);
    });
    reader.readAsDataURL(file);
}
function previewDocs(evt){
    var docsTmp = evt.target.files;
    
    for (var i =0; i < docsTmp.length;i++){
        if (!(docsTmp[i].type=="image/jpeg" || docsTmp[i].type=="application/pdf" || docsTmp[i].type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
        {
            open_dialog("Ошибка","Неверный тип файлов.<br><span>Поддерживаемые форматы: pdf, docx, jpg</span>");
            return;
        }
        $('.listDocItem.addDoc').before('<div class="listDocItem loading '+i+'"></div>');
        
        var reader = new FileReader();
        reader.onload = (function(theFile, id) {
            return function(e) {
                if (theFile.type=="application/pdf"){
                    previewPDF(e, theFile, id);
                }
                else {
                    if (theFile.type=="image/jpeg"){
                        previewJPG(theFile, id);
                    }
                    else{
                        if (theFile.type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                            previewDOC(theFile, id);
                        }
                    }
                }
                queue[theFile.name] = theFile;
            };
        })(docsTmp[i], i);
        reader.readAsBinaryString(docsTmp[i]);
    }
    document.getElementById('docUpload').value='';
}



function previewPDF(event, file, item_id){
    var filename=file.name;
    var binaryPDF =  event.target.result;
    var loadingTask = pdfjsLib.getDocument({data: binaryPDF});
    loadingTask.promise.then(function(pdf) {
        var pageNumber = 1;
        pdf.getPage(pageNumber).then(function(page) {
            var addDocButton = document.querySelectorAll('.listDocItem.addDoc')[0];
            var scale = 5*addDocButton.offsetWidth/page.getViewport().viewBox[2];
            var canvas = document.createElement("canvas");
            var context = canvas.getContext('2d');
            canvas.height = 5*addDocButton.offsetHeight;
            canvas.width = 5*addDocButton.offsetWidth;
            var viewport=page.getViewport({scale:scale});
            var renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);
            renderTask.promise.then(function () {
                var listDoc = document.getElementsByClassName('list-doc')[0];
                var itemDocList = $('.listDocItem.loading.'+item_id)[0];
                $(itemDocList).removeClass('loading');
                var link = document.createElement("a");
                link.href=URL.createObjectURL(file);
                link.setAttribute('target', '_blank');
                //itemDocList.className="listDocItem";
                var img = new Image();
                img.src = canvas.toDataURL();
                var previewFile = new File([canvas.toDataURL()], filename, {type: "image/png", lastModified: Date.now()});
                previewQueue[filename]=previewFile;
                itemDocList.appendChild(link);
                link.appendChild(img);
            });
        });
    }, function (reason) {
        console.error(reason);
    });
}
function previewJPG(file, item_id){
    var reader = new FileReader();
    reader.addEventListener('load', function(event) {
        $('.listDocItem.loading.'+item_id).removeClass('loading');
        $('.listDocItem.'+item_id).html('<a target="_blank" href="'+URL.createObjectURL(file)+'"><img src="'+event.target.result+'"></a>');
    });
    reader.readAsDataURL(file);
}
function previewDOC(file, item_id){
    var data = new FormData();
    data.append('docx2pdf', 1 );
    data.append('document', file);
    
    
    $.ajax({
        type: 'POST',
        url: "../../functions/docx2pdf.php",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(blob){
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                    return function(e) {
                        var binaryPDF=e.target.result;
                        var filename=file.name;
                        var loadingTask = pdfjsLib.getDocument({data: binaryPDF});
                        loadingTask.promise.then(function(pdf) {
                            var pageNumber = 1;
                            pdf.getPage(pageNumber).then(function(page) {
                                var addDocButton = document.querySelectorAll('.listDocItem.addDoc')[0];
                                var scale = 5*addDocButton.offsetWidth/page.getViewport().viewBox[2];      
                                var canvas = document.createElement("canvas");
                                var context = canvas.getContext('2d');
                                canvas.height = 5*addDocButton.offsetHeight;
                                canvas.width = 5*addDocButton.offsetWidth;
                                var viewport=page.getViewport({scale:scale});
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                var renderTask = page.render(renderContext);
                                renderTask.promise.then(function () {
                                    var listDoc = document.getElementsByClassName('list-doc')[0];
                                    var itemDocList = $('.listDocItem.loading.'+item_id)[0];
                                    $(itemDocList).removeClass('loading'); 
                                    var link = document.createElement("a");
                                    link.href=URL.createObjectURL(file);
                                    link.setAttribute('target', '_blank');
                                    var img = new Image();
                                    img.src = canvas.toDataURL();
                                    var previewFile = new File([canvas.toDataURL()], filename, {type: "image/png", lastModified: Date.now()});
                                    previewQueue[filename]=previewFile;
                                    itemDocList.appendChild(link);
                                    link.appendChild(img);
                                });
                            });
                        }, function (reason) {
                            console.error(reason);
                        });
                    };
                })(blob);
                reader.readAsBinaryString(blob);
        },
        error: function(request){
            //Файл не прошёл проверку расширения и mime-типа на сервре
            if (request.status==666){ 
                
                $('.listDocItem.loading.'+item_id).remove();
                open_dialog("Ошибка","Загруженные файлы повреждены");
            }
        }
    });
}

window.JsFile;
    
$(document).ready(function () {
    var data2 = new FormData();
    data2.append( 'city_hints', 1 );
    data2.append( 'request_city', "моск" );
	$.ajax({
	    type: 'POST',
        data: data2,
        cache: false,
        dataType: 'json',
        processData : false,
        contentType : false,
		url: "../../functions/functions.php",
		success: function (response) {
		    response.forEach(function(v) {
		        console.log(v);
		    });
		},
		error: function(request, status, error)
		{
		    console.log(request);
		    console.log(status);
		    console.log(error);
		}
	});
    
    
    
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
    
    // сохраняем аватар в переменную при изменнии инпута для аватара
    $('#file').on('change', function(){
        avatar = this.files[0];
        previewAvatar(avatar);
    });
    
    document.getElementById('docUpload').addEventListener('change', previewDocs, false);
    
    // обработка и отправка AJAX запроса при клике на кнопку upload_files
    $('.saveButton').on( 'click', function( event ){
        var name = $('input.name').val().trim()==='' ? null : $('input.name').val();
        if (name===null){open_dialog("Ошибка","Введите название");return;}
        var city= $('input.city')[0].hasAttribute("id_city") ? $('input.city').attr("id_city") : null;
        if (!$('input.city')[0].hasAttribute("id_city")){ $('input.city').val(""); }
        
        var city_name= (city===null)?"":$('input.city').val();
        var activity = $('select.activity').val();
        var description=$('textarea.description').val();
        var contacts=$('textarea.contacts').val();
        
        var data = new FormData();
        
        //заполняем массив документов из очереди 
        for (var id in queue) {
             data.append('docs[]', queue[id]);
        }
        for (var id2 in previewQueue) {
             data.append('preview[]', previewQueue[id2]);
        }
        // переменная идентификатор запроса
        data.append( 'edit_profile_org', 1 );
        if (typeof avatar != 'undefined'){data.append( 'avatar', avatar );}
        data.append( 'name', name );
        data.append( 'city', city );
        data.append( 'city_name', city_name );
        data.append( 'activity', activity );
        data.append( 'description', description );
        data.append( 'contacts', contacts );
        
        $.ajax({
            url: '../../functions/functions.php',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData : false,
            contentType : false,
            success     : function( response )
            {
                if (response.length !== 0){
                    if (jQuery.inArray("description", response) != -1){
                        open_dialog("Ошибка", "Максимальная длинна описания: 255 символов");
                    }
                    if (jQuery.inArray("contacts", response) != -1){
                        open_dialog("Ошибка", "Максимальная длинна контактной информации: 255 символов");
                    }
                    else{
                        open_dialog("Ошибка", "Не удалось изменить информацию");
                    }
                }
                else{
                    queue={};
                    previewQueue={};
                    open_dialog("Готово","Информация успешно изменена");
                }
            },
            error: function(request)
            {
                //Не все файлы прошли проверку расширения и mime-типа на сервере 
                if (request.status==666){ 
                    open_dialog("Ошибка","Один или несколько загруженных файлов повреждены");
                }
            }
        });
    });
    
    var globalTimeout = null;  
	$("#city").keyup(
	    function () {
	        $(this).removeAttr("id_city");
	        if(globalTimeout !== null) clearTimeout(globalTimeout); 
	        if ($(this).val().length >= 1){
	            lobalTimeout =setTimeout(getSityList,250); 
	        }
	    }
	);
	$("input.city").click(
		function () {
		    if ($('.city-list').html()!==''){
		    openCityList();}
		}
	);
});

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
$(document).mouseup(function (e) {
    var container = $(".city-list");
    if (container.has(e.target).length === 0){
        hideCityList();
    }
});
$(document).on('click','.city-item', function(){
    var select_city_id = $(this).attr("data-city_id");
    $('input.city').attr({"id_city":select_city_id});
    $('input.city').val($(this).children(".city-name").html());
    hideCityList();
});
function hideCityList(){
    $('.city-list').css({"display":"none"});
    $('input.city').removeAttr("style");
    $('.city.wrapper').removeClass('line-city-list');
}
function openCityList(){
    $('.city-list').css({"display":"block"});
    $('input.city').css({"border": "none","padding":"1px calc(0.9375vw + 0.0520833333vw)"});
    $('.city.wrapper').addClass('line-city-list');
}
function getSityList(){
    globalTimeout = null;
    var ajax;
    ajax = $.ajax ({    
        type: "POST",
        url:"../../functions/functions.php",
        dataType: 'json',
        data: {request : $("#city").val()},
        beforeSend: function(){
            if (ajax){ 
                ajax.abort(); 
            }
        },
        success: function(results) {
            showCityList(results);
        },
        error: function(xhr, status, error) {
            (xhr.responseText + '|\n' + status + '|\n' +error);
        }
    });
}
function showCityList(json){
    $('.city-list').empty();
    for (var i in json){
        $('.city-list').append("<div data-city_id='" + json[i].id + "' class='city-item'><span class='city-name'>" + json[i].name + "</span><span class='city-region'>" + json[i].region + "</span></div>");
        }
    if ($('.city-list').html()!==''){
        openCityList();
    }
}
