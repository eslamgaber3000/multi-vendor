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
 <x-form.input    :value="$role->name" label="Role Name" name="name" role='input' />
    
</div>


<fieldset>

    <legend>Abilities</legend>
@foreach (Config::get('permissions') as $permission_key =>$permission_value )

  <div class="row mb-3">
         <div class="col-md-6">
            {{ $permission_value }}
        </div>

        <div class="col-md-2">
            <input type="radio" class="form-check-input" id="{{ $permission_key }}_allow" name="abilities[{{ $permission_key }}]" value="allow"checked >
            <label class="form-check-label" for="{{ $permission_key }}_allow">Allow</label>
        </div>
        <div class="col-md-2">
            <input type="radio" class="form-check-input" id="{{ $permission_key }}_deny" name="abilities[{{ $permission_key }}]" value="deny">
            <label class="form-check-label" for="{{ $permission_key }}_deny">Deny</label>
        </div>
        <div class="col-md-2">
            <input type="radio" class="form-check-input" id="{{ $permission_key }}_inherit" name="abilities[{{ $permission_key }}]" value="inherit">
            <label class="form-check-label" for="{{ $permission_key }}_inherit">Inherit</label>
        </div>
    </div>
@endforeach
  
</fieldset>





<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
