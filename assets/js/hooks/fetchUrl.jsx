import { useState } from "preact/compat";
import { useCallback } from "preact/hooks";

async function jsonLdFetch(url, method = 'GET', data = null){
    const params = {
        method,
        headers: {
            'Accept': 'application/ld+json',
            'Content-type': 'application/ld+json'
        }
    }

    if(data) {
        params.body = JSON.stringify(data)
    }

    const response = await fetch(url, params)
    if(response.status === 204){
        return null;
    }
    if(response.redirected) {
        window.location.href = response.url;
    }
    const responseData = await response.json()
    if(response.ok){
        return responseData
    }else{
        throw responseData
    }
}

export function useFetchOffer(url, method = 'POST', callback = null) {
    const [loading, setLoading] = useState(false);
    const load = useCallback(async (data) => {
        setLoading(true)
        try {
            const response = await jsonLdFetch(url, method, data)
            if(callback){
                callback(response)
            }
            setLoading(false)
        }catch (e){
            setLoading(false)
        }
    }, [url, method, callback])

    return {
        loading,
        load
    }
}
