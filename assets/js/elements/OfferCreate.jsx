import React from "preact/compat";
import {render} from 'preact'
import {Button, Popover, OverlayTrigger} from 'react-bootstrap'
import {useCallback, useRef} from "preact/hooks";
import {useFetchOffer} from "../hooks/fetchUrl";
import {hideUsername} from "../functions/hideUsername";
import {Alert} from '../elements/alert'

const Offer = ({bidding, user}) => {
    const price = useRef(0)
    const {loading, load} = useFetchOffer('http://localhost:8000/api/offer_biddings', 'POST', function() {
        // callback pour alert + ajout du <li> qui affiche les l'enchere effectuée
        document.body.click()
        const hiddenUsername = hideUsername(user)
        const ul = document.querySelector('.list-group')
        const last = document.querySelector('#last-offer')
        const row = document.createElement('li')
        row.classList.add('list-group-item')
        row.classList.add('text-primary')
        row.innerHTML = `
            ${hiddenUsername}, a fait une offre de <b>${new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' , minimumFractionDigits: 0}).format(price.current.value) }</b>
        `
        last.innerHTML = `${new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' , minimumFractionDigits: 0}).format(price.current.value)}`
        ul.prepend(row)
        console.log(row)
        row.classList.add('fadein')
        row.onanimationend = function() {
            setTimeout(() => {
                row.classList.remove('fadein')
                row.classList.remove('text-primary')
            }, 3000)
        }
        Alert({message:'Votre offre à bien été prise en compte'})
    })

    const handleSubmit = useCallback(async () => {
        await load({
            price: parseInt(price.current.value, 10),
            bidding: '/api/biddings/' + parseInt(bidding, 10)
        })
    }, [load, price, bidding])

    const handleKey = async(e) => {
        if(e.key === 'Enter'){
            await handleSubmit()
        }
    }

    const popover = <Popover id="popover-basic" show={false}>
            <Popover.Title as="h3">Faire une offre</Popover.Title>
            <Popover.Content>
                <div className="d-flex justify-content-between">
                    <input type="text" className="form-control form-control-sm" ref={price} onKeyPress={e => handleKey(e)} placeholder="Entrer un montant" />
                    <button className="btn btn-sm btn-info text-white ml-2" id="js-valid-offer" disabled={loading} onClick={handleSubmit}>Valider</button>
                    <button className="btn btn-sm btn-danger text-white ml-2" id="js-cancel-offer" onClick={() => document.body.click()}>Annuler</button>
                </div>
            </Popover.Content>
        </Popover>

    return <div className={'d-flex justify-content-end'}>
        <OverlayTrigger trigger="click" placement="auto" rootClose overlay={popover} onHide>
            <Button variant="info" className={'btn-sm'}>Faire une offre</Button>
        </OverlayTrigger>
    </div>
}

export default class OfferCreate extends HTMLElement {

    connectedCallback () {
        this.id = this.dataset.id
        this.user = this.dataset.user
        //recuperer ici les dataset this.dataset.Etc
        render(<Offer bidding={this.id} user={this.user}/>, this)
    }
}