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
require('@fortawesome/fontawesome-free');

$(document).ready(function() {
    let lotoTheme = localStorage.getItem('loto-theme');

    function init() {
        if (lotoTheme === null) {
            localStorage.setItem('loto-theme', 'dark')
            lotoTheme = localStorage.getItem('loto-theme');
        }

        currentTheme();
    }


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

    let currentTheme = function() {
        let $currentTheme = $('#current_theme');
        if(localStorage.getItem('loto-theme') === 'dark') {
            $currentTheme.html('<i class="fa-solid fa-moon fa-lg"></i>');
        }
        if(localStorage.getItem('loto-theme') === 'light') {
            $currentTheme.html('<i class="fa-solid fa-sun fa-lg"></i>');
        }
        if(localStorage.getItem('loto-theme') === 'auto') {
            $currentTheme.html('<i class="fa-solid fa-circle-half-stroke fa-lg">');
        }
        switchChange();
    };

    $('[id*=loto-theme-]').on('click', function() {
        localStorage.setItem('loto-theme', $('#'+$(this)[0].id).data('bsThemeValue'));
        switchChange();
    });

    let switchChange = function() {
        $('html').attr('data-bs-theme', localStorage.getItem('loto-theme'))
    };

    init();
});
