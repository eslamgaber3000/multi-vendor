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
        <x-form.input    :value="$product->name" label="Product Name" name="name" role='input' />
</div>
<div class="form-group">
    <label for=""> Category</label>

    <select name="category_id"  @class(['form-control','form-select','is-invalid'=>$errors->has('category_id')])  >
     
        @foreach ($categories as $category)
            {{-- check the value of category_id and using default value of old --}}
            <option value="{{ $category->id }}"{{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }} >
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>

<div class="form-group">
  
    {{-- check on the old value for input description --}}
<x-form.textarea label="Product description"   name="description" value="{{$product->description}}"/>
</div>

<div class="form-group">  
<x-form.input name="image" type="file" label="Product Image"  accept="image/*"/>
</div>

@if ($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="" height="60">
@endif

<div class="form-group">
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$product->price" label="Product Price" name="price" role='input' />
</div>
<div class="form-group">
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$product->compare_price" label="Compare Price" name="compare_price" role='input' />
</div>
<div class="form-group">
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$tags" label="Tags" name="tags" role='input' />
</div>

<div class="form-group">
    <label for="">status</label>

    <div>

        {{-- check on the old value for input status to be check in case update or create --}}
           
         <x-form.radio
        :options="['Active'=>'active' ,'Archived'=>'archived','Draft'=>'draft']"
        type="radio"
        name="status"
        value="archived" 
        label="archived"
        check_value="{{ $product->status}}"
        />
    </div>

</div>
<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
