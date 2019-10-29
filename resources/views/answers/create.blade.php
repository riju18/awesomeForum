{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <form method="post" action="{{route('questions.answers.store',$parQue->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="post">


                            <div class="form-group">
                                <label for="">your answer: <span style="color: red;font-size: 20px;">*</span></label>
                                <textarea class="form-control" id="" rows="5" name="body" >{{old('body')}}</textarea>
                            </div>

                            <div class="form-group text-right">

                                <button type="submit" name="submit" class="btn btn-outline-info"><i class="fa fa-check-circle"></i> submit answer</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
{{--    </div>--}}
{{--@endsection--}}
