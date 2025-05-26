 @props([
'countries'=>'' , 'name' ,'key' , 'value'

 ])

 {{-- I deal with array so laravel validateion can't understand this array syntax why in validation
  and it is only understand dotted name --}}
 
@php
    $doted_name=str_replace(['[' , ']']   , ['.' , ''] ,$name)
@endphp

 <select class="form-control" name="{{ $name }}">
     <option value="">Choose Your Country</option>

     @foreach ($countries as $key => $value)
     {{-- I need to let User select his last value before redirect of validation error --}}
         <option value="{{ $key }}"   {{ old($doted_name)  == $key  ? 'selected' : '' }} >{{ $value }}</option>
     @endforeach

@if ($errors->has($doted_name))
        <div class="invalid-feedback" >
            {{ $errors->first($doted_name) }}
        </div>
@endif

 </select>
