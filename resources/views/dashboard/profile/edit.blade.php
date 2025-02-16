@extends('layouts.dashboard')

@section('content-header','Edit Profile')


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Profile Edit</li>
@endsection

@section('content-wrapper')

@include('dashboard.profile.errors',['button_label'=>'Update'])


<x-alert type='success' />




<div class="content">
    <form action="{{route('dashboard.profile.update')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="Patch">
@csrf

<div class="form-group">

{{-- <input name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) 
value="{{ old('name') ?? $category->name }}"> --}}
<x-form.input  :value="$user->profile->first_name" label="first Name" name="first_name"  />
</div>

<div class="form-group">
    <x-form.input   :value="$user->profile->last_name" label="Last Name" name="last_name"  />
      
</div>

<div class="form-group">
    <x-form.input  type="date" :value="$user->profile->birthdate" label="Birth Date" name="birthdate"  /> 
</div>


<div class="form-group">
    <label for="">Gender</label>
    <div>
        {{-- check on the old value for input status to be check in case update or create --}}
         <x-form.radio
        :options="['Male'=>'male' ,'Female'=>'female']"
        type="radio"
        name="gender"
        value="male" 
        label="male"
        check_value="{{ $user->profile->gender}}"
        />
    </div>
</div>

{{--start select   --}}
<div class="form-group">
    <label for="">Countries</label>

    <select name="country"  @class(['form-control','form-select','is-invalid'=>$errors->has('country')])  >
        <option value=""> choose your country</option>
        @foreach ($countries as $country_code=>$country_name)
            {{-- check the value of parent_id and using default value of old --}}
            <option value="{{ $country_code }}"
                {{ old('country', $user->profile->country) == $country_code ? 'selected' : '' }} >
                {{ $country_name }}</option>
        @endforeach
    </select>
    @error('country')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>

{{-- end select --}}

{{-- state --}}
<div class="form-group">
    <x-form.input  type="text" :value="$user->profile->state" label="State" name="state"  /> 
</div>

{{-- state --}}
<div class="form-group">
    <x-form.input  type="text" :value="$user->profile->city" label="Cite" name="city"  /> 
</div>

{{-- postal Code --}}
<div class="form-group">
    <x-form.input  type="text" :value="$user->profile->postal_code" label="Postal Code :" name="postal_code"  /> 
</div>
{{-- Street Address --}}
<div class="form-group">
    <x-form.input  type="text" :value="$user->profile->street_address" label="Street Address:" name="street_address"  /> 
</div>


{{--start select   --}}
<div class="form-group">
    <label for="">Local:</label>

    <select name="local"  @class(['form-control','form-select','is-invalid'=>$errors->has('local')])  >
        <option value=""> Choose Language</option>
        @foreach ($locals as $local_code=>$local_name)
            {{-- check the value of parent_id and using default value of old --}}
            <option value="{{ $local_code}}"
                {{ old('local', $user->profile->local) == $local_code ? 'selected' : '' }} >
                {{ $local_name }}</option>
        @endforeach
    </select>
    @error('local')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>

{{-- end select --}}

<div class="form-group">
    {{-- check on the value for button update or create --}}
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

    </form>
</div>
@endsection



