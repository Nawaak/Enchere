/** BASE CSS **/
import './css/app.scss';

/** BASE ELEMENTS **/
import './js/elements/index'
import {Alert} from './js/elements/alert';

if(user){
    const url = new URL('http://localhost:3001/.well-known/mercure');
    url.searchParams.append('topic', '/notifications/user/' + user);
    const eventSource = new EventSource(url, {
        withCredentials: true
    });
    eventSource.onmessage = event => {
        const data = JSON.parse(event.data)
        switch (data.type) {
            case 'notification':
                window.dispatchEvent(
                    new CustomEvent('notification', {
                        detail: data.data
                    })
                )
                break;
            default:
                Alert({message: 'Vous avez une nouvelle notification'})
        }

    }
}

const burger = document.querySelector(".burger")

if(burger){
    burger.addEventListener('click', function (){
        const navbar = document.querySelector('nav.navbar')
        document.body.classList.toggle('is-open')
        navbar.classList.toggle('is-open')
    })
}

document.addEventListener('DOMContentLoaded', () => {
    let windowHeight = window.innerHeight
    document.documentElement.style.setProperty('--vh', `${window.innerHeight  * 0.01}px`)
    document.documentElement.style.setProperty('--windowHeight', `${window.innerHeight}px`)

    window.addEventListener('resize', () => {
        if (windowHeight === window.innerHeight) {
            return
        }
        windowHeight = window.innerHeight
        document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`)
        document.documentElement.style.setProperty('--windowHeight', `${window.innerHeight}px`)
    })
})

