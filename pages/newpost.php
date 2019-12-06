
    <link href="../assets/css/newpost3.css" rel="stylesheet">
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
                <div class="listtypepost">
                    <button id="nuzhd" class="listtypepost_item active">Нужда</button>
                    <button id="meropr" class="listtypepost_item">Мероприятие</button>
                    <button id="sobit" class="listtypepost_item">Событие</button>
                </div>
                <div class="content-inputs">
                    <div class="contentnewpost">
                        <div class="text_newpost" contenteditable="true" placeholder="Введите текст..."></div>
                        <div class="imagelist_newpost">
                            <img src="">
                        </div>
                    </div>
                    <div class="newpost_controls nuzhd">
                        <div class="countnuzhd wrapper">
                            <div class="imput-title">Количество</div>
                            <input id="countnuzhd" name="countnuzhd" class="countnuzhd" type="number" placeholder="Введите количество...">
                        </div>
                    </div>
                    <div class="newpost_controls meropr">
                    <div class="address meropr wrapper">
                        <div class="dropdown">
                            <div class="address-list" style="display: none;"></div>
                        </div>
                        <div class="imput-title" style="z-index: 1;">Место</div>
                        <input value="" id="address" name="address" class="address" type="text" placeholder="Введите место...">
                    </div>
                    <div class="meropr-time">
                        <div class="start-time">
                            <div class="date wrapper">
                                <div class="imput-title">Дата начала</div>
                                <input placeholder="дд/мм/гггг" name="date-start" class="date" type="text" value="">
                            </div>
                            <div class="time wrapper">
                                <div class="imput-title">Время начала</div>
                                <input placeholder="чч/мм" name="time-start" class="time" type="text" value="">
                            </div>
                        </div>
                        <div class="end-time">
                            <div class="date wrapper">
                                <div class="imput-title">Дата завершения</div>
                                <input placeholder="дд/мм/гггг" name="date-end" class="date" type="text" value="">
                            </div>
                            <div class="time wrapper">
                                <div class="imput-title">Время завершения</div>
                                <input placeholder="чч/мм" name="time-end" class="time" type="text" value="">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="buttons-newpost">
                        <input multiple name="file" id="file" type="file" class="add-image">
                        <label for="file" class="add_photo_newpost">
                            <img src="../assets/img/load_image_new_post.png">
                        </label>
                        <button class="send-newpost">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>