$(document).on("click", ".ajax-selector", function (e) {

    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");

    var target_element = $(e.currentTarget).data('content');
    var target = $(e.currentTarget).attr('href');
    var tabBody = $(target + ' .item-content');
    tabBody.load(target_element);

    $(".loader-populate").html("");
})