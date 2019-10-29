@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            Edit Question
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-sm btn-outline-info">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{route('questions.update', $editQue->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="patch">

                            <div class="form-group">
                                <label for="">Question Name: <span style="color: red;font-size: 20px;">*</span></label>
                                <input type="text" class="form-control {{$errors->has('title')?'is-invalid':''}}" id="" name="title" spellcheck="false" value="{{old('title', $editQue->title)}}">
                                @if($errors->has('title'))
                                    <div class="invalid-feedback">
                                        <strong> {{$errors->first('title')}} </strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Question Description: <span style="color: red;font-size: 20px;">*</span></label>

                                <textarea class="form-control {{$errors->has('body')?'is-invalid':''}}" id="company-des" rows="5" name="body" >{{old('body', $editQue->body)}}</textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong> {{$errors->first('body')}} </strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group text-right">

                                <button type="submit" name="submit" class="btn btn-primary">update question</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
