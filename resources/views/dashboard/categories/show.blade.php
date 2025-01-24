@extends('layouts.dashboard')
{{-- self closed sections --}}
@section('content-header',$category->name )

{{-- section for breadcrump --}}
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('content-wrapper')
{{-- make component for session --}}
<x-alert type="success" />
<x-alert type="info" />

<!--need to show all products inside each category   -->
<table class="table">
    <thead>
        <tr>
            <th>image</th>
            <th>Product Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th>action</th>
        </tr>
    </thead>


    @php
       $products=$category->products()->with('store')->latest()->paginate() ;
    @endphp
    <tbody>

        @forelse ($products as $product)
        <tr>
            <td> <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
            <td>{{ $product->name }}</td>
            <td class="">{{ $product->status }}</td>
            <td class="">{{ $product->store->name}}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 mr-2">
                            <a class="btn btn-sm btn-outline-success "
                                href="{{ route('dashboard.product.edit', $product->id) }}">Edit</a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="post">
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

{{$products->links()}}

@endsection
