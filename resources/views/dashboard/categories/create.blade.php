@extends('layouts.dashboard')

@section('content-header','Categories')
@section('content-wrapper')
<div class="content">
    <form action="{{route('category.store')}}" method="post">

        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="">categories</label>

            <select name="parent_id" class="form-control form-select">
                <option value=""> Primary Category</option>
                @foreach ($categories as $cat)
                
                <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" type="text" class="form-control"> </textarea>
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input name="image" type="file" class="form-control">
        </div>

        <div class="form-group">
            <label for="">status</label>
            
            <div>
                <div class="form-check">
                    <input class="form-check-input" name="status" type="radio"   value="exist" checked>
                    <label class="form-check-label" >
                      exist
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"  value="archived">
                    <label class="form-check-label" >
                      archived
                    </label>
                  </div>
            </div>

        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
  <!-- /.container-fluid -->
</div>
@endsection


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">create CAtegory</li>
@endsection

