
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
    if (error.response) {
        // Request made and server responded
        console.log(error.response.data);
        alert('Sorry an error: ' + error.response.data.message);
        // console.log(error.response.status);
        // console.log(error.response.headers);
    } else if (error.request) {
        // The request was made but no response was received
        console.log(error.request);
        alert('Sorry an error. Try again.');
    } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
        alert('Sorry an error. ' + error.message);
    }
}

