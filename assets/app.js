/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();

    $('[id*=btncheck_]').on('click', function () {
        let numbers = '';
        $('[id*=btncheck_]').each(function () {
            if (this.checked) {
                numbers += this.value + '-'
            }

        });

        $('#search').val(numbers.slice(0, -1));
    });

    $('#lightSwitch').on('click', function () {
        switchChange();
    });

    $('#search').on('click', function () {
        switchChange();
    });

    $('#limit').on('change', function () {
        switchChange();
    });

    let switchChange = function () {
        setTimeout(function() {
            let lightSwitch = localStorage.getItem('lightSwitch');
            if (lightSwitch === 'dark') {
                $('table').each(function (key, element) {
                    element.classList.add('table-dark');
                })
            }
        },500)
    };
});
