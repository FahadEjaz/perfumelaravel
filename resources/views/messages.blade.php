@extends('layout.app')

@section('content')
    <h1>Messages</h1>
    @if(count($messages) > 0)
    @foreach($messages as $message)
        <ul class="list-group">
            <li class="list-group-items">Name: {{$message->name}}</li> 
        </ul>
    @endforeach
    @endif
@endsection

@section('sidebar')
    @parent            
    <p>This is appended to side bar<p>
@endsection
