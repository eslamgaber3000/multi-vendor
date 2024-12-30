@props([
'type','name','value','check_value','label','options'

])

    @error($name)
    <div class="text-danger">
    {{ $message }}
    </div>
    @enderror
    
    @foreach ($options as $label=>$value )
        
    <div class="form-check">
        <input 
        {{$attributes->class([
            "form-check-input"
        ])}}
   
   type="{{$type}}"
   name="{{$name}}" 
   value="{{$value}}"
   @checked(old($name,$check_value) == $value)>
   <label class="form-check-label">
       {{$label}}
    </label>
</div>
@endforeach


