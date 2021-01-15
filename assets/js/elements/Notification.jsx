import React from "preact/compat";
import {useCallback, useEffect, useState} from "preact/hooks";
import {jsonLdFetch} from "../hooks/fetchUrl.jsx";

export const Notif = () => {

    const [notifications, pushNotifications] = usePrepend()
    const [open, setOpen] = useState(false)
    const [loading, setLoading] = useState(true)

    /** Chargement des notifications au montage du composant + dispatch CustomEvent pour chaque notifications **/

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
        <a href="#" className="notification" onClick={handleClick}>
            <BadgeNotification number={countUnreadNotifications(notifications)} />
            <SvgIcon name="bi bi-bell" />
        </a>
        {open && <Dropdown notif={notifications} loading={loading} handleClose={() => setOpen(false)} />}
    </>
}

/*
Représente le badge de notification
 */
const BadgeNotification = ({number}) => {
    return number > 0 ? <span className="badge-notification" dangerouslySetInnerHTML={{__html: number > 9 ? '9+' : number}}/> : ''
}

/*
Représente la dropdown
 */
const Dropdown = ({notif = [], loading, handleClose}) => {

    return <div className="notification-drop shadow slideIn">
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
    </div>
}

const SvgIcon = ({name}) => {
    return <svg width="1em" height="1em" viewBox="0 0 16 16" className={name} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
        <path fillRule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
    </svg>
}

function countUnreadNotifications(notifications){
    return notifications.filter(not => not.read === false).length
}

function onNotification(type, callback){
    const handler = (e) => callback(e.detail)
    window.addEventListener(type, handler)
    return () => { window.removeEventListener(type, handler) }
}

export function usePrepend (initialValue = []) {
    const [value, setValue] = useState(initialValue)
    return [
        value,
        useCallback( item => {
            setValue(v => [item, ...v])
        },[])
    ]
}
