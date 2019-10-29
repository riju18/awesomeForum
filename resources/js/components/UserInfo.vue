<template>
    <div>
        <span class="text-muted"><i class="fa fa-clock"></i> {{ansSubmissionDate}}</span>
        <div class="media mt-2">
            <a href="#" class="pr-2">
                <img :src="user.avatar">
            </a>
            <div class="media-body mt-1">
                <a href="#">{{userData.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                userData:this.user,
            }
        },
        props:['model','user'],
        computed:{
            ansSubmissionDate(){
                return moment(this.model.created_at).fromNow();
            },
        },
    }
</script>

<style scoped>

</style>