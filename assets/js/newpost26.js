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
    console.log(file.type);
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
    var variable_block = $('.variable_block').html('');
    variable_block.html('');
    if ($("input[value='nuzhd']").prop("checked")) {
        let title = document.createElement('div');
        title.className = "imput-title";
        title.innerHTML = 'Количество';
        variable_block.append(title);
        let countnuzhd = document.createElement('input');
        countnuzhd.id = "countnuzhd";
        countnuzhd.name = "countnuzhd";
        countnuzhd.className = "countnuzhd";
        countnuzhd.type = "number";
        countnuzhd.placeholder = "Введите количество...";
        variable_block.append(countnuzhd);
    } else {
        if ($("input[value='meropr']").prop("checked")) {
            let address_meropr_wrapper = document.createElement('div');
            address_meropr_wrapper.classList.add("address", "meropr", "wrapper");
            address_meropr_wrapper.id = "address_meropr_wrapper";
            let dropdown = document.createElement('div');
            dropdown.classList.add("dropdown");
            let address_list = document.createElement('div');
            address_list.classList.add("address-list");
            address_list.style = "display: none;";
            dropdown.append(address_list);
            address_meropr_wrapper.append(dropdown);
            let imput_title = document.createElement('div');
            imput_title.classList.add("imput-title");
            imput_title.classList.style = "z-index: 1;";
            imput_title.innerHTML = "Место";
            imput_title.style = "z-index: 1;";
            address_meropr_wrapper.append(imput_title);
            let address = document.createElement('input');
            address.id = "address";
            address.name = "address";
            address.className = "address";
            address.type = "text";
            address.placeholder = "Введите место...";
            address_meropr_wrapper.append(address);

            let meropr_time = document.createElement('div');
            meropr_time.classList.add("meropr-time");

            let start_time = document.createElement('div');
            start_time.classList.add("start-time");
            let date_wrapper = document.createElement('div');
            date_wrapper.classList.add("date", "wrapper");
            let imput_title2 = document.createElement('div');
            imput_title2.classList.add("imput-title");
            imput_title2.innerHTML = "Дата начала";
            let date_start = document.createElement('input');
            date_start.classList.add("date");
            date_start.placeholder = "дд/мм/гггг";
            date_start.name = "date-start";
            date_start.type = "text";
            date_wrapper.append(imput_title2);
            date_wrapper.append(date_start);
            let time_wrapper = document.createElement('div');
            time_wrapper.classList.add("time", "wrapper");
            let imput_title3 = document.createElement('div');
            imput_title3.classList.add("imput-title");
            imput_title3.innerHTML = "Время начала";
            let time_start = document.createElement('input');
            time_start.classList.add("time");
            time_start.placeholder = "чч/мм";
            time_start.name = "time-start";
            time_start.type = "text";
            time_wrapper.append(imput_title3);
            time_wrapper.append(time_start);
            start_time.append(date_wrapper);
            start_time.append(time_wrapper);

            let end_time = document.createElement('div');
            end_time.classList.add("end-time");
            let date_wrapper2 = document.createElement('div');
            date_wrapper2.classList.add("date", "wrapper");
            let imput_title4 = document.createElement('div');
            imput_title4.classList.add("imput-title");
            imput_title4.innerHTML = "Дата завершения";
            let date_end = document.createElement('input');
            date_end.classList.add("date");
            date_end.placeholder = "дд/мм/гггг";
            date_end.name = "date-end";
            date_end.type = "text";
            date_wrapper2.append(imput_title4);
            date_wrapper2.append(date_end);
            let time_wrapper2 = document.createElement('div');
            time_wrapper2.classList.add("time", "wrapper");
            let imput_title5 = document.createElement('div');
            imput_title5.classList.add("imput-title");
            imput_title5.innerHTML = "Время завершения";
            let time_end = document.createElement('input');
            time_end.classList.add("time");
            time_end.placeholder = "чч/мм";
            time_end.name = "time-end";
            time_end.type = "text";
            time_wrapper2.append(imput_title5);
            time_wrapper2.append(time_end);
            end_time.append(date_wrapper2);
            end_time.append(time_wrapper2);

            meropr_time.append(start_time);
            meropr_time.append(end_time);
            variable_block.append(address_meropr_wrapper);
            variable_block.append(meropr_time);

        }
    }
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
            for (var i in results['suggestions']) {
                let elem = {
                    index: i,
                    value: json['suggestions'][i]
                };
                Address.addresses.push(elem);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText + '|\n' + status + '|\n' + error);
        }
    });
}


if ($('#address_meropr_wrapper').length) {
    var Address = new Vue({
        el: '#address_meropr_wrapper',
        data: {
            addresses: [{
                index: '0',
                value: 'sdfsdf'
            }]
        }
    });
}