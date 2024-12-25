@props([
'name','type'=>'text','value'=>'','label'=>false

])

@if ($label)
<label for="">{{$label}}</label>
@endif

<textarea  name="{{$name}}"  type="{{$type }}"   
{{$attributes->class([
'form-control',
'is-invalid'=>$errors->has('description')

])}}>{{ old($name) ?? $value}} 

</textarea>
@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
