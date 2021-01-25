// ## Source github.com/Grafikart/Grafikart.fr ##

import React from "preact/compat";
import {useEffect, useState} from "preact/hooks";

export function SlideIn ({ show, children, style = {}, ...props }) {
    const [shouldRender, setRender] = useState(show)

    useEffect(() => {
        if (show) setRender(true)
    }, [show])

    const onAnimationEnd = e => {
        if (!show && e.animationName === 'fadeOut') setRender(false)
    }

    return (
        shouldRender && (
            <div
                style={{ animation: `${show ? 'slideIn .3s both' : 'fadeOut .3s'}`, ...style }}
                onAnimationEnd={onAnimationEnd}
                {...props}
            >
                {children}
            </div>
        )
    )
}