@extends('layouts.dashboard')

@section('content-header','Admins')
@section('content-wrapper')

<div class="content">
  <form action="{{route('dashboard.admins.store')}}" method="post" enctype="multipart/form-data">

        @include('dashboard.admins._form')
    </form>
  <!-- /.container-fluid -->
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">create Admin</li>
@endsection

