/**
 * Form Picker
 */

'use strict';

(function () {
    // Flat Picker
    // --------------------------------------------------------------------
    const datePicker1 = document.querySelector('#datePicker1');
    const datePicker2 = document.querySelector('#datePicker2');
    const datePicker3 = document.querySelector('#datePicker3');
    const datePicker4 = document.querySelector('#datePicker4');

    // Date
    if (datePicker1) {
        datePicker1.flatpickr({
            monthSelectorType: 'static',
            minDate: "today"
        });
    }
    if (datePicker2) {
        datePicker2.flatpickr({
            monthSelectorType: 'static',
            minDate: "today"
        });
    }
    if (datePicker3) {
        datePicker3.flatpickr({
            monthSelectorType: 'static',
            minDate: "today"
        });
    }
    if (datePicker4) {
        datePicker4.flatpickr({
            monthSelectorType: 'static',
            maxDate: "today"
        });
    }

})();
 