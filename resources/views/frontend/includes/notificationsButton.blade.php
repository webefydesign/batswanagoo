@php
    $unreadNotificationCount = auth()->user()->unreadNotificationCount();
@endphp
<a href="{{ route('dashboard.notifications') }}">
    <img src="{{asset('assets_frontend')}}/img/icon/dbl19.png" alt="" />
    @if($unreadNotificationCount > 0)
        <span class="badge badge-success">{{$unreadNotificationCount}}</span>
    @endif
</a>