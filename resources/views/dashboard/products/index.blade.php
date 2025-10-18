@extends('layouts.dashboard')
@section('content-header', 'Products')
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
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
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>store</th>
            <th>category</th>
            <th>Created At</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>

    <tbody>

        @forelse ($products as $product)
        <tr>
            <td> <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
            <td>{{ $product->id }}</td>
            <td><a href="{{ route('dashboard.product.show',$product->id) }}">{{ $product->name }}</a></td>
            <td class="">{{ $product->status }}</td>
            <td class="">{{ $product->store()->first()->name}}</td>
            <td class="">{{ $product->category->name}}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <div class="container">
                    <div class="row">
                        @can('update', $product)                       
                        <div class="col-3 mr-3">
                            <a class="btn btn-sm btn-outline-success "
                                href="{{ route('dashboard.product.edit', $product->id) }}">Edit</a>
                        </div>
                         @endcan

                         @if (Auth::user()->can('delete', $product))
                             
                         <div class="col-3">
                             <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="post">
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
            <td colspan="9">
                No data has defined yet
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="my-2 mx-2">
    @if (Auth::user()->can('create',App\Models\Product::class))
        
    <a class="btn btn-sm btn-outline-primary mr-2" href="{{ route('dashboard.product.create') }}">Create</a>
    @endif
        
   @can('delete',$product)
       
   <a class="btn btn-sm btn-outline-primary mr-2" href="{{ route('dashboard.product.trash') }}">Trash</a>
   @endcan
    {{-- <a class="btn btn-sm btn-outline-dark" href="{{ route('dashboard.product.trash') }}">Trash</a> --}}
</div>
{{ $products->withQueryString()->links() }}



@endsection