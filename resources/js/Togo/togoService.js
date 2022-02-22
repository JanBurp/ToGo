
export async function api(method,url,data) {
    let request = {
        method : method,
        url    : 'api/' + url,
    }
    if (data) {
        request.data = data;
    }

    try {
        let response = await axios( request );
        return response.data;
    }
    catch(error) {
        errorHandler(error);
    }
}


export async function openrouteApiSearch(api_key,search) {
    try {
        let response = await axios.get('https://api.openrouteservice.org/geocode/autocomplete?api_key='+api_key+'&text=' + search );
        let features = response.data.features;
        return features;
    }
    catch(error) {
        errorHandler(error);
    }
}


export function errorHandler(error) {
    let message = 'Sorry an error. ';
    if (error.response) {
        // Request made and server responded
        message += error.response.data.message;
    } else if (error.request) {
        // The request was made but no response was received
        message += 'Try again.';
    } else {
        // Something happened in setting up the request that triggered an Error
        message += error.message;
    }
    alert(message);
}

