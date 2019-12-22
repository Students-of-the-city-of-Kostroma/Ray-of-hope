var inProgress = false;
var startFrom = 10;
$(document).ready(function() {
    $.ajax({
        dataType: "json",
        url: '/functions/functions.php',
        type: "POST",
        data: "getPosts=10",
        success: function(response) {
            response.forEach(element => {
                Posts.posts.push(element);
            });
        },
        error: function(response) {
            console.log('Ошибка. Данные не отправлены.');
        }
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
            $.ajax({
                dataType: "json",
                url: '/functions/functions.php',
                type: "POST",
                data: "getPosts=10&start_id" + startFrom,
                beforeSend: function() {
                    inProgress = true;
                },
                success: function(response) {
                    response.forEach(element => {
                        Posts.posts.push(element);
                    });
                    inProgress = false;
                    startFrom += 10;
                },
                error: function(response) {
                    console.log('Ошибка. Данные не отправлены.');
                }
            });

        }
    });

});

var Posts = new Vue({
    el: '#typePosts_newPost_posts-wrapper',
    data: {
        type_to_filter: 'all',
        posts: [
            /* ПРИМЕРЫ
            {
            type: 'need',
            author: 'Какая-то организация',
            author_avatar: 'http://ray-of-hope.loc/user_data/avatar/2.jpg',
            date: '23 июля в 20:00',
            text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            images: ['http://ray-of-hope.loc/user_data/docs/2/doc_5d62586c21b5b.jpg'],
            comments_count: 23,
            bookmark: false,
            need_collected_count: 27943,
            need_count: 100000
        }, {
            type: 'occurrence',
            author: 'Какая-то организация',
            author_avatar: 'http://ray-of-hope.loc/user_data/avatar/2.jpg',
            date: '23 июля в 20:00',
            text: 'Incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            images: [],
            comments_count: 26,
            bookmark: false,
        }, {
            type: 'event',
            author: 'Какая-то организация',
            author_avatar: 'http://ray-of-hope.loc/user_data/avatar/2.jpg',
            date: '23 июля в 20:00',
            text: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            images: ['http://ray-of-hope.loc/user_data/docs/2/doc_5d62586c21e28.jpg'],
            comments_count: 26,
            bookmark: false,
            start_date: '27 июля в 13:00',
            end_date: '28 июля в 13:00',
            event_address: 'Совесткая улица, 13',
        }*/
        ]
    },
    computed: {
        filteredPosts: function() {
            var typeFilter = this.type_to_filter;
            return this.posts.filter(function(elem) {
                if (typeFilter === 'all') {
                    return true
                } else {
                    return elem.type === typeFilter;
                }
            });
        }
    },
    methods: {
        deletePost: function(id_in_BD) {
            this.posts.forEach(function(post, i) {
                if (post.id == id_in_BD) {
                    $.ajax({
                        dataType: "json",
                        url: '/functions/functions.php',
                        type: "POST",
                        data: "deletePost=" + post.id,
                        success: function(response) {
                            if (response == true) {
                                Posts.posts.splice(i, 1);
                                $.ajax({
                                    dataType: "json",
                                    url: '/functions/functions.php',
                                    type: "POST",
                                    data: "getPosts=1&start_id" + startFrom,
                                    beforeSend: function() {
                                        inProgress = true;
                                    },
                                    success: function(response) {
                                        response.forEach(element => {
                                            Posts.posts.push(element);
                                        });
                                        inProgress = false;
                                        startFrom += 1;
                                    },
                                    error: function(response) {
                                        console.log('Ошибка. Данные не отправлены.');
                                    }
                                });
                            } else {
                                console.log('Ошибка. Не удалось удалить пост.');
                            }
                        },
                        error: function(response) {
                            console.log('Ошибка. Данные не отправлены.');
                        }
                    });


                }
            });
        },
        progressWidth: function(index) {
            return this.posts[index].need_collected_count * 100 / this.posts[index].need_count + '%';
        },
        dateConcatinate: function(index) {
            return this.posts[index].start_date + " - " + this.posts[index].end_date;
        }
    }
});