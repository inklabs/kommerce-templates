$(function() {
    addTooltip();
    addSpinners();
});

function addTooltip() {
    $("[data-toggle='tooltip']").tooltip();
}

function addSpinners() {
    $(document.body).on('click', 'a.btn, .pagination li:not(.disabled,.active) a', function (e) {
        addButtonSpinner($(this));
    });

    $(document.body).on('submit', 'form', function (e) {
        var $button = $(this).find('.btn[type=submit]');
        if ($button.length) {
            addButtonSpinner($button);
        }
    });
}

function addButtonSpinner($button, classString) {
    classString = classString || 'fa fa-spinner fa-pulse';
    $button.addClass('disabled');
    $icon = $button.find('i');
    if ($icon.length) {
        $icon.attr('data-class', $icon.attr('class'));
        $icon.attr('class', classString);
    } else {
        $button.prepend('<i class="' + classString + '"></i> ');
    }
}
