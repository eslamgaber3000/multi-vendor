@extends('layouts.dashboard')
@section('content-header', 'Admins')
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Admins</li>
@endsection


@section('content-wrapper')
{{-- make component for session --}}
<x-alert type="success" />
<x-alert type="info" />
{{-- filter part --}}
<form class="d-flex justify-content-between my-4" method="get" action="{{URL::current()}}">

    <x-form.input name="name" placeholder="Name" :value="request('name')" class="mx-1" />

    <select name="status" class="form-control mx-2">
        <option value="">ALL</option>
        <option value="exist" @selected(request('status')=="exist" )>Exists</option>
        <option value="archived" @selected(request('status')=="archived" )>Archived</option>
    </select>
    <button type="submit" class="btn btn-dark mx-1">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>image</th>
            <th>Name</th>
            <th>email</th>
            <th>username</th>
            <th>phone</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Roles</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>

    <tbody>

        @forelse ($admins as $admin)
        <tr>
            <td> <img src="{{ $admin->admin_image }}" alt="" height="50"></td>
            <td><a href="{{route('dashboard.admins.show',$admin->id)}}">   {{ $admin->name }} </a></td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->username }}</td>
            <td>{{ $admin->phone }}</td>
            <td class="">{{ $admin->status }}</td>
            <td>{{ $admin->created_at }}</td>
            
            <td> 
                @if ($admin->roles()->first())
                     <a href="{{ route('dashboard.role.show',$admin->roles()->first()->id )}}">
                    {{ $admin->roles()->first()->name }}</a></td>
                @else
                No Role Assigned
                @endif
               
            <td>
                <div class="container">
                    <div class="row">
                    @if (Auth::user()->can('admins.update'))
                        <div class="col-md-4">
                            <a class="btn btn-sm btn-outline-success "
                                href="{{ route('dashboard.admins.edit', $admin->id) }}">Edit</a>
                        </div>
                        @endif

                        @if (Auth::user()->can('admins.delete'))

                        
                        <div class="col-md-4">
                            <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{-- <input type="hidden" name="token" value="{{ csrf_token('some-name') }}"> --}}

                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
@endif
                    </div>
                </div>
            </td>
        </tr>
        @empty

        <tr>
            <td colspan="10" class="text-center">
                No data has defined yet
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="my-2 mx-2">
    @can('admins.create')

    <a class="btn btn-sm btn-outline-primary mr-2" href="{{ route('dashboard.admins.create') }}">Create</a>
    @endcan
    {{-- <a class="btn btn-sm btn-outline-dark" href="{{ route('dashboard.category.trash') }}">Trash</a> --}}
</div>
{{ $admins->withQueryString()->links() }}



@endsection