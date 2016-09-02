$(function () {
    Kommerce.addTooltip();
    Kommerce.addSpinners();
});

var Kommerce = Kommerce || {};

Kommerce = new function () {
    this.addTooltip = function () {
        $("[data-toggle='tooltip']").tooltip();
    };

    this.addSpinners = function () {
        var $this = this;
        $(document.body).on('click', 'a.btn, .pagination li:not(.disabled,.active) a', function (e) {
            $this.addButtonSpinner($(this));
        });

        $(document.body).on('submit', 'form', function (e) {
            var $button = $(this).find('.btn[type=submit]');
            if ($button.length) {
                $this.addButtonSpinner($button);
            }
        });
    };

    this.addButtonSpinner = function ($button, classString) {
        classString = classString || 'fa fa-spinner fa-pulse';
        $button.addClass('disabled');
        var $icon = $button.find('i');
        if ($icon.length) {
            $icon.attr('data-class', $icon.attr('class'));
            $icon.attr('class', classString);
        } else {
            $button.prepend('<i class="' + classString + '"></i> ');
        }
    };
};
