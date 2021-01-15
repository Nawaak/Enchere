/** BASE CSS **/
import './css/app.scss';

/** BASE ELEMENTS **/
import './js/elements/index'
import {Alert} from './js/elements/alert';

if(user){
    const url = new URL('http://localhost:3001/.well-known/mercure');
    url.searchParams.append('topic', '/notifications/user/' + user);
    const eventSource = new EventSource(url, {
        withCredentials: false
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
        const navbar = document.querySelector('.test')
        navbar.classList.toggle('is-open')
    })
}