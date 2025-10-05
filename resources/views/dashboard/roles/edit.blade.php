@extends('layouts.dashboard')

@section('content-header','Edit Role')
@section('content-wrapper')
<div class="content">
    <form action="{{route('dashboard.role.update',$role->id)}}" method="post" >
        @csrf
            
        <input type="hidden" name="_method" value="Patch">
        @include('dashboard.roles._form',['button_label'=>'Update'])
    </form>
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Role</li>
@endsection

