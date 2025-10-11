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
    <x-form.input    :value="$admin->name" label="Admin Name" name="name" role='input' />
    
    
</div>

<div class="form-group">
    
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$admin->email" label="Admin email" name="email" role='input' />
    
    
</div>

<div class="form-group">
    
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$admin->password" label="Admin password" name="password" type="password" role='input' />
    
    
</div>
<div class="form-group">
    
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$admin->phone" label="Admin Phone" name="phone"  role='input' />
    
    
</div>
<div class="form-group">
    
    
<label for="adminRole">Role</label>
   <select name="role" id="adminRole" class="form-control">
       <option value="">--select role--</option>
          @foreach ($roles as $role)
       <option value="{{$role->id}}" >
        {{-- @if($admin->roles->first() && $admin->roles->first()->id == $role->id) selected @endif --}}
        {{$role->name}}</option>
       @endforeach
    </select>
    
    
</div>



<div class="form-group">
  
    {{-- check on the old value for input description --}}

<div class="form-group">  
<x-form.input name="image" type="file" label="Admin Image"  accept="image/*"/>
</div>

@if ($admin->image)
    <img src="{{ asset('storage/' . $admin->image) }}" alt="" height="60">
@endif

<div class="form-group">
    <label for="">Status</label>

    <div>

        {{-- check on the old value for input status to be check in case update or create --}}
           
         <x-form.radio
        :options="['Active'=>'active' ,'Not Active'=>'not_active']"
        type="radio"
        name="status"
        value="archived" 
        label="archived"
        check_value="{{ $admin->status}}"
        />
    </div>


    </div>

   

</div>
 <div class="form-group">
        <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="super-admin" value="1">
        <label class="custom-control-label" for="customSwitch1">Super Admin</label>
    </div>
<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
