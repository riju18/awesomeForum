<template>
    <div>
        <a title="this answer is useful" class="vote-up classes" @click.prevent="voteIncrease">
            <i class="fa fa-caret-up fa-3x"></i>
        </a>
        <span class="vote-count">{{votes}}</span>

        <a title="this answer is not useful" class="vote-down off" @click.prevent="voteDecrease">
            <i class="fa fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                loggedUserId:this.login,
                votes:this.answer.votes_count,
                answerId:this.answer.id,
            }
        },
        props:['answer','login'],
        computed:{
            classes(){
                return this.loggedUserId === 0?'off':'';
            }
        },
        methods:{
            voteIncrease(){
                if (this.loggedUserId !== this.answer.user_id){

                    axios.post(`/answers/${this.answerId}/vote`,{
                        'vote':1
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
            voteDecrease(){
                if (this.loggedUserId !== this.answer.user_id){

                    axios.post(`/answers/${this.answerId}/vote`,{
                        'vote':this.vote--
                    })
                        .then(response=>{
                            this.votes--;
                            Swal.fire(
                                'oh!',
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