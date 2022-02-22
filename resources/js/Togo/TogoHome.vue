<template>
     <loading v-model:active="showLoader"></loading>

    <div class="p-6 mt-4">
        <ul class="list-group basic-box">
            <li class="list-group-item">
                <div v-if="!hasLocations" class="alert alert-success">Add your first location to your ToGo-list</div>
                <NewLocationInput v-model="newLocation" :api_key="openrout_apikey" @submit="addLocation()"></NewLocationInput>
            </li>
            <li v-for="location in allLocations" class="list-group-item">
                <Location :location="location" @delete="deleteLocation(location)" @visited="toggleVisitedLocation(location)"></Location>
            </li>
        </ul>

    </div>
</template>

<style scoped>

    .basic-box {
        border: solid 2px #084BC9;
    }

    .list-group-item {
        border-top: none;
        border-left: none;
        border-right: none;
    }


</style>


<script>

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import Location from './Location.vue';
import NewLocationInput from './NewLocationInput.vue';

export default {
    components: {
        Loading, Location,NewLocationInput
    },

    data : function() {
        return {
            openrout_apikey : '',
            apiRoot : 'api/',

            showLoader : false,

            locations: [],
            newLocation : '',

        };
    },

    computed : {

        hasLocations() {
            return this.locations.length > 0;
        },

        allLocations() {
            return this.locations.sort( (a,b) => a.created_at < b.created_at );
        },

    },

    mounted() {
        this.getLocations();
    },

    methods : {

        setLoader(loading) {
            this.showLoader = loading;
        },


        api(method,url,data) {
            let self = this;
            this.setLoader(true);

            let request = {
                method : method,
                url    : this.apiRoot + url,
            }
            if (data) {
                request.data = data;
            }

            return axios( request )
                .then(function (response) {
                    self.setLoader(false);
                    return Promise.resolve(response.data);
                })
                .catch(function (error) {
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
                    self.setLoader(false);
                })
        },


        getLocations() {
            let self = this;
            this.api( 'get', 'locations' ).then(function(data) {
                if (data) {
                    self.locations       = data.locations;
                    self.openrout_apikey = data.openrout_apikey;
                }
            })
        },

        toggleVisitedLocation(location) {
            let self = this;
            let data = {
                visited : ! location.visited,
            }

            this.api( 'patch', 'locations/'+location.id, data ).then(function( data ) {
                if ( data ) {
                    let idx = self.locations.findIndex( e => e.id==location.id);
                    if (idx>=0) {
                        let current = self.locations[idx];
                        let updated = {...current,...data}
                        self.locations[idx] = updated;
                    }
                }
            });

        },

        addLocation() {
            let self = this;
            if (self.newLocation!='') {
                self.api( 'post', 'locations', { location: self.newLocation } ).then(function( data ) {
                    if ( data ) {
                        self.locations.unshift(data);
                    }
                });
            }
            self.newLocation = '';
        },

        deleteLocation(location) {
            let self = this;
            this.api( 'delete', 'locations/' + location.id ).then(function(response) {
                if (response.deleted) {
                    let idx = self.locations.findIndex( e => e.id==location.id);
                    if (idx>=0) {
                        self.locations.splice(idx,1);
                    }
                }
                else {
                    alert('Could not delete.');
                }
            });
        },

    },

}
</script>
