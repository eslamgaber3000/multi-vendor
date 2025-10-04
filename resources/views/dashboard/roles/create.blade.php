@extends('layouts.dashboard')

@section('content-header','Create Role')
@section('content-wrapper')

<x-alert type="success" />
<x-alert type="info" />

<div class="content">
  <form action="{{route('dashboard.role.store')}}" method="post" >

        @include('dashboard.roles._form')
    </form>
  <!-- /.container-fluid -->
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">create role</li>
@endsection

