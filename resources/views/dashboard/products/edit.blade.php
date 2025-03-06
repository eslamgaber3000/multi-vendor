@extends('layouts.dashboard')

@section('content-header','Edit Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit CAtegory</li>
@endsection

@section('content-wrapper')
<div class="content">
    <form action="{{route('dashboard.product.update',$product->id)}}" method="post" enctype="multipart/form-data">

        <input type="hidden" name="_method" value="Patch">
        @include('dashboard.products._form',['button_label'=>'Update'])
    </form>
</div>
@endsection




