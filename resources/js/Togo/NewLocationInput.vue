<template>
    <form class="form-inline" @submit.prevent="addLocation()">
        <div class="row">
            <div class="col-8 col-md-10">
                <input type="text" class="form-control" placeholder="Add new location" v-model="newLocation" @keydown.esc="resetAll()" @keydown.arrow-down="selectLocation(1)" @keydown.arrow-up="selectLocation(-1)">
                <div v-if="hasFoundLocations">
                    <ul class="list-group">
                        <li v-for="(foundLocation,index) in foundLocations" class="list-group-item" :class="foundLocationClass(index)" @click="selectFoundLocation(foundLocation,index)">{{foundLocation}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <button class="btn btn-link largefont" :class="disabledAddButton" type="submit">
                    <ActionIcon title="add this location" icon="plus-circle"></ActionIcon>
                </button>
            </div>
        </div>
    </form>
</template>

<style scoped>

    input {
        background-color: #FFF!important;
    }

    button {
        float: right;
        padding: 0;
        margin: 0;
    }

</style>

<script>

import {openrouteApiSearch} from './togoService.js';
import ActionIcon from './ActionIcon.vue';
export default {

    components: {
        ActionIcon
    },

    props: {
        'modelValue': {
            type:String,
        },
        'api_key' : {
            type:String,
        },
    },

    data : function() {
        return {
            newLocation             : this.value,
            foundLocations          : [],
            foundLocationIndex      : -1,
        };
    },

    computed : {

        hasFoundLocations() {
            return this.foundLocations.length > 0;
        },

        allLocations() {
            return this.locations.sort( (a,b) => a.created_at < b.created_at );
        },

        disabledAddButton() {
            if ( ! this.newLocation ) {
                return 'disabled';
            }
            return '';
        },

    },

    watch: {
        newLocation(location) {
            if (location.length>2) {
                this.findLocation();
            }
            else {
                this.resetFoundLocations();
            }
        },
    },

    methods : {

        async findLocation() {
            let features = await openrouteApiSearch(this.api_key,this.newLocation);
            this.foundLocations = features.map( e => e.properties.name );
        },

        selectFoundLocation(foundLocation,index) {
            this.newLocation = foundLocation;
            this.foundLocationIndex = index;
        },

        selectLocation(add) {
            this.foundLocationIndex += add;
            if (this.foundLocationIndex<0) this.foundLocationIndex = 0;
            if (this.foundLocationIndex>this.foundLocations.length) this.foundLocationIndex = this.foundLocations.length;
        },

        addLocation() {
            if (this.foundLocationIndex>=0) {
                this.newLocation = this.foundLocations[this.foundLocationIndex];
            }
            if ( this.newLocation!=='' ) {
                this.$emit('update:modelValue', this.newLocation);
                this.resetAll();
            }
        },

        foundLocationClass(index) {
            if (index == this.foundLocationIndex) {
                return 'list-group-item-primary';
            }
            return '';
        },

        resetAll() {
            this.newLocation = '';
            this.resetFoundLocations();
        },

        resetFoundLocations() {
            this.foundLocations = [];
            this.foundLocationIndex = -1;
        }

    },


}
</script>
