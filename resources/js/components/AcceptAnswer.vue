<template>
<!--    only question owner can accept the answer -->

    <div v-if="answerAccepted">
        <a title="mark this answer as best" :class="classes" @click.prevent="accept">
            <i class="fa fa-check fa-2x"></i>
            <span v-if="bestAnswer" class="favorite-count">answer accepted</span>
        </a>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                bestAnswer:this.answer.bestAnswer,
                loggedInUser: this.login,
                questionUserId:this.queuserid,
                answerId:this.answer.id
            }
        },
        props:['answer','queuserid','login'],
        computed:{
            classes(){
                return this.bestAnswer?'vote-accepted':'';
            },
            answerAccepted(){
                    return this.questionUserId === this.loggedInUser;
            }
        },
        methods:{
            accept(){
                axios.post(`/answers/${this.answerId}/accept`)
                    .then(response=>{
                        Swal.fire(
                            'great',
                            response.data.message,
                            'success',
                        );
                        this.bestAnswer = true;
                    })
                    .catch(error=>{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: error.response.data.message,
                        })
                    })
            }
        }
    }
</script>

<style scoped>

</style>