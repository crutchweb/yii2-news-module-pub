$("body").on("click", "#load_more", function (e) {
    e.preventDefault();
    let btn = $(this);
    let offset = $('.cart__block').length;
    let cat_id = $(this).attr('data-cat_id');

    btn.button("loading");

    var data = {
        'offset' : offset,
        '_csrf'  : yii.getCsrfToken()
    }

    if (cat_id) {
        data['cat_id'] = cat_id
    }

    $.ajax({
        url: '/ajax-news-cards',
        type: 'POST',
        data: data,
        dataType: 'html',
        timeout: 120000,
        success: function (data) {
            $('.row.carts.news').append(JSON.parse(data).html);
            btn.button("reset").blur();
            if (JSON.parse(data).count < 12) {
                btn.hide();
            }
        },
        error: function (e) {
            showAlert('danger', 'Во время загрузки данных произошла неизвестная ошибка. Попробуйте позднее.', 'bottom');
        }
    });
});