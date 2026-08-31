<ul class="mn-lst">
    @foreach($chats->where('is_archived', 0)->filter(function($c) { return $c->user && $c->user->exists; }) as $c)
    <li class="{{$activeChatId==$c->id?'active-chat':''}}">
        <a href="{{url('dashboard/chat')}}?chat={{$c->id}}" class="{{$c->is_new ? 'unread-msg' : ''}}">
        @php 
            $c_img = null;
            if($c->ad && $c->ad->gallery && $c->ad->gallery->first()) {
                $c_img = $c->ad->gallery->first()->mobile_img;
            }
        @endphp
            <div class="m-img">
                @if($c_img)
                    <img src="{{ asset('uploads/post/' . $c_img) }}"/>
                @else
                    <img src="{{ asset('assets_frontend/img/ic-11.png') }}" alt="No Image" onerror="this.src='{{ asset('assets_frontend/img/ic-11.png') }}'; this.onerror=null;"/>
                @endif
            </div>
            <div class="m-name">
            <div class="m-header">
            @if($c->user && $c->user->id==auth()->user()->id)
                <strong style="color: #1caf39;font-weight: 500;">{{$c->ad && $c->ad->user ? ($c->ad->user->first_name ?? $c->ad->user->name) : 'Unknown User'}}</strong>
            @else
                <strong style="color: #1caf39;font-weight: 500;">{{$c->user ? ($c->user->first_name ?? $c->user->name) : 'Unknown User'}}</strong>
            @endif                                       
            </div>
            <span>{{$c->ad ? $c->ad->title : 'Ad Not Available'}}</span>
            <p>{{$c->last_message_text}}</p>
        </div>
        <div class="m-time">
            <em>{{$c->created_at->format('d M h:i a')}}</em>
            @if($c->unread_count > 0)
            <span class="badge bg-success chat-undread-count">{{$c->unread_count}}</span>
            @endif
        </div>
        </a>
    </li>
    @endforeach
</ul>