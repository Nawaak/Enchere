export default class RemainingTime extends HTMLElement {

    constructor() {
        super();
        this.span = document.createElement('span')
        this.appendChild(this.span)
        this.expiresAt = Date.parse(this.getAttribute('expire'))
        this.id = this.getAttribute('id')
    }

    connectedCallback () {
        this.count = setInterval(() => {
            const now = Date.parse(new Date())
            const remaining = (this.expiresAt - now)
            const days = Math.floor( remaining / (1000 * 60 * 60 * 24))
            const hours = Math.floor(( remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
            const minutes = Math.floor(( remaining % (1000 * 60 * 60)) / (1000 * 60))
            const seconds = Math.floor(( remaining % (1000 * 60)) / 1000)
            this.span.innerHTML = "Temps restant: " + (days > 0 ? days + "J " : '') + (hours > 0 ? hours + "h " : '') + (minutes > 0 ? minutes + "min " : '') + (minutes <= 10 && days <= 0 ? seconds + "s" : '')
            if(remaining <= 0){
                this.disconnectedCallback()
            }
        },1000)
    }

    disconnectedCallback() {
        clearInterval(this.count)
        this.span.style.background = "rgba(40, 167, 69, .8)"
        this.span.innerHTML = "L'offre est désormais terminée"
    }

}


