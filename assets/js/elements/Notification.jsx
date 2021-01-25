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
            <svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)" fill="#000">
                    <path d="M7 14a1.75 1.75 0 001.75-1.75h-3.5A1.75 1.75 0 007 14z"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 1.678l-.697.141A3.502 3.502 0 003.5 5.249c0 .55-.117 1.923-.402 3.275-.14.671-.329 1.37-.58 1.976h8.964c-.251-.606-.44-1.304-.58-1.976C10.617 7.172 10.5 5.8 10.5 5.25a3.502 3.502 0 00-2.803-3.43L7 1.677v.001zm5.443 8.822c.195.391.42.7.682.875H.875c.262-.174.487-.484.683-.875.787-1.575 1.067-4.48 1.067-5.25A4.377 4.377 0 016.129.962a.875.875 0 111.742 0 4.377 4.377 0 013.504 4.288c0 .77.28 3.675 1.068 5.25z"/>
                </g>
                <defs>
                    <clipPath id="clip0">
                        <path fill="#fff" d="M0 0h14v14H0z"/>
                    </clipPath>
                </defs>
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
