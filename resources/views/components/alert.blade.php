{{-- any alert you want to show just use this alert component and dri you code --}}
@if (Session::has($type))
<div class="alert alert-{{$type}}">
    {{ session()->get($type) }}
</div>
@endif


