import RemainingTime from "./CountTime";
import OfferCreate from "./OfferCreate.jsx";
import {TimeAgo} from "./TimeAgo";
import {Notif} from "./Notification.jsx";
import register from "preact-custom-element";

customElements.define('count-time', RemainingTime);
customElements.define('offer-create', OfferCreate);
customElements.define('time-ago', TimeAgo);

register(Notif, 'site-notifications', [])
