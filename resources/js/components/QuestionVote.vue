<template>
    <div>
        <a style="color: #34495e;" title="this question is useful" class="vote-up classes" @click.prevent="voteUp">
            <i style="color: #34495e;" class="fa fa-caret-up fa-3x"></i>
        </a>

        <span class="vote-count">{{votes}}</span>


        <a title="this question is not useful" class="vote-down classes" @click.prevent="voteDown">
            <i class="fa fa-caret-down fa-3x"></i>
        </a>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                loggedUserId:this.login,
                votes:this.question.votes_count,
                questionId: this.question.id
            }
        },
        props:['question', 'login'],
        computed:{
            classes(){
                return this.loggedUserId===0?'off':'';
            }
        },
        methods:{
            voteUp(){
                if (this.question.user_id !== this.loggedUserId){

                    axios.post(`/questions/${this.questionId}/vote`, {
                        'vote': 1
                    })
                        .then(response=>{
                            Swal.fire(
                                'great',
                                response.data.message,
                                'success',
                            );
                            this.votes = response.data.votes;
                        })
                        .catch(error=>{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: this.loggedUserId===0?'please sign in':error.response.data.message,
                            })
                        })
                }
            },
            voteDown(){
                if (this.question.user_id !== this.loggedUserId){

                    axios.post(`/questions/${this.questionId}/vote`, {
                        'vote': this.vote--
                    })
                        .then(response=>{
                            Swal.fire(
                                'great',
                                'your vote is canceled',
                                'success',
                            );
                            this.votes = response.data.votes;
                        })
                        .catch(error=>{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: this.loggedUserId===0?'please sign in':error.response.data.message,
                            })
                        })

                }
            }
        }
    }
</script>

<style scoped>

</style>