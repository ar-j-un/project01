$(document).on('click', '[data-parent-collapse]', function () {
    var target = $(this).data('parent-collapse');
    var $parent = $(target);

    if ($parent.length && !$parent.hasClass('show')) {
        $parent.collapse('show');
    }
});