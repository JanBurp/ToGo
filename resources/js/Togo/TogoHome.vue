<template>
     <loading v-if="loaderState.show" :active="true"></loading>

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

import {api,errorHandler,loaderState} from './togoService.js';

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
            loaderState,

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

        async getLocations() {
            let response = await api( 'get', 'locations' );
            if (response) {
                this.locations       = response.locations;
                this.openrout_apikey = response.openrout_apikey;
            }
        },

        async toggleVisitedLocation(location) {
            let data = {
                visited : ! location.visited,
            }
            let response = await api( 'patch', 'locations/'+location.id, data );
            if ( response ) {
                let idx = this.locations.findIndex( e => e.id==location.id);
                if (idx>=0) {
                    let current = this.locations[idx];
                    let updated = {...current,...response}
                    this.locations[idx] = updated;
                }
            }
        },

        async addLocation() {
            if (this.newLocation!='') {
                let response = await api( 'post', 'locations', { location: this.newLocation } );
                if ( response ) {
                    this.locations.unshift(response);
                }
            }
            this.newLocation = '';
        },

        async deleteLocation(location) {
            let response = await api( 'delete', 'locations/' + location.id );
            if (response.deleted) {
                let idx = this.locations.findIndex( e => e.id==location.id);
                if (idx>=0) {
                    this.locations.splice(idx,1);
                }
            }
            else {
                alert('Could not delete.');
            }
        },

    },

}
</script>
