const el = document.querySelectorAll("span#expireAt").forEach(item => {
  const expiresAt = Date.parse(item.dataset.expire);
  const x = setInterval(() => {
    const now = Date.parse(new Date());
    console.log(now);
    const t = expiresAt - now;
    const days = Math.floor(t / (1000 * 60 * 60 * 24));
    const hours = Math.floor(t / 1000 * 60 * 60 % 60);
    const minutes = Math.floor(t % (1000 * 60 * 60) / (1000 * 60));
    const seconds = Math.floor(t % (1000 * 60) / 1000);
    item.innerHTML = "Temps restant: " + (days > 0 ? days + "J " : '') + (hours > 0 ? hours + "h " : '') + (minutes > 0 ? minutes + "min " : '') + seconds + "s";
    /*item.innerHTML = "Fin dans: " + days + "J " + hours + "h " + minutes + "min " + seconds + "s"*/

    if (t < 0) {
      clearInterval(x);
      item.style.background = "rgba(40, 167, 69, .8)";
      item.innerHTML = "L'offre est désormais terminé";
    }
  }, 1000);
});

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = import('./jquery-945f90a2.js').then(function (n) { return n.j; });
$('[data-toggle="popover"]').popover({
  html: true,
  sanitize: false,
  content: `<div class="d-flex align-items-around flex-grow-1 w-100">
        <input type="text" class="form-control form-control-sm" placeholder="Entrer un montant">
        <a class="btn btn-sm btn-success text-white mx-2" onclick="alert('Êtes-vous sûr?')">Valider</a>
        <a class="btn btn-sm btn-danger text-white" id="pop-close">Annuler</a>
</div>`
});
$('html').on('click', function (e) {
  if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover') || e.target.id === 'pop-close') {
    $('[data-original-title]').popover('hide');
  }
});
