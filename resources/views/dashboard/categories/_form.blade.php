@if ($errors->any())

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
@endif

@csrf
<div class="form-group">
    
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
        <x-form.input    :value="$category->name" label="Category Name" name="name" role='input' />
    
    
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
  
    {{-- check on the old value for input description --}}
<x-form.textarea label="Category description"   name="description" value="{{$category->description}}"/>
</div>

<div class="form-group">  
<x-form.input name="image" type="file" label="Category Image"  accept="image/*"/>
</div>

@if ($category->image)
    <img src="{{ asset('storage/' . $category->image) }}" alt="" height="60">
@endif

<div class="form-group">
    <label for="">status</label>

    <div>

        {{-- check on the old value for input status to be check in case update or create --}}
           
         <x-form.radio
        :options="['Exist'=>'exist' ,'Archived'=>'archived']"
        type="radio"
        name="status"
        value="archived" 
        label="archived"
        check_value="{{ $category->status}}"
        />
    </div>

</div>
<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
