const el = document.querySelectorAll("span#expireAt").forEach(item => {
    const expiresAt = new Date(item.getAttribute('data-expire')).getTime()
    setInterval(() => {
        const now = new Date().getTime();
        const t = expiresAt - now;
        const days = Math.floor(t /(1000 * 60 * 60 * 24));
        const hours = Math.floor((t%(1000 * 60 * 24))/(1000 * 60 *60));
        const minutes = Math.floor(t%((1000 * 60 * 60)) / (1000 * 60))
        const seconds = Math.floor(t%((1000 * 60)) / 1000)
        item.innerHTML = "Temps restant: " + (days > 0 ? days + "J " : '') + (hours > 0 ? hours + "h " : '') + (minutes > 0 ? minutes + "min " : '') + seconds + "s"
        /*item.innerHTML = "Fin dans: " + days + "J " + hours + "h " + minutes + "min " + seconds + "s"*/
        if(t < 0){
            clearInterval(this);
            item.style.background = "rgba(40, 167, 69, .8)"
            item.innerHTML = "L'offre est désormais terminé"
        }
    },1000)
})


