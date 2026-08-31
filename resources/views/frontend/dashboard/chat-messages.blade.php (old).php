<ul class="list-unstyled mb-0">
    @foreach($messages as $k => $msgs)
    <li class="chat-day-title">
        <div><span class="title">{{($k==date('d-m-Y')?'Today':$k)}}</span></div>
    </li>
    @foreach($msgs as $msg)
    <li class="{{(auth()->id()==$msg->user_id)?'right':''}}">
        <div class="conversation-list">
            <div class="chat-avatar"><img @if ($msg->user->image == null) src="{{ asset('assets_frontend/img/ic-11.png') }}" @else src="{{ asset('uploads/profile/' . $msg->user->image) }}" @endif alt="chatvia"></div>
                            <div class="user-chat-content">
                    <div class="ctext-wrap">
                        @if($msg->type == 'sticker' && !empty($msg->sticker))
                        <div class="sticker-message">
                            <img src="{{asset($msg->sticker)}}" alt="Sticker" class="sticker-img">
                        </div>
                        @else
                        <div class="ctext-wrap-content">
                            @if(!empty($msg->images))
                            <ul class="list-inline message-img  mb-0">
                                @foreach($msg->images as $img)
                                <li class="list-inline-item message-img-list">
                                    <div><a rel="group1" class="group popup-img d-inline-block m-1" data-fancybox="gallery" target="_blank" href="{{asset($img)}}"><img src="{{asset($img)}}" alt="*" class="rounded border"></a></div>
                                </li>
                                @endforeach                            
                            </ul>
                            @endif
                            @if(!empty($msg->message))
                            <p class="mb-0">{{$msg->message}}</p>
                            @endif
                        </div>
                        @endif
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">{{$msg->created_at->format('h:i a')}}</span></p>
                    </div>                    
                    <div class="conversation-name">{{$msg->user->first_name??$msg->name}}</div>
                </div>
        </div>
    </li>
    @endforeach
    @endforeach        
        
    {{-- <li class="">
        <div class="conversation-list">
        <div class="chat-avatar"><img src="img/av2a.jpg" alt="chatvia"></div>
        <div class="user-chat-content">
            <div class="ctext-wrap">
                <div class="ctext-wrap-content">
                    <p class="mb-0">Images</p>
                    <ul class="list-inline message-img  mb-0">
                    <li class="list-inline-item message-img-list">
                        <div><a rel="group1" class="group popup-img d-inline-block m-1" data-fancybox="gallery" title="Project 1" href="img/im1.jpg"><img src="img/im1.jpg" alt="chat" class="rounded border"></a></div>
                        
                    </li>
                    <li class="list-inline-item message-img-list">
                        <div><a rel="group1" class="group popup-img d-inline-block m-1" data-fancybox="gallery"  title="Project 1" href="img/im2.jpg"><img src="img/im2.jpg" alt="chat" class="rounded border"></a></div>
                        
                    </li>
                    </ul>
                    <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:30</span></p>
                </div>
                
            </div>
            <div class="conversation-name">Doris Brown</div>
        </div>
        </div>
    </li> --}}                                                            
    </ul>