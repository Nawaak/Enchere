/** BASE CSS **/
import './css/app.scss';

/** BASE ELEMENTS **/
import './js/elements/index'
import {Alert} from "/js/elements/alert";

const url = new URL('http://localhost:3001/.well-known/mercure');

url.searchParams.append('topic', '/notifications/user/'+user);

const eventSource = new EventSource(url, {
    withCredentials: true
});
eventSource.onmessage = event => {
    const data = JSON.parse(event.data)
    switch (data.type) {
        case 'notification':
            Alert({message: `Une offre a était faite sur l'offre: ${data.data.bidding.name}`})
            break;
        default:
            Alert({message: 'Vous avez une nouvelle notification'})
    }

}