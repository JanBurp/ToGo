<template>
    <span class="action largefont" :title="title"><i :class="iconClass"></i></span>
</template>

<style scoped>

    .action {
        font-size: 1.5rem;
        float: right;
        margin-left: 0.5rem;
        cursor: pointer;
    }

    .action.disabled {
        opacity: 0.5;
    }


</style>

<script>
export default {

    props: {
        'title' : {
            type:String,
            default:'',
        },
        'icon' : {
            type:String,
            default:'',
        },
        'color' : {
            type:String,
            default:'success',
        },
    },

    computed : {

        iconClass() {
            return 'bi-' + this.icon + ' text-' + this.color;
        },

    },

}
</script>
