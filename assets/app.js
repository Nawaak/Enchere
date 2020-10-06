import './css/app.scss';
import './js/count-time.js'
import '@fortawesome/fontawesome-free'

$('[data-toggle="popover"]').popover({
    html: true,
    sanitize: false,
    content: `<div class="d-flex align-items-around flex-grow-1 w-100">
        <input type="text" class="form-control form-control-sm" autofocus placeholder="Entrer un montant">
        <a class="btn btn-sm btn-success text-white mx-2" onclick="alert('Êtes-vous sûr?')">Valider</a>
        <a class="btn btn-sm btn-danger text-white" id="pop-close">Annuler</a>
</div>`
})
$('html').on('click', function(e) {
    if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover') || e.target.id === 'pop-close') {
        $('[data-original-title]').popover('hide');
    }
});

