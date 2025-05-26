@props(['name','type'=>'text','value'=>'','label'=>false])

@php
    
$doted_name=str_replace(['[' , ']'],['.' , ''],$name) ;

@endphp

@if ($label)
<label for="">{{$label}}</label>
@endif

{{-- check if he the value of name  in case update and create using normal logic  using class dirctive to give bootsrap calss --}}
<input name="{{$name}}" type="{{$type}}"
{{$attributes->class([
'form-control',
'is-invalid' => $errors->has($doted_name)

])}}
 {{-- @class(['form-control', 'is-invalid' => $errors->has($name)])  --}}
value="{{ old($doted_name) ?? $value }}"> 

@if ($errors->has($doted_name))
        <div class="invalid-feedback" >
            {{ $errors->first($doted_name) }}
        </div>
@endif
