<script>
    export default {
        data(){
            return{
                editing:false,
                answer_body:this.answer.body,
                answerId:this.answer.id,
                queId:this.answer.que_id,
                msg:''
            }
        },
        props:['answer'],
        methods:{
            answerUpdate(){
                axios.patch(`/questions/${this.queId}/answers/${this.answerId}`,{
                    body:this.answer_body
                }).then(response=>{
                    this.answer_body = response.data.updatedAnswer.trim();
                    this.msg = response.data.message;
                    this.editing = false;
                    Swal.fire(
                        'great',
                        this.msg,
                        'success',
                    )
                }).catch(error=>{
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: error.response.data.message,
                    })
                })
            },

            answerDelete(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/questions/${this.queId}/answers/${this.answerId}`)
                            .then(response=>{
                                this.msg = response.data.message;
                                Swal.fire(
                                    'Deleted!',
                                    this.msg,
                                    'success'
                                )
                            }).catch(error=>{
                                Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: error.response.data.message,
                            })
                        });
                    }
                })
            }
        },
        computed:{
            invalid(){
                return this.answer_body.trim().length === 0;
            }
        }
    }
</script>
