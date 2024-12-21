{{-- @if ($errors->any())

    <div class="alert alert-danger">
        <h3>Erorr Occuired</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif --}}

@csrf
<div class="form-group">
    <label for="">Name</label>
    {{-- check if he the value of name  in case update and create using normal logic  using class dirctive to give bootsrap calss --}}
    <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}">
    
    @if ($errors->has('name'))
        <div class="invalid-feedback" >
            {{ $errors->first('name') }}
        </div>
    @endif
</div>

<div class="form-group">
    <label for="">Category Parent</label>

    <select name="parent_id"  @class(['form-control','form-select','is-invalid'=>$errors->has('parent_id')])  >
        <option value=""> Primary Category</option>
        @foreach ($parents as $parent)
            {{-- check the value of parent_id and using default value of old --}}
            <option value="{{ $parent->id }}"
                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }} >
                {{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>

<div class="form-group">
    <label for="">Description</label>
    {{-- check on the old value for input description --}}
    <textarea name="description" type="text" class=" form-control">{{ old('description') ?? $category->description }}  </textarea>

    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="">Image</label>
    <input name="image" type="file" @class(['form-control','is-invalid'=>$errors->has('image')]) accept="image/*">
    @error('image')
        <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>

@if ($category->image)
    <img src="{{ asset('storage/' . $category->image) }}" alt="" height="60">
@endif
<div class="form-group">
    <label for="">status</label>

    <div>
          @error('status')
            <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-check">
            {{-- check on the old value for input status to be check in case update or create --}}
            <input class="form-check-input" name="status" type="radio" value="exist" @checked(old('status', $category->status) == 'exist')>
            <label class="form-check-label">
                exist
            </label>
          
           
        </div>
        <div class="form-check">
            {{-- check on the old value for input status to be check in case update or create --}}
            <input class="form-check-input" type="radio" name="status" value="archived" @checked(old('status', $category->status) == 'archived')>
            <label class="form-check-label">
                archived
            </label>
        </div>
    </div>

</div>
<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
