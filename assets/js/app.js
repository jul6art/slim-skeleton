// any CSS you require will output into a single css file (app.css in this case)
import "../css/app.scss";

import $ from 'jquery';
import 'jquery-ui';
import 'bootstrap';
import toastr from 'toastr';
import './main';

$.App = {
    init: function () {
        $('[data-toggle="dropdown"]').dropdown();
    },
    notify: function (level, message) {
        switch (level) {
            case 'danger':
            case 'error':
                toastr.error(message);
                break;
            case 'info':
                toastr.info(message);
                break;
            case 'success':
                toastr.success(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            default:
                toastr.info(message);
                break;
        }
    }
};

$(document).ready(function () {
    $.App.init();
    $('[data-trigger="toast"]').each(function () {
        $.App.notify($(this).data('level'), $(this).text());
        $(this).remove();
    })
});