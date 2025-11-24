@extends('layouts.dashboard')

@section('content-header','Import Products')
@section('content-wrapper')

<div class="content">
  <form action="{{route('dashboard.product.import')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">  
<x-form.input name="count" type="number" label="Product count" />
</div>
    <button type="submit" class="btn btn-primary">Start Import...</button>
    </form>
  <!-- /.container-fluid -->
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Import Products</li>
@endsection

