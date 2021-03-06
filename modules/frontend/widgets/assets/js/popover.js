$(document).ready(function () {
    var notFirstTime = $.cookie('gtd__first-time');

    var newsAll = $('body').find('.news__popover').find("a[data-news-id]");
    var newsIds = [];
    var newsCookieRecordedIds = [];

    if (typeof notFirstTime === "undefined") {
        var i = 0;
        newsAll.each(function () {
            if (i < 3) {
                $(this).addClass('active');

                $.cookie('news-' + parseInt($(this).attr("data-news-id")) + '-read', false, {
                    expires: 365,
                    path: "/"
                });
            } else {
                $.cookie('news-' + parseInt($(this).attr("data-news-id")) + '-read', true, {
                    expires: 365,
                    path: "/"
                });
            }
            $.cookie('news-' + parseInt($(this).attr("data-news-id")), parseInt($(this).attr("data-news-id")), {
                expires: 365,
                path: "/"
            });
            i++;
        });
    } else if (notFirstTime == 'true') {
        newsAll.each(function () {
            var newsEach = parseInt($(this).attr("data-news-id"));
            var newsCookieRecorded = $.cookie('news-' + parseInt($(this).attr("data-news-id")));
            var newsCookieRead = $.cookie('news-' + parseInt($(this).attr("data-news-id")) + '-read');

            newsIds.push(newsEach);
            newsCookieRecordedIds.push(newsCookieRecorded);

            if (newsCookieRead == 'false') {
                $(this).addClass('active');
                $.cookie('news-' + parseInt($(this).attr("data-news-id")), parseInt($(this).attr("data-news-id")), {
                    expires: 365,
                    path: "/"
                });
            }
        });

        $.each(newsCookieRecordedIds, function (index, value) {
            if (typeof value === "undefined") {
                $('body').find('.news__popover').find('a[data-news-id=' + newsIds[index] + ']').addClass('active');

                $.cookie('news-' + newsIds[index] + '-read', false, {
                    expires: 365,
                    path: "/"
                });

                $.cookie('news-' + newsIds[index], newsIds[index], {
                    expires: 365,
                    path: "/"
                });
            }
        });
    }

    $.cookie('gtd__first-time', true, {
        expires: 365,
        path: "/"
    });

    var allNewsCount = $('body').find('.news__popover').find("a.active[data-news-id]").length;

    if (allNewsCount == 0) {
        $('body').find('.counter__link').addClass('nobefore');
    } else {
        $('body').find('.counter__link').removeClass('nobefore');
        $('body').find('.counter__link').attr('data-count', allNewsCount);
    }
});
 