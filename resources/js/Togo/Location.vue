<template>
    <div class="row">
        <div class="col-8 col-md-10">
            <span class="location" :class="locationClass"><a :href="'location/'+locationSlug">{{location.location}}</a></span>
        </div>
        <div class="col-4 col-md-2">
            <ActionIcon @click="deleteLocation(location)" title="delete this location" icon="x-circle" color="danger"></ActionIcon>
            <ActionIcon v-if="! location.visited" @click="toggleVisitedLocation(location)" title="tag this location as visited" icon="check-circle"></ActionIcon>
            <ActionIcon v-else @click="toggleVisitedLocation(location)" title="tag this location as unvisited" icon="circle"></ActionIcon>
        </div>
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

</style>

<script>
import ActionIcon from './ActionIcon.vue';
export default {

    components: {
        ActionIcon
    },

    props: {
        'location' : {
            type:Object,
        }
    },



    computed : {

        locationClass() {
            let c = '';
            if (this.location.visited) c += 'visited ';
            return c;
        },

        locationSlug() {
            let slug = this.location.slug;
            if ( this.location.slug==null ) slug = this.location.id;
            return slug;
        },

    },


    methods : {

        toggleVisitedLocation(location) {
            this.$emit('visited',location);
        },

        deleteLocation(location) {
            if ( confirm("Are you sure?") ) {
                this.$emit('delete',location);
            }
        },

    },


}
</script>
