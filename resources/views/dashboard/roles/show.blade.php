@extends('layouts.dashboard')
{{-- self closed sections --}}
@section('content-header',$role->name )

{{-- section for breadcrump --}}
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Roles</li>
<li class="breadcrumb-item active">{{$role->name}}</li>
@endsection

@section('content-wrapper')
{{-- make component for session --}}
<x-alert type="success" />
<x-alert type="info" />

<!--need to show all products inside each role   -->
<table class="table">
    <thead>
        <tr>
            <th>Ability</th>
            <th>Type</th>
            <th>Created At</th>
        </tr>
    </thead>


    @php
       $abilities=$role->abilities()->latest()->paginate() ;
    @endphp
    <tbody>

        @forelse ($abilities as $ability)
        <tr>
            <td>{{ $ability->ability }}</td>
            <td>{{ $ability->type }}</td>
            <td>{{ $ability->created_at }}</td>
            {{-- <td>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 mr-2">
                            <a class="btn btn-sm btn-outline-success "
                                href="{{ route('dashboard..edit', $product->id) }}">Edit</a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{-- <input type="hidden" name="token" value="{{ csrf_token('some-name') }}"> --}}

                                {{--<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </td> --}}
        </tr>
        @empty

        <tr>
            <td colspan="4" class="text-center">
                No data has defined yet
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{$abilities->links()}}

@endsection
