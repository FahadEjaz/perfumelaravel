@extends('layout.app')
@section('content')
    <h1>Contact</h1>
    {!! Form::open(['url' => 'contact/submit']) !!}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend" >
            <span class="input-group-text">Name</span>
        </div>        
        {{ Form::text('name', '', ['class' => 'form-control','placeholder' => 'name'])}}            
        </div>
        <div>
            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

