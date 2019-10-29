<template>
    <div v-if="isSignedIn">
        <a title="click to mark as favorite question" :class="classes" @click="favCountOperation">
            <i class="fa fa-star fa-2x"></i>
            <span class="favorite-count">{{favoriteCount}}</span>
        </a>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                que_id:this.question.id,
                isFavorited:this.question.favorites.is_favorited,
                isSignedIn:this.auth.name,
                favoriteCount:this.question.favorites_count
            }
        },
        props:['question','auth'],
        computed:{
            classes(){
                return[
                    'favorite',
                    'mt-2',
                    !this.isSignedIn?'off':(this.isFavorited?'favorited':'')
                ]
            }
        },
        methods:{
            favCountOperation(){
                this.isFavorited ? this.decrease():this.increase();
            },
            decrease(){
                axios.delete(`/questions/${this.que_id}/favorite`)
                    .then(response=>{
                        this.favoriteCount--;
                        this.isFavorited = false;
                    })
                    .catch(error=>{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: error.response.data.message,
                        })
                    });
            },
            increase(){
                axios.post(`/questions/${this.que_id}/favorite`)
                    .then(response=>{
                        this.favoriteCount++;
                        this.isFavorited = true;
                    })
                    .catch(error=>{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: error.response.data.message,
                        })
                    });
            }
        }
    }
</script>

<style scoped>

</style>