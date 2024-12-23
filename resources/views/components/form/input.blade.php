
{{-- check if he the value of name  in case update and create using normal logic  using class dirctive to give bootsrap calss --}}
<input name="{{$name}}" type="{{$type   ?? 'text' }}" @class(['form-control', 'is-invalid' => $errors->has($name)]) 
value="{{ old('name') ?? $value }}">

@if ($errors->has($name))
        <div class="invalid-feedback" >
            {{ $errors->first($name) }}
        </div>
@endif