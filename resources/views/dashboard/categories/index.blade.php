@extends('layouts.dashboard')


@section('content-header', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection


@section('content-wrapper')

    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if (Session::has('info'))
        <div class="alert alert-info">
            {{ session()->get('info') }}
        </div>
    @endif

    <div class="mb-3 ml-5">
        <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.category.create') }}">Create</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>image</th>
                <th>ID</th>
                <th>Name</th>
                 <th>Parent</th>
                <th>Created At</th>
                <th colspan="2">Actions</th> 
            </tr>
        </thead>

        <tbody>

            @forelse ($categories as $category)
                <tr>
                    <td> <img src="{{asset('storage/'.$category->image)}}" alt="" height="50" ></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="">{{ $category->parent_id}}</td>
                    <td>{{ $category->created_at }}</td> 
                    <td>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="btn btn-sm btn-outline-success "
                                        href="{{ route('dashboard.category.edit', $category->id) }}">Edit</a>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{route('dashboard.category.destroy',$category->id)}}" method="post">
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

@endsection
