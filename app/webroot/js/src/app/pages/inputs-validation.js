(function (window, document, undefined) {
    'use strict';

    var InputsValidationApp = {
        load: function () {
            $(document).ready($.proxy(this.init, this));

        },

        init: function () {
            this.validation();
        },
        validation: function () {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener("input", () => {
                    const label = input.previousElementSibling;
                   if(label){
                    if (input.value.trim() !== '') {
                        label.classList.add('d-none');
                    } else {
                        label.classList.remove('d-none');
                    }
                   }
                })
            });

        }

    };

    InputsValidationApp.load();

    window.hozen.app.InputsValidationApp = InputsValidationApp;
}(window, window.document));