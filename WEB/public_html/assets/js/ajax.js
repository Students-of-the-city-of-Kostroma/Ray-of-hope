$(document).ready(function () {

    var data = new FormData();
    data.append('profile_org_info', 1 );
    data.append('org_id', 2);
    
    
    $.ajax({
        type: 'POST',
        url: "../../functions/functions.php",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function(response){
        result = $.parseJSON(response);
        console.log(result);
        },
        error: function(request){
        console.log(request);
            }
        
    });
    
    var data2 = new FormData();
    data2.append('login_org', 1 );
    data2.append('email_or_inn', 'shtaubstas@gmail.com');
    data2.append('password', 'sfsdfsdf');
    
    
    $.ajax({
        type: 'POST',
        url: "../../functions/functions.php",
        cache: false,
        contentType: false,
        processData: false,
        data: data2,
        success: function(response){
        result = $.parseJSON(response);
        console.log(result);
        },
        error: function(request){
        console.log(request);
            }
        
    });





	$("#registr-button").click(
		function () {
			hide_hints();
			sendAjaxReg('ajax_form', '../../functions/functions.php');
			return false;
		}
	);
	$("#login-button").click(
		function () {
			hide_hints();
			sendAjaxLogin('ajax_form', '../../functions/functions.php');
			return false;
		}
	);
	$("#login-citizen-button").click(
		function () {
			hide_hints();
			sendAjaxLoginCityzen('ajax_form', '../../functions/functions.php');
			return false;
		}
	);
});
function hide_hints(){
    $('.ico-in-textbox.znak').fadeOut(50);
    $('.hint').css({"display":"none"});
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
function sendAjaxLoginCityzen(ajax_form, url) {
    var data = $("#" + ajax_form).serialize()+"&login_citizen=1";
	$.ajax({
		url: url,
		type: "POST",
		dataType: "html",
		data: data,
		success: function (response) {
			result = $.parseJSON(response);
			if (result.length !== 0) {
				if (jQuery.inArray("empty", result) != -1) {
					open_dialog("Ошибка", "Заполните все поля");
				}
				else {
				    if (jQuery.inArray("not_found_cityzen", result) != -1)
				    {
				        open_dialog("Ошибка", "Неправильный логин и/или пароль");
				    }
				}
			}
			else 
			{
			    window.location.href = "https://rayofhope-opensource.000webhostapp.com/feed";
			}
		},
		error: function (response) 
		{
		    open_dialog("Ошибка", "Данные не отправлены");
		}
	});
}
function sendAjaxLogin(ajax_form, url) {
    var data = $("#" + ajax_form).serialize()+"&login_org=1";
	$.ajax({
		url: url,
		type: "POST",
		dataType: "html",
		data: data,
		success: function (response) {
			result = $.parseJSON(response);
			if (!('successful_authorization' in result)) {
				if ('empty' in result) {
					open_dialog("Ошибка", "Заполните все поля");
				}
				else {
				    if ('not_found_org' in result)
				    {
				        open_dialog("Ошибка", "Неправильный логин и/или пароль");
				    }
				}
			}
			else 
			{
			    window.location.href = "https://rayofhope-opensource.000webhostapp.com/feed";
			}
		},
		error: function (response) 
		{
		    open_dialog("Ошибка", "Данные не отправлены");
		}
	});
}
function sendAjaxReg(ajax_form, url) {
    if ($('input[name="password"]')[0].value==$('input[name="password_2"]')[0].value){
        $.ajax({
		url: url,
		type: "POST",
		dataType: "html",
		data: $("#" + ajax_form).serialize(),
		success: function (response) {
			result = $.parseJSON(response);
			if (result.length !== 0) {
				if (jQuery.inArray("empty", result) != -1) {
					open_dialog("Ошибка", "Заполните все поля");
				}
				else {
				    if (jQuery.inArray("name", result) != -1)
				    {
				        $('img#name').css({"display":"block"});
				        $('.hint#name').html("До 100 символов. Допускаются буквы, цифры, знаки запятой и тире");
				        $('.hint#name').css({"display":"block"});
				    }
				    if (jQuery.inArray("email", result) != -1)
				    {
				        $('img#email').css({"display":"block"});
				        $('.hint#email').html("Некоректный email");
				        $('.hint#email').css({"display":"block"});
				    }
				    if (jQuery.inArray("INN", result) != -1)
				    {
				        $('img#INN').css({"display":"block"});
				        $('.hint#INN').html("Недействительный ИНН");
				        $('.hint#INN').css({"display":"block"});
				    }
				    else{
				        if (jQuery.inArray("audit", result) != -1)
				        {
				            open_dialog("Ошибка", "Введенный ИНН не зарегистрирован в ФНС");
				        }
				    }
				    if (jQuery.inArray("password", result) != -1)
				    {
				        $('.hint#password').css({"display":"block"});
				    }
				    if (jQuery.inArray("emailNotFree", result) != -1)
				    {
				        open_dialog("Ошибка", "Введенный адрес электронной почты уже зарегистрирован");
				    }
				}
			}
			else 
			{
			    open_dialog("Успешная регистрация", "На указанную почту отправлена ссылка для подтверждения")
			}
		},
		error: function (response) 
		{
		    open_dialog("ОшибкаДанные не отправлены");
		}
	});
    }
    else{
        open_dialog("Ошибка","Пароли не совпадают");
    }
}