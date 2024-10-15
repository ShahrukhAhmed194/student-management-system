$(document).on("click", "[data-bs-toggle='tab']", function (e) {
    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
    var target_element = $(e.currentTarget).data('content');
    var target = $(e.currentTarget).attr('href');
    var tab = $(target);
    var tabBody = $(target + ' .tab-content');
    tabBody.load(target_element);
    $(".loader-populate").html("");

})

$(window).on('load', function () {
    var target_element = $(".first_tab").find("a").data("content");
    var target = $(".first_tab").find("a").attr("href");
    var tab = $(target);
    var tabBody = $(target + ' .tab-content');

    tabBody.load(target_element);
})
