import { useState } from "preact/compat";
import { useCallback } from "preact/hooks";
import { Alert } from "../elements/alert";

export async function jsonLdFetch(url, method = 'GET', data = null, callback= null){
    const params = {
        method,
        headers: {
            'Accept': 'application/ld+json',
            'Content-type': 'application/ld+json'
        }
    }

    if(method !== 'GET' && user === 0){
        return new Promise((resolve) => {
            Alert({type: 'danger', message: 'Vous devez être authentifié pour continuer, vous allez être redirigez vers la page de connexion'})
            setTimeout(() => {
                resolve(document.location.href = '/login')
            }, 3000)
        })
    }

    if(data) {
        params.body = JSON.stringify(data)
    }
    const response = await fetch(url, params)
    const responseData = await response.json()

    if(response.ok){
        if(callback){
            callback()
        }
        return responseData
    }else{
        Alert({type: responseData.type || 'danger', message: responseData.message || responseData["hydra:description"] || 'Une erreur est survenue'})
    }
}

export function useFetchOffer(url, method = 'POST', callback = null) {
    const [loading, setLoading] = useState(false);
    const load = useCallback(async (data) => {
        try {
            setLoading(true)
            await jsonLdFetch(url, method, data, callback)
        }catch (e) {
            console.error(e)
        }
        setLoading(false)
    }, [url, method, callback])

    return {
        loading,
        load
    }
}

