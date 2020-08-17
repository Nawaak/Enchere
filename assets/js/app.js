/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import '../css/app.scss';
import './count-time'

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        html: true,
        sanitize: false,
        content: `<div class="d-flex align-items-around flex-grow-1 w-100">
            <input type="text" class="form-control form-control-sm" placeholder="Entrer un montant">
            <a class="btn btn-sm btn-success text-white mx-2" onclick="alert('Êtes-vous sûr?')">Valider</a>
            <a class="btn btn-sm btn-danger text-white" id="pop-close">Annuler</a>
    </div>`
    })
    $('html').on('click', function(e) {
        if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover') || e.target.id === 'pop-close') {
            $('[data-original-title]').popover('hide');
        }
    });

});
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

