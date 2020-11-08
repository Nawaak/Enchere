import React from "preact/compat";

export function Alert({message = '', type = 'success'}){
    const alert = document.createElement('div')
    alert.classList.add('alert')
    alert.classList.add('alert-' + type)
    alert.style.position = 'fixed'
    alert.style.top = '10px'
    alert.style.right = '10px'
    alert.innerHTML = `${message}`
    alert.classList.add('fadeIn')
    document.body.appendChild(alert)
    setTimeout(() => {
        alert.classList.remove('fadeIn')
        alert.classList.add('fadeOut')
        alert.onanimationend = function () {
            alert.parentNode.removeChild(this)
        }
    },4000)
}