import React from "preact/compat";
import {useCallback, useEffect, useRef, useState} from "preact/hooks";
import {jsonLdFetch} from "../hooks/fetchUrl.jsx";
import {SlideIn} from "/js/components/SlideIn";

export const Notif = () => {

    const [notifications, pushNotifications] = usePrepend()
    const [open, setOpen] = useState(false)
    const [loading, setLoading] = useState(true)

    /** Chargement des notifications au montage du composant + dispatch Event pour chaque notifications **/

    useEffect(() => {
        const fetchData = async() => {
            const data = await jsonLdFetch('/api/notifications?user.id=' + user + '&order[created_at]=desc')
            const notification = data["hydra:member"]
            notification.forEach((notification) => window.dispatchEvent(new CustomEvent('notification', {type: "notification", detail: notification})))
            setLoading(false)
        }
        fetchData()
    }, [])

    /** Ecouteur d'evenement pour les notifications **/

    useEffect(() => {
        onNotification('notification', pushNotifications)
    }, [pushNotifications])


    const handleClick = (e) => {
        e.preventDefault()
        setOpen(!open)
    }

    return <>
        <button className="notification p-0" onClick={handleClick}>
            <BadgeNotification number={countUnreadNotifications(notifications)} />
            <svg width="14" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 16c.53043 0 1.03914-.2107 1.41421-.5858C8.78929 15.0391 9 14.5304 9 14H5c0 .5304.21071 1.0391.58579 1.4142C5.96086 15.7893 6.46957 16 7 16zm.995-14.901c.01396-.139049-.00138-.279476-.04503-.412229S7.83533.431887 7.74158.328256C7.64783.224624 7.5334.141792 7.40567.0851021 7.27794.0284121 7.13974-.00087738 7-.00087738c-.13974 0-.27794.02928948-.40567.08597948C6.4666.141792 6.35217.224624 6.25842.328256c-.09375.103631-.16474.225762-.20839.358515-.04365.132753-.05899.27318-.04503.412229-1.13028.2299-2.14638.84336-2.87624 1.7365C2.39891 3.72864 2.00015 4.84657 2 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" fill="#343a40"/>
            </svg>
        </button>
        <SlideIn className="notification-drop shadow" show={open === true}>
            <Dropdown notif={notifications} loading={loading} handleClose={handleClick}/>
        </SlideIn>
    </>
}

/*
Représente le badge de notification
 */
const BadgeNotification = ({number}) => {
    return number > 0 ? <span className="badge-notification" /> : ''
}

/*
Représente la dropdown
 */
const Dropdown = ({notif = [], loading, handleClose}) => {

    return <>
        <div className="notification-title border-bottom">
            <p className="m-0">Mes notifications</p>
            <span onClick={handleClose}>
                X
            </span>
        </div>
        <div className="notification-body">
            <ul>
                {loading ? "Chargement" : notif.map(n => <a href="">
                        <li>
                            <p dangerouslySetInnerHTML={{__html: n.message}} />
                            <span><time-ago time={Date.parse(n.createdAt) / 1000} /></span>
                        </li>
                    </a>
                )}
            </ul>
        </div>
        <div className="notification-footer">
            <a href="/notification" className="pointer">Voir mes notifications</a>
        </div>
    </>
}

function countUnreadNotifications(notifications){
    return notifications.filter(not => not.read === false).length
}

function onNotification(type, callback){
    const handler = (e) => callback(e.detail)
    window.addEventListener(type, handler)
    return () => { window.removeEventListener(type, handler) }
}

function usePrepend (initialValue = []) {
    const [value, setValue] = useState(initialValue)
    return [
        value,
        useCallback( item => {
            setValue(v => [item, ...v])
        },[])
    ]
}
