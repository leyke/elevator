$(document).ready(function () {
    var houseWrap = $('.js-house-wrap');
    var lastCallWrap = $('.js-last-call');
    var historyWrap = $('.js-history');

    $('.js-call-btn').on('click', function () {
        var floor = parseInt($(this).text());
        var btn = $(this);
        btn.addClass('is-waiting');
        $.ajax({
            url: "/call/",
            type: "POST",
            data: {floor: floor}
        }).done(function (answer) {
            if (answer) {
                var template = JSON.parse(answer);
                houseWrap.html(template.house);
                lastCallWrap.html(template.lastCall);
                historyWrap.html(template.history);
                btn.removeClass('is-waiting');
            }
        });
    });


    (function checkFirstFloor() {
        setTimeout(function () {
            $.ajax({
                url: "/check-first-floor/", success: function (data) {
                    if (data) {
                        houseWrap.html(data);
                    }
                }, complete: checkFirstFloor
            });
        }, 10000);
    })();
});


