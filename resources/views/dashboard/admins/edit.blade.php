@extends('layouts.dashboard')

@section('content-header','Edit Category')
@section('content-wrapper')
<div class="content">
    <form action="{{route('dashboard.admins.update',$admin->id)}}" method="post" enctype="multipart/form-data">

        <input type="hidden" name="_method" value="Patch">
        @include('dashboard.admins._form',['button_label'=>'Update'])
    </form>
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Admin</li>
@endsection

