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
    <x-form.input     label="Admin password" name="password" type="password" role='input' />
    
    
</div>
<div class="form-group"> 
    {{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
        value="{{ old('name') ?? $category->name }}"> --}}
    <x-form.input    :value="$admin->phone" label="Admin Phone" name="phone"  role='input' />
</div>
<label for="">Assign Roles</label>
<div class="form-group">
  @foreach ($roles as $role )
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role_{{ $role->id }}" name="roles[]"
      @foreach ($admin_roles_id as $admin_role_id_key => $admin_role_id_value)
          @if ($admin_role_id_value == $role->id)
              checked
          @endif
      @endforeach
    >
        <label class="form-check-label" for="role_{{ $role->id }}">
            {{$role->name}}
  </label>
</div>
 @endforeach
</div>


<div class="form-group">
  
    {{-- check on the old value for input description --}}

<div class="form-group">  
<x-form.input name="image" type="file" label="Admin Image"  accept="image/*"/>
</div>

@if ($admin->admin_image)
    <img src="{{ $admin->admin_image }}" alt="" height="60">
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
