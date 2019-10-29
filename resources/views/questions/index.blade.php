@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header questions-header">
                        <div class="d-flex align-items-center">
                            All Questions<span style="margin-left: 2px;" class="badge badge-danger">{{count($allQues)}}</span>
                            <div class="ml-auto">
                                @include('includes.success')
                                @include('includes.error')
                            </div>

                            <div class="ml-auto">
                                <a href="{{route('questions.create')}}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-question"></i> Ask your Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body questions-body">
                        @forelse($allQues as $que)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="votes" style="color:#3498db;">
                                        <strong><i class="fa fa-thumbs-up"></i> {{$que->votes_count}}</strong> {{Str::plural('vote', $que->votes_count)}}
                                    </div>
                                    <div class="status {{($que->answer_count?($que->bestAnswer?'answered-accepted':'answered'):'unanswered')}}">
                                        <strong><i class="fa fa-reply"></i> {{$que->answer_count}}</strong> {{Str::plural('answer', $que->answer_count)}}
                                    </div>
                                    <br>
                                    <div class="views" style="color: #1abc9c;">
                                        <i class="fa fa-eye"></i> {{$que->views}}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"> <a href="{{route('questions.show', $que->id)}}" target="_blank">{{$que->title}}</a> <span class="badge badge-secondary"><i style="color: white;" class="fa fa-clock"></i> {{$que->created_at->diffForHumans()}}</span> </h3>
                                        <div class="ml-auto">
{{--                                            if user is logged in the edit/delete will be shown--}}
                                            @if(Auth::user())
                                                @can('update',$que)
                                                    <a href="{{route('questions.edit', $que->id)}}" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                    @endcan
                                                @can('delete',$que)
                                                        <form class="d-inline" action="{{route('questions.destroy',$que->id)}}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button onclick="confirm('are you sure to delete?')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                                        </form>
                                                    @endcan
                                                @endif
                                        </div>
                                    </div>
                                    <p class="lead">
                                        asked by
                                        <a href="#">{{$que->user['name']}}</a>
                                        <small class="text-muted">{{$que->created_at->diffForHumans()}}</small>
                                    </p>
                                    {{Str::limit($que->body, 250)}}
                                </div>
                            </div>
                            <hr>
                        @empty
{{--                            if there is no any question in db the following will be showed up--}}
                            <div class="alert alert-warning">
                                <strong>no question is available</strong>
                            </div>
                            @endforelse
                            <div class="mx-auto">
                                {{$allQues->links()}}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
