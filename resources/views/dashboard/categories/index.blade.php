@extends('layouts.dashboard')
@section('content-header', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection


@section('content-wrapper')
    {{-- make component for session  --}}
    <x-alert type="success" />
    <x-alert type="info" />
    
    {{-- filter part --}}
<form class="d-flex justify-content-between my-4"  method="get" action="{{URL::current()}}">

<x-form.input name="name" placeholder="Name" :value="request('name')" class="mx-1"/>

<select name="status" class="form-control mx-2">
<option value="">ALL</option>
<option value="exist" @selected(request('status') == "exist")>Exists</option>
<option value="archived" @selected(request('status')=="archived")>Archived</option>
</select>
<button type="submit" class="btn btn-dark mx-1">Filter</button>

</form>

    <table class="table">
        <thead>
            <tr>
                <th>image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($categories as $category)
                <tr>
                    <td> <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="">{{ $category->parent_id }}</td>
                    <td class="">{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="btn btn-sm btn-outline-success "
                                        href="{{ route('dashboard.category.edit', $category->id) }}">Edit</a>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('dashboard.category.destroy', $category->id) }}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        {{-- <input type="hidden" name="token" value="{{ csrf_token('some-name') }}"> --}}

                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty

                <tr>
                    <td colspan="6">
                        No data has defined yet
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="my-2 mx-2">
        <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.category.create') }}">Create</a>
    </div>
   

    {{ $categories->withQueryString()->links() }}

    

@endsection
