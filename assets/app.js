/** BASE CSS **/
import './css/app.scss';

/** BASE ELEMENTS **/
import './js/elements/index'
import {Alert} from "/js/elements/alert";

const url = new URL('http://localhost:3001/.well-known/mercure');

url.searchParams.append('topic', 'http://example.com/books/');

const eventSource = new EventSource(url, {
    withCredentials: true
});
eventSource.onmessage = event => {
    Alert({message: event.data})
}