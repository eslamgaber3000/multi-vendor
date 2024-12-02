@extends('layouts.dashboard')


@section('content-header','Categories')
    
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection


@section('content-wrapper')
    <div class="mb-3 ml-5">

    <a  class="btn btn-sm btn-outline-primary" href="{{route('category.create')}}">Create</a>
    </div>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>

    <tbody>
            
        @forelse ($categories as $category )
            
        <tr>
            <td></td>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->parent_id}}</td>
            <td>{{$category->created_at}}</td>
            <td><a class="btn btn-sm btn-outline-success" href="{{route('category.edit',$category->id)}}">Edit</a></td>
            <td>
                <form action="route('category.destroy',$category->id)" method="post">
                    <input type="hidden" name="_method" value="delete">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
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
