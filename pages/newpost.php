<link href="/assets/css/newpost3.css" rel="stylesheet">
<div class="newpost-wrapper">
    <div class="container">
        <div class="newpost-window">
            <div class="titlenewpost-close">
                <span class="titlenewpost">Новая запись</span>
                <button class="closenewpost">
                    <img src="/assets/img/close_newpost.png">
                </button>
            </div>
            <div class="listtypepost-contentnewpost">
                <form id="newpost_form">
                    <div class="listtypepost">
                        <div class="typepost_radio">
                            <input id="nuzhd_inpt" name="typepost" type="radio" value="nuzhd" checked>
                            <label for="nuzhd_inpt" class="listtypepost_item">Нужда</label>
                            <input id="meropr_inpt" name="typepost" type="radio" value="meropr">
                            <label for="meropr_inpt" class="listtypepost_item">Мероприятие</label>
                            <input id="sobit_inpt" name="typepost" type="radio" value="sobit">
                            <label for="sobit_inpt" class="listtypepost_item">Событие</label>
                        </div>
                    </div>
                    <div class="content-inputs">
                        <div class="contentnewpost">
                            <div class="text_newpost" contenteditable="true" placeholder="Введите текст..."></div>
                            <div class="imagelist_newpost">
                                <img src="">
                            </div>
                        </div>
                        <div class="variable_block">
                            <div class="imput-title">Количество</div>
                            <input id="countnuzhd" name="countnuzhd" class="countnuzhd" type="number" placeholder="Введите количество...">
                        </div>
                        <div class="buttons-newpost">
                            <input multiple name="file" id="file" type="file" class="add-image">
                            <label for="file" class="add_photo_newpost">
                                <img src="/assets/img/load_image_new_post.png">
                            </label>
                            <button class="send-newpost">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>