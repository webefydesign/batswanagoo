<a href="{{ route('dashboard.chat') }}">
    <img src="{{asset('assets_frontend')}}/img/icon/dbl14.png" alt="" />
    @if($unreadChatCount > 0)
        <span class="badge badge-success">{{$unreadChatCount}}</span>
    @endif
</a>