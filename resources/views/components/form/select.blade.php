 @props([
'countries'=>'' , 'name' ,'key' , 'value'

 ])
 
 <select class="form-control" name="{{ $name }}">
     <option value="">Choose Your Country</option>
     @foreach ($countries as $key => $value)
         <option value="{{ $key }}">{{ $value }}</option>
     @endforeach

@if ($errors->has($name))
        <div class="invalid-feedback" >
            {{ $errors->first($name) }}
        </div>
@endif

 </select>
