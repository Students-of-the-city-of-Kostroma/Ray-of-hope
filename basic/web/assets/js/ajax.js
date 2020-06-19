$(document).ready(function() {

    $("#registr-citizen-button").click(
        function() {
            hide_hints();
            sendAjaxCitizenReg('ajax_form', "/index.php?r=registration-citizen%2Fcreate");
            return false;
        }
    );
    
    $("#registr-organisation-button").click(
        function() {
            hide_hints();
            sendAjaxOrgReg('ajax_form', "/index.php?r=registration-organisation%2Fcreate");
            return false;
        }
    );


    $("#login-organisation-button").click(
        function() {
            hide_hints();
            sendAjaxLogin('ajax_form', '/index.php?r=authorization-organisation%2Fcreate');
            return false;
        }
    );
    $("#login-citizen-button").click(
        function() {
            hide_hints();
            sendAjaxLoginCityzen('ajax_form', "/index.php?r=authorization-citizen%2Fcreate");
            return false;
        }
    );
});






function hide_hints() {
    $('.ico-in-textbox.znak').fadeOut(50);
    $('.hint').css({ "display": "none" });
}

function open_dialog(title, message) {
    if (title !== "") {
        $(".dialog-title").html(title);
    }
    $(".dialog-message").html(message);
    $(".dialog-wrapper").css({ "display": "flex" });
}

function hide_dialog() {
    $(".dialog-wrapper").css({ "display": "none" }); 
    $(".dialog-title").html("");
    $(".dialog-message").html("");
}

function sendAjaxLoginCityzen(ajax_form, url) {
   
    
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",

        data: $("#" + ajax_form).serialize(),
        success: function(response) {
            var result = $.parseJSON(response);

            /**
             * Структура json для регистрации пользователей
             *
             * - ошибки
             * -- errors
             * - заполнены ли все поля
             * -- isEmpty
             *
             * - корректны ли поля
             * -- isCorrected
             *
             * - совпадают ли пароли
             * -- isPassEqual
             *
             * - есть ли email в БД (зарегистрирован ли пользак)
             * -- isRegistered
             *
             * - страница перенаправления
             * -- newUrl
             *
             */

            console.log(result);

            // если есть ошибки
            if (result['newUrl'] !== null) {
                open_dialog("Поздравляем", "Вы авторизировались");
                setTimeout(function () {
                    document.location.href = result['newUrl'];
                },1000);

            }
            else {
                if (result['errors']['isEmpty'] == false) {
                    open_dialog("Ошибка", "Неверно указан логин или пароль");
                }

                else {
                    open_dialog("Ошибка", "Заполните все поля");
                }

                // // если все поля заполнены
                // if (result['errors']['isEmpty'] == false) {
                //     // если email корректен
                //     if (result['errors']['isEmailCorrected'] == false) {
                //         // если ИНН корректен
                //         if (result['errors']['isINNCorrected'] == false) {
                //             // если ИНН зарегистрирован
                //             if (result['errors']['isINNinFNS'] == false) {
                //                 // если пароль корректен
                //                 if (result['errors']['isPassCorrected'] == false) {
                //                     // если пароли совпадают
                //                     if (result['errors']['isPassEqual'] == false) {

                //                         if (result['errors']['isINNRegistered'] == false) {

                //                             open_dialog("Ошибка", "Email уже зарегистрирован");

                //                         } else {
                //                             open_dialog("Ошибка", "ИНН уже зарегистрирован в системе");
                //                         }                
                //                     } else {
                //                         open_dialog("Ошибка", "Пароли не совпадают");
                //                     }
                //                 } else {
                //                     open_dialog("Ошибка", "Некорректный пароль");
                //                 }
                //             }else {
                //                 open_dialog("Ошибка", "ИНН не зарегистрирован");
                //             }
                //         } else {
                //             open_dialog("Ошибка", "ИНН некорректен");
                //         }
                //     } else {
                //         open_dialog("Ошибка", "Некорректный email");
                //     }
                // } else {
                //     open_dialog("Ошибка", "Заполните все поля");
                // }
        }

        },
        error: function(response) {
            open_dialog("Ошибка", "Ошибка сервера");
        }
    });

    // var data = $("#" + ajax_form).serialize() + "&login_citizen=1";
    // $.ajax({
    //     url: url,
    //     type: "POST",
    //     dataType: "html",
    //     data: data,
    //     success: function(response) {
    //         result = $.parseJSON(response);
    //         if (result.length !== 0) {
    //             if (jQuery.inArray("empty", result) != -1) {
    //                 open_dialog("Ошибка", "Заполните все поля");
    //             } else {
    //                 if (jQuery.inArray("not_found_cityzen", result) != -1) {
    //                     open_dialog("Ошибка", "Неправильный логин и/или пароль");
    //                 }
    //             }
    //         } else {
    //             window.location.href = "/feed";
    //         }
    //     },
    //     error: function(response) {
    //         open_dialog("Ошибка", "Данные не отправлены");
    //     }
    // });


}

function sendAjaxLogin(ajax_form, url) {

    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",

        data: $("#" + ajax_form).serialize(),
        success: function(response) {
            var result = $.parseJSON(response);

            /**
             * Структура json для регистрации пользователей
             *
             * - ошибки
             * -- errors
             * - заполнены ли все поля
             * -- isEmpty
             *
             * - корректны ли поля
             * -- isCorrected
             */

            console.log(result);

            // если есть ошибки
            if (result['newUrl'] !== null) {
                open_dialog("Поздравляем", "Вы авторизировались");
                setTimeout(function () {
                    document.location.href = result['newUrl'];
                },1000);

            }
            // 1111111144@mail.ru
            else {
                if (result['errors']['isEmpty'] == false) {

                    if (result['errors']['isCorrect'] == false) {
                    
                        open_dialog("Ошибка", "Неверный пароль");

                    }
                    else {
                        open_dialog("Ошибка", "Неверный email или ИНН");
                    }
                }

                else {
                    open_dialog("Ошибка", "Заполните все поля");
                }
        }

        },
        error: function(response) {
            open_dialog("Ошибка", "Ошибка сервера");
        }
    });
}

function sendAjaxCitizenReg(ajax_form, url) {

    // if ($('input[name = "password"]')[0].value == $('input[name="password_2"]')[0].value) {

        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",

            data: $("#" + ajax_form).serialize(),
            success: function(response) {
                var result = $.parseJSON(response);

                /**
                 * Структура json для регистрации пользователей
                 *
                 * - ошибки
                 * -- errors
                 * - заполнены ли все поля
                 * -- isEmpty
                 *
                 * - корректны ли поля
                 * -- isCorrected
                 *
                 * - совпадают ли пароли
                 * -- isPassEqual
                 *
                 * - есть ли email в БД (зарегистрирован ли пользак)
                 * -- isRegistered
                 *
                 * - страница перенаправления
                 * -- newUrl
                 *
                 */

                console.log(result);

                // если есть ошибки
                if (result['newUrl'] !== null) {
                    open_dialog("Поздравляем", "Регистрация прошла успешна");
                    setTimeout(function () {
                        document.location.href = result['newUrl'];
                    },1000);

                }
                else {
                    // если все поля заполнены
                    if (result['errors']['isEmpty'] == false) {
                        // если email корректен
                        if (result['errors']['isEmailCorrected'] == false) {
                            // если пароль корректен
                            if (result['errors']['isPassCorrected'] == false) {
                                // если пароли совпадают
                                if (result['errors']['isPassEqual'] == false) {

                                    open_dialog("Ошибка", "Email уже зарегистрирован");
                                } else {
                                    open_dialog("Ошибка", "Пароли не совпадают");
                                }
                            } else {
                                open_dialog("Ошибка", "Некорректный пароль");
                            }
                        } else {
                            open_dialog("Ошибка", "Некорректный email");
                        }
                    } else {
                        open_dialog("Ошибка", "Заполните все поля");
                    }
            }

/*
                    if (jQuery.inArray("empty", result) != -1) {
                        open_dialog("Ошибка", "Заполните все поля");
                    } else {
                        if (jQuery.inArray("name", result) != -1) {
                            $('img#name').css({ "display": "block" });
                            $('.hint#name').html("До 100 символов. Допускаются буквы, цифры, знаки запятой и тире");
                            $('.hint#name').css({ "display": "block" });
                        }
                        if (jQuery.inArray("email", result) != -1) {
                            $('img#email').css({ "display": "block" });
                            $('.hint#email').html("Некоректный email");
                            $('.hint#email').css({ "display": "block" });
                        }
                        if (jQuery.inArray("INN", result) != -1) {
                            $('img#INN').css({ "display": "block" });
                            $('.hint#INN').html("Недействительный ИНН");
                            $('.hint#INN').css({ "display": "block" });
                        } else {
                            if (jQuery.inArray("audit", result) != -1) {
                                open_dialog("Ошибка", "Введенный ИНН не зарегистрирован в ФНС");
                            }
                        }
                        if (jQuery.inArray("password", result) != -1) {
                            $('.hint#password').css({ "display": "block" });
                        }
                        if (jQuery.inArray("emailNotFree", result) != -1) {
                            open_dialog("Ошибка", "Введенный адрес электронной почты уже зарегистрирован");
                        }
                        if (jQuery.inArray("innNotFree", result) != -1) {
                            open_dialog("Ошибка", "Введенный ИНН уже зарегистрирован");
                        }

                    }*/

                    // if (result['a'] === 'ok')
                    //     open_dialog("ok", result['b'])
                // }
                //
                //
                // else {
                //     open_dialog("Успешная регистрация", "На указанную почту отправлена ссылка для подтверждения")
                // }
            },
            error: function(response) {
                open_dialog("Ошибка", "Ошибка сервера");
            }
        });
    // } else {
    //     open_dialog("Ошибка", "Пароли не совпадают");
    // }
}


function sendAjaxOrgReg(ajax_form, url) {

    // if ($('input[name = "password"]')[0].value == $('input[name="password_2"]')[0].value) {

        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",

            data: $("#" + ajax_form).serialize(),
            success: function(response) {
                var result = $.parseJSON(response);

                /**
                 * Структура json для регистрации пользователей
                 *
                 * - ошибки
                 * -- errors
                 * - заполнены ли все поля
                 * -- isEmpty
                 *
                 * - корректны ли поля
                 * -- isCorrected
                 *
                 * - совпадают ли пароли
                 * -- isPassEqual
                 *
                 * - есть ли email в БД (зарегистрирован ли пользак)
                 * -- isRegistered
                 *
                 * - страница перенаправления
                 * -- newUrl
                 *
                 */

                console.log(result);

                // если есть ошибки
                if (result['newUrl'] !== null) {
                    open_dialog("Поздравляем", "Регистрация прошла успешна");
                    setTimeout(function () {
                        document.location.href = result['newUrl'];
                    },1000);

                }
                else {
                    // если все поля заполнены
                    if (result['errors']['isEmpty'] == false) {
                        // если email корректен
                        if (result['errors']['isEmailCorrected'] == false) {
                            // если ИНН корректен
                            if (result['errors']['isINNCorrected'] == false) {
                                // если ИНН зарегистрирован
                                if (result['errors']['isINNinFNS'] == false) {
                                    // если пароль корректен
                                    if (result['errors']['isPassCorrected'] == false) {
                                        // если пароли совпадают
                                        if (result['errors']['isPassEqual'] == false) {

                                            if (result['errors']['isINNRegistered'] == false) {

                                                if (result['errors']['isNameLen'] == false) {
                                                                                               
                                                    open_dialog("Ошибка", "Email уже зарегистрирован");
                                                }
                                                else {
                                                    open_dialog("Ошибка", "Название слишком длинное");
                                                }
                                            } else {
                                                open_dialog("Ошибка", "Организация с данным ИНН уже зарегистрирована");
                                            }                
                                        } else {
                                            open_dialog("Ошибка", "Пароли не совпадают");
                                        }
                                    } else {
                                        open_dialog("Ошибка", "Некорректный пароль");
                                    }
                                }else {
                                    open_dialog("Ошибка", "ИНН не зарегистрирован");
                                }
                            } else {
                                open_dialog("Ошибка", "Некорректный ИНН");
                            }
                        } else {
                            open_dialog("Ошибка", "Некорректный email");
                        }
                    } else {
                        open_dialog("Ошибка", "Заполните все поля");
                    }
            }

            },
            error: function(response) {
                open_dialog("Ошибка", "Ошибка сервера");
            }
        });
}