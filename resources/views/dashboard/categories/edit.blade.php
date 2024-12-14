@extends('layouts.dashboard')

@section('content-header','Edit Category')
@section('content-wrapper')
<div class="content">
    <form action="{{route('dashboard.category.update',$category->id)}}" method="post" enctype="multipart/form-data">

        <input type="hidden" name="_method" value="Patch">
        @include('dashboard.categories._form')
    </form>
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit CAtegory</li>
@endsection

