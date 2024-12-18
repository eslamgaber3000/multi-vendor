@csrf
        <div class="form-group">
            <label for="">Name</label>
            <input name="name" type="text" class="form-control" value="{{ $category->name}}">
        </div>

        <div class="form-group">
            <label for="">Category Parent</label>

            <select name="parent_id" class="form-control form-select">
                <option value=""> Primary Category</option>
                @foreach ($parents as $parent)
                
                <option value="{{$parent->id}}"   {{$category->parent_id==$parent->id ?'selected':''  }} >{{$parent->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" type="text" class="form-control">{{$category->description}} </textarea>
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input name="image" type="file" class="form-control" accept="image/*">
        </div>
        
            @if ($category->image)
            <img src="{{asset('storage/'.$category->image)}}" alt="" height="60" >
            @endif
        <div class="form-group">
            <label for="">status</label>
            
            <div>
                <div class="form-check">
                    <input class="form-check-input" name="status" type="radio"   value="exist" @checked($category->status=="exist")>
                    <label class="form-check-label" >
                      exist
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"  value="archived" @checked($category->status=="archived")>
                    <label class="form-check-label" >
                      archived
                    </label>
                  </div>
            </div>

        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label?? 'Save'}}</button>
        </div>