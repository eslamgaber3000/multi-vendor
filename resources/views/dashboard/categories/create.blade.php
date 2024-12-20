@extends('layouts.dashboard')

@section('content-header','Categories')
@section('content-wrapper')

<div class="content">
  <form action="{{route('dashboard.category.store')}}" method="post" enctype="multipart/form-data">

        @include('dashboard.categories._form')
    </form>
  <!-- /.container-fluid -->
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">create CAtegory</li>
@endsection

