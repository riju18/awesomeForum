@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
{{--   question part--}}
                <div class="card">
                    <div class="card-header questions-header">
                        <div class="d-flex align-items-center">
                            Qustion no. <span style="margin-left: 2px;" class="badge badge-danger">{{$parQue->id}}</span><span style="margin-left: 2px;margin-right: 2px;" class="badge badge-success">{{$parQue->title}}</span> <span class="badge badge-secondary">{{$parQue->created_at->diffForHumans()}}</span>

                            <div class="ml-auto">
                                @include('includes.success')
                                @include('includes.error')
                            </div>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-backward"></i> Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body questions-body">
                        <div class="media">
                            <div class="d-flex flex-column vote-control">
{{--                                question vote--}}

                                <questionvote :question="{{$parQue}}" :login="{{Auth::check()?Auth::id():0}}"></questionvote>

{{--  if guest user then favorite que icon is black, otherwise logged in user && favorites table user_id is same then icon will be red --}}
                                @if(Auth::check())
                                    <favoritequestion :question="{{$parQue}}" :auth="{{Auth::user()}}"></favoritequestion>
                                    @endif

                            </div>
                            <div class="media-body">
                                {{$parQue->body}}
                            </div>
                        </div>
                    </div>
                </div>
                <br>

{{-- answer part--}}
                    <div class="card">
                        <div class="card-header">
                            @if($parQue->answer_count > 0)
                                <div class="d-flex align-items-center">
                                    Answers <span style="margin-left: 2px;" class="badge badge-danger">{{$parQue->answer_count}}</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <span style="margin-left: 2px;" class="badge badge-danger">No answer</span>
                                </div>
                            @endif
                        </div>
                        @if($parQue->answer_count > 0)
                            <div class="card-body" v-cloak>
                                @foreach($parQue->answer->sortBy('votes_count') as $ans)

{{--                                    vue component--}}
                                    <answer :answer="{{$ans}}" inline-template>
                                        <div class="media">
                                            <div class="d-flex flex-column vote-control">
{{--                                                answer vote--}}

                                                <answervote :answer="{{$ans}}" :login="{{Auth::check()?Auth::id():0}}"></answervote>

                            {{-- best answer accept operation --}}

                                                <acceptanswer :answer="{{$ans}}" :queuserid="{{$parQue->user_id}}" :login="{{Auth::check()?Auth::id():0}}"></acceptanswer>

                                            </div>

                                            <div class="media-body">
                                                <form v-if="editing" @submit.prevent="answerUpdate">
                                                    <div class="form-group">
                                                        <textarea rows="10" cols="8" class="form-control" v-model="answer_body"></textarea>
                                                    </div>
{{--                         if answer is null while editing then the button will be disabled--}}
                                                    <button :disabled="invalid" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> update</button>
                                                </form>
                                                <div v-else>
                                                    <div v-html="answer_body"></div>
{{--                                                    {{$ans->body}}--}}
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="ml-auto">
                                                                {{-- answer edit,delete button--}}
                                                                @if(Auth::user())
                                                                    @can('update',$ans)
                                                                        {{--                                     href="{{route('questions.answers.edit', [$parQue->id,$ans->id])}}"--}}
                                                                        <a @click.prevent="editing=true" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                                    @endcan
                                                                    @can('delete',$ans)
{{--                                                                        <form class="d-inline" action="{{route('questions.answers.destroy', [$parQue->id,$ans->id])}}" method="post">--}}
{{--                                                                            @method('delete')--}}
{{--                                                                            @csrf--}}
{{--                                                                            <button onclick="confirm('are you sure to delete?')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>--}}
{{--                                                                        </form>--}}
                                                                            <button @click="answerDelete" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                                                    @endcan
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="float-right mt-2">
{{--                                                             user info of answer--}}

                                                                <userinfo :model="{{$ans}}" :user="{{$ans->user}}"></userinfo>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </answer>
                                    <hr>
                                @endforeach
                            </div>
                        @endif
                    </div>

                <br>
{{--                answer submission part--}}
                @include('answers.create')

            </div>
        </div>
    </div>
@endsection
<script>
    import Answer from "../../js/components/Answer";
    export default {
        components: {Answer}
    }
</script>
<script>
    import Answer from "../../js/components/Answer";
    export default {
        components: {Answer}
    }
</script>