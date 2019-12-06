$(".date").mask("99/99/9999");
$(".time").mask("99/99");
$('button.new_post').click(function() {
    if ($('.newpost-wrapper').hasClass('open')) {
        $('.newpost-wrapper').css('display', 'none');
        $('.newpost-wrapper').removeClass('open');
        document.body.style.overflow = 'visible';
    } else {
        $('.newpost-wrapper').css('display', 'block');
        $('.newpost-wrapper').addClass('open');
        document.body.style.overflow = 'hidden';
    }
});

$('.closenewpost').click(function() {
    if ($('.newpost-wrapper').hasClass('open')) {
        $("#newpost_form")[0].reset();
        $('.text_newpost').html("");
        $('.newpost-wrapper').css('display', 'none');
        $('.newpost-wrapper').removeClass('open');
        document.body.style.overflow = 'visible';
    }
});


$('#file').on('change', function() {
    $('.imagelist_newpost').html("");
    if (this.files.length > 0) { $('.imagelist_newpost').css('display', 'flex'); }
    for (var i = 0; i < this.files.length; i++) {
        previewImg(this.files[i]);
    }

});

function previewImg(file) {
    if (!(file.type == "image/jpeg")) {
        open_dialog("Ошибка", "Неверный тип файлов.<br><span>Загрузите изображение в формате jpg</span>");
        return;
    }
    var reader = new FileReader();
    reader.addEventListener('load', function(event) {
        var newimg = document.createElement("img");
        newimg.setAttribute("src", event.target.result);
        $('.imagelist_newpost').append(newimg);
        newimg.onload = function() { $(".contentnewpost").scrollTop($(".contentnewpost")[0].scrollHeight); };
    });
    reader.readAsDataURL(file);
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

$("input[name='typepost']").change(function() {
    inputs = document.querySelectorAll('.variant input');
    inputs.forEach(function(input) {
        input.value = '';
    });
    $('.variant input').attr('disabled', true);
    $('.variant').hide();
    if ($("input[value='nuzhd']").prop("checked")) {
        $('.variant.nuzhda input').removeAttr('disabled');
        $('.variant.nuzhda').show();
    } else {
        if ($("input[value='meropr']").prop("checked")) {
            $('.variant.meropriyatie input').removeAttr('disabled');
            $('.variant.meropriyatie').show();
        }
    }
});

var globalTimeout = null;

$(document).ready(function() {
    $("#address").keyup(
        function() {
            if (globalTimeout !== null) clearTimeout(globalTimeout);
            if ($(this).val().length >= 1) {
                globalTimeout = setTimeout(getAddresList, 50);
            } else {
                Address.addresses = [];
            }
            if ($('.address-list')[0].childNodes.length) {
                $('.address-list').show();
            } else {
                if ($('.address-list').is(':visible')) {
                    $('.address-list').hide();
                }
            }
        }
    );
});

function getAddresList() {
    globalTimeout = null;
    var ajax;
    var data = new FormData();
    data.append('city_hints', 1);
    data.append('request_city', $("#address").val());

    ajax = $.ajax({
        type: "POST",
        url: "../../functions/functions.php",
        processData: false,
        contentType: false,
        dataType: 'json',
        data: data,
        beforeSend: function() {
            if (ajax) {
                ajax.abort();
            }
        },
        success: function(results) {
            Address.addresses = [];
            for (var i in results['suggestions']) {
                let elem = {
                    index: i,
                    value: results['suggestions'][i]['value']
                };
                Address.addresses.push(elem);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText + '|\n' + status + '|\n' + error);
        }
    });
}


var Address = new Vue({
    el: '#address_meropr_wrapper',
    data: {
        addresses: []
    }
});