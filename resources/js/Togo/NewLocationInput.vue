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
                <span class="action" :class="disabledAddButton">
                    <button class="btn btn-link largefont" type="submit"><i class="bi-plus-circle text-success"></i></button>
                </span>
            </div>
        </div>
    </form>
</template>

<style scoped>

    button {
        float: right;
        padding: 0;
        margin: 0;
    }

</style>

<script>
export default {

    props: ['modelValue'],

    data : function() {
        return {
            openrout_apikey         : '',
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
            if (this.newLocation=='') {
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

        findLocation() {
            let self = this;
            axios.get('https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf62489d75357d37574ff28f52efd4662ae05e&text=' + self.newLocation )
                .then(function (response) {
                    let features = response.data.features;
                    self.foundLocations = features.map( e => e.properties.name );
                })
                .catch(function (error) {
                    console.log(error);
                })
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
            this.$emit('update:modelValue', this.newLocation);
            this.$emit('submit');
            this.resetAll();
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
