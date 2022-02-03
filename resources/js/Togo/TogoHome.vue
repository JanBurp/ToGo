<template>
     <loading v-model:active="showLoader"></loading>

    <div class="p-6 mt-4">
        <ul class="list-group">
            <li class="list-group-item">
                <div v-if="!hasLocations" class="alert alert-success">Add your first location to your ToGo-list</div>
                <NewLocationInput v-model="newLocation" :api_key="openrout_apikey" @submit="addLocation()"></NewLocationInput>
            </li>
            <li v-for="location in allLocations" class="list-group-item">
                <div class="row">
                    <div class="col-8 col-md-10">
                        <span class="location" :class="locationClass(location)"><a :href="'location/'+location.id">{{location.location}}</a></span>
                    </div>
                    <div class="col-4 col-md-2">
                        <span class="action largefont" @click="deleteLocation(location)" title="delete this location"><i class="bi-x-circle text-danger"></i></span>
                        <span v-if="! location.visited" class="action largefont" @click="toggleVisitedLocation(location)" title="tag this location as visited"><i class="bi-check-circle text-success"></i></span>
                        <span v-else class="action largefont" @click="toggleVisitedLocation(location)" title="tag this location as unvisited"><i class="bi-circle text-success"></i></span>
                    </div>
                </div>
            </li>
        </ul>

    </div>
</template>

<style scoped>

    .location a {
        text-decoration: none;
        font-size: 1.5rem;
    }

    .location.visited {
        text-decoration:line-through;
    }

    .action {
        float: right;
        margin-left: 0.5rem;
        cursor: pointer;
    }

    .action.disabled {
        opacity: 0.5;
    }

</style>

<script>

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import NewLocationInput from './NewLocationInput.vue';

export default {
    components: {
        Loading, NewLocationInput
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

        disabledAddButton() {
            if (this.newLocation=='') {
                return 'disabled';
            }
            return '';
        },

    },

    mounted() {
        this.getLocations();
    },

    methods : {


        locationClass(location) {
            let c = '';
            if (location.visited) c += 'visited ';
            return c;
        },


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
                    console.log(error);
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

            if ( confirm("Are you sure?") ) {
                this.api( 'delete', 'locations/' + location.id ).then(function(deleted) {
                    if (deleted) {
                        let idx = self.locations.findIndex( e => e.id==location.id);
                        if (idx>=0) {
                            self.locations.splice(idx,1);
                        }
                    }
                });
            }


        },

    },

}
</script>
