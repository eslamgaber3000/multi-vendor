<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($newCount > 0)
            <span class="badge badge-warning navbar-badge">{{ $newCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu  dropdown-menu-right" style="">
        <span class="dropdown-header">{{ $newCount }}</span>

        <div class="dropdown-divider"></div>

        
        @foreach ($notifications as $notification)
            <a href="?notification_id={{ $notification->id }}" class="dropdown-item @if ($notification->unread())   
              text-primary text-bold
            @endif 
            ">
                <i class="{{ $notification['data']['icon'] }} mr-2"></i> {{ $notification['data']['body'] }}
                <span class="float-right text-muted text-sm">{{$notification->created_at->diffForHumans()}}</span>
            </a>
            <div class="dropdown-divider"></div>

        @endforeach

        
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
