@extends('layouts.frontend')
@section('title', 'Chat | Batswana Goo')
@section('customStyles')
<link rel="stylesheet" href="{{ asset('assets_frontend/css/chat.css') }}">
@endsection
@section('content')
<section class="chatlst">
    <div class="container">
       <div class="ms-container">
           <div class="ms-sidebar">
               <div class="msg-tabs">
                  <h3>My Messages</h3>
                  <div class="m-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                       <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Active</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Archive</button>
                     </li>
                   </ul>
                  </div>
               </div><!-- msg-tabs -->
               <div class="tab-content" id="myTabContent">
                   <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <ul class="mn-lst">
                            @foreach($chats->where('is_archived', 0)->filter(function($c) { return $c->user && $c->user->exists; }) as $c)
                           <li>
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
                                        <strong>{{$c->ad && $c->ad->user ? ($c->ad->user->first_name ?? $c->ad->user->name) : 'Unknown User'}}</strong>
                                    @else
                                        <strong>{{$c->user ? ($c->user->first_name ?? $c->user->name) : 'Unknown User'}}</strong>
                                    @endif
                                       <em>{{$c->created_at->format('d M h:i a')}}</em>
                                   </div>
                                   <span>{{$c->ad ? $c->ad->title : 'Ad Not Available'}}</span>
                                   <p>{{$c->last_message_text}}</p>
                               </div>
                               <div class="m-time">

                               </div>
                             </a>
                           </li>
                           @endforeach
                       </ul>
                   </div><!-- tab-pane -->
                                      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <ul class="mn-lst">
                            @foreach($chats->where('is_archived', 1)->filter(function($c) { return $c->user && $c->user->exists; }) as $c)
                           <li>
                             <a href="{{url('dashboard/chat')}}?chat={{$c->id}}" class="{{(isset($_GET['chat']) && $_GET['chat']==$c->id)?'cilck-user-chat':''}} {{$c->is_new ? 'unread-msg' : ''}}">
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
                                         <strong>{{$c->ad && $c->ad->user ? ($c->ad->user->first_name ?? $c->ad->user->name) : 'Unknown User'}}</strong>
                                     @else
                                         <strong>{{$c->user ? ($c->user->first_name ?? $c->user->name) : 'Unknown User'}}</strong>
                                     @endif
                                        <em>{{$c->created_at->format('d M h:i a')}}</em>
                                    </div>
                                                                       <span>{{$c->ad ? $c->ad->title : 'Ad Not Available'}}</span>
                                   <p>{{$c->last_message_text}}</p>
                               </div>
                               <div class="m-time">

                               </div>
                             </a>
                           </li>
                           @endforeach
                       </ul>
                   </div><!-- tab-pane -->


               </div><!-- tab-content -->
           </div><!-- ms-sidebar -->
           <style type="text/css">

           </style>
           <div class="ms-frame user-chat-box {{(isset($_GET['chat']))?'user-chat-show':''}}">
                @if(empty($chat) || !$chat->user || !$chat->user->exists)
                <div class="start-chat">
                    @if($chats->count() == 0)
                        <!-- No chats exist at all -->
                        <div class="no-chats-message">
                            <div class="no-chats-icon">
                                <i class="material-icons">chat_bubble_outline</i>
                            </div>
                            <h3>You have no messages yet</h3>
                            <p>Find things to discuss or sell something</p>
                            <a href="{{ route('postAdd') }}" class="btn btn-success start-selling-btn">
                                <i class="material-icons">add</i>
                                Start Selling
                            </a>
                        </div>
                    @else
                        <!-- Chats exist but none is open -->
                        <div class="select-chat-message">
                            <div class="select-chat-icon">
                                <i class="material-icons">forum</i>
                            </div>
                            <h3>Select a chat to start messaging</h3>
                            <p>Choose a conversation from the left sidebar to begin chatting</p>
                        </div>
                    @endif
                </div>
                @else
               <div class="ms-room chat-conversation">
                   <div class="frame-header">
                       <div class="fh-left">
                           <div class="fram-name">
                            @php 
                                $chat_img = null;
                                if($chat->ad && $chat->ad->gallery && $chat->ad->gallery->first()) {
                                    $chat_img = $chat->ad->gallery->first()->mobile_img;
                                }
                            @endphp
                                <a class="back-chat-btn" href="#"></a>
                             @if($chat_img)
                                 <img src="{{ asset('uploads/post/' . $chat_img) }}"/>
                             @else
                                 <img src="{{ asset('assets_frontend/img/ic-11.png') }}" alt="No Image" onerror="this.src='{{ asset('assets_frontend/img/ic-11.png') }}'; this.onerror=null;"/>
                             @endif
                           </div>
                                                          <div class="f-lst">
                               <div class="f-lsta">
                                @if($chat->user && $chat->user->id==auth()->user()->id)
                                     <div><a href="#" class="a-name">{{$chat->ad && $chat->ad->user ? ($chat->ad->user->first_name ?? $chat->ad->user->name) : 'Unknown User'}}</a></div>
                                     @else
                                     <div><a href="#" class="a-name">{{$chat->user ? ($chat->user->first_name ?? $chat->user->name) : 'Unknown User'}}</a></div>
                                     @endif
                                   <div><a href="{{ $chat->ad ? url(generateUrl($chat->ad->category_id, 'category', $chat->ad->slug)) : '#' }}" target="_blank" class="a-add"><em>{{$chat->ad ? $chat->ad->title : 'Ad Not Available'}}</em></a></div>
                               </div>
                           </div>
                       </div>
                       <div class="fh-right">
                        @if($chat->ad && $chat->ad->phone)
                            <div class="f-lst-Phone">
                                <div class="p-phone">
                                    <a href="javascript:void(0);" class="s-phone">Contact</a>
                                    <div class="ss-text">
                                        <div class="noDiv">
                                        <a href="#" class="closewhts">X</a>
                                            <a href="tel:{{ $chat->ad->phone }}">{{ $chat->ad->phone }}</a>
                                            <span>|</span>
                                            <a href="https://wa.me/{{ $chat->ad->phone }}" target="_blank"><img src="{{asset('assets_frontend/whatsapp.png')}}"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="span">|</span>
                        @endif
                           <a href="#" class="archivebtn">
                               <span class="material-icons">archive</span>
                           </a>
                           <span class="span">|</span>
                           <a href="javascript:void(0);" class="refresh-btn" title="Refresh messages">
                               <span class="material-icons">refresh</span>
                           </a>
                       </div>
                   </div>

                   <div class="simplebar-content-wrapper" style="flex: 1; overflow-y: auto;">

                     <div class="simplebar-content" id="chatMessages">
                        @include('frontend.dashboard.chat-messages')
                     </div>
                   </div><!-- simplebar -->
               </div><!-- ms-room -->

               <div class="chatform">
                   <form id="MsgForm">
                       <div class="chatf">
                           <div class="chatLeft">
                               <ul class="lst-available">
                                    <li><a href="javascript:;" class="c-shorts" data-msg="Last Pice">Last Pice</a></li>
                                    <li><a href="javascript:;" class="c-shorts" data-msg="Is this available">Is this available</a></li>
                                    <li><a href="javascript:;" class="c-shorts" data-msg="Ask for Location">Ask for Location</a></li>
                                    <li><a href="javascript:;" class="c-shorts" data-msg="Please Call me">Please Call me</a></li>
                                    <li><a href="javascript:;" class="c-shorts" data-msg="Thanks">Thanks</a></li>
                               </ul>
                               <textarea class="form-control" name="msg" required id="chatMsg"></textarea>
                           </div>
                           <div class="chat-right">
                                <a href="javascript:;" id="sticker-btn">
                                    <span class="icon-attached">
                                        <img src="{{asset('assets_frontend/sticker-icon.png')}}" style="max-width: 55px; display: inline-block;">
                                    </span>
                                </a>
                                <!-- Sticker Popover -->
                                <div id="sticker-popover" class="sticker-popover" style="display: none;">
                                    <div class="sticker-popover-header">
                                        <h6>Choose Sticker</h6>
                                        <button type="button" class="close-sticker-popover">&times;</button>
                                    </div>
                                    <div class="sticker-grid">
                                        @php
                                            $stickers = \App\Models\ChatStickers::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();
                                        @endphp
                                        @foreach($stickers as $sticker)
                                            <div class="sticker-item" data-sticker="{{ $sticker->sticker }}">
                                                <img src="{{ asset($sticker->sticker) }}" alt="{{ $sticker->name }}" title="{{ $sticker->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                               <label class="uploadFile">
                                 <span class="icon-attached ">
                                   <img src="{{asset('assets_frontend/pic-icon.svg')}}" style="display: inline-block;">
                                  </span>
                                 <!-- <span class="filename">Attachment</span> -->
                                 {{csrf_field()}}
                                 <input type="hidden" name="chat_id" value="{{$chat['id']}}">
                                    <input type="file" class="inputfile form-control" id="msgPics" name="pics[]" multiple accept="image/*"><span id="picsCount"></span>
                               </label>
                               <button class="btnchat" id="btnMsg">&#9658;</button>
                           </div>
                       </div>
                   </form>
               </div><!-- chatform -->
                @endif
           </div><!-- ms-frame -->
       </div><!-- ms-container -->
    </div><!-- container -->
</section>
@if(!empty($chat))
<input type="hidden" id="chatId" value="{{$chat['id']}}" />
@endif
@endsection

@section('customScripts')
@if(!empty($chat))
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    $(function(){
        var chatMessagesDiv = document.getElementById('chatMessages');
        chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
    });
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    $("#msgPics").change(function() {
        var fileCount = $(this)[0].files.length;
        if(fileCount>0) {
            $("#chatMsg").removeAttr('required');
            $("#picsCount").text(fileCount);
            $("#picsCount").show();
        } else {
            $("#picsCount").text("");
            $("#picsCount").hide();
            $("#chatMsg").attr('required', true);
        }
    });

    $(".c-shorts").click(function(){
        $("#chatMsg").text($(this).data('msg'));
    });

    $("#MsgForm").submit(function(e){
        var formData = new FormData($('#MsgForm')[0]);
        e.preventDefault();
        $("#btnMsg").html('&infin;');
        $.ajax({
            url: "{{ url('dashboard/chat/send-message') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#MsgForm").trigger('reset');
                $("#picsCount").text("");
                $("#picsCount").hide();
                $("#chatMsg").attr('required', true);
                
                // Remove any hidden inputs added for stickers
                $('input[name="sticker"]').remove();
                $('input[name="type"]').remove();
                
                // Add the sent message immediately to the chat
                const currentTime = new Date().toLocaleString('en-US', {
                    day: '2-digit',
                    month: 'short',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
                
                addNewMessage({
                    chat_id: chatId,
                    user_id: {{auth()->id()}},
                    message: data.message || $("#chatMsg").val(),
                    timestamp: currentTime,
                    type: data.type || 'text',
                    sticker: data.sticker || null
                });
                
                // Scroll to bottom
                var chatMessagesDiv = document.getElementById('chatMessages');
                chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
            },
            error: function(xhr, status, error) {
                $("#btnMsg").html('&#9658;');
                console.error('Error sending message:', error);
            }
        });
    });
    $("#chatMsg").keypress(function (e) {
        if(e.which == 13) {
            $("#MsgForm").submit();
            $(this).val("");
            e.preventDefault();
        }
    });

    // Real-time chat functionality
    const chatId = {{$chat && $chat->id ? $chat->id : 'null'}};
    
    // Only initialize chat functionality if we have a valid chat
    if (chatId && chatId !== 'null') {
    
    // Debug: Check if Pusher config is available
    console.log('Pusher Key:', '{{ config("broadcasting.connections.pusher.key") }}');
    console.log('Pusher Cluster:', '{{ config("broadcasting.connections.pusher.options.cluster") }}');
    
    // Initialize Pusher with fallback
    let pusher;
    try {
        const pusherKey = '{{ config("broadcasting.connections.pusher.key") }}';
        const pusherCluster = '{{ config("broadcasting.connections.pusher.options.cluster") }}';
        
        if (pusherKey && pusherKey !== '' && pusherCluster && pusherCluster !== '') {
            pusher = new Pusher(pusherKey, {
                cluster: pusherCluster,
                encrypted: true
            });
        } else {
            console.warn('Pusher configuration not found, real-time chat will not work');
            pusher = null;
        }
    } catch (error) {
        console.error('Error initializing Pusher:', error);
        pusher = null;
    }

    // Subscribe to the chat channel if Pusher is available
    let channel;
    if (pusher) {
        channel = pusher.subscribe('chat.' + chatId);
        
        // Debug connection status
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected successfully');
        });
        
        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });
        
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to chat channel:', chatId);
        });
        
        channel.bind('pusher:subscription_error', function(status) {
            console.error('Failed to subscribe to chat channel:', status);
        });
    } else {
        console.log('Pusher not available, using fallback polling method');
        // Fallback: Poll for new messages every 5 seconds
        setInterval(function() {
            checkForNewMessages();
        }, 5000);
    }

    // Listen for new messages if Pusher is available
    if (pusher && channel) {
        channel.bind('chat-msg', function(data) {
            console.log('Received chat message via Pusher:', data);
            if (data.chat_id == chatId) {
                // Add new message to chat
                addNewMessage({
                    chat_id: data.chat_id,
                    user_id: data.user_id,
                    message: data.message,
                    timestamp: data.timestamp,
                    type: data.type || 'text',
                    sticker: data.sticker || null
                });
                
                // Scroll to bottom
                var chatMessagesDiv = document.getElementById('chatMessages');
                chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
            }
        });
    }

    // Fallback function to check for new messages
    function checkForNewMessages() {
        $.ajax({
            url: "{{ url('dashboard/ajax-fetch-messages') }}",
            type: 'GET',
            data: { chat_id: chatId },
            success: function(data) {
                // Update chat messages
                $("#chatMessages").html(data);
                
                // Scroll to bottom
                var chatMessagesDiv = document.getElementById('chatMessages');
                chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
            },
            error: function(xhr, status, error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Function to add new message to chat
    function addNewMessage(data) {
        const chatMessages = document.getElementById('chatMessages');
        const messageContainer = document.createElement('div');
        
        // Debug: Log the values to see what's being passed
        console.log('Current user ID:', {{auth()->id()}});
        console.log('Message user ID:', data.user_id);
        console.log('Message user ID type:', typeof data.user_id);
        
        // Create message HTML based on whether it's from current user or other user
        const currentUserId = {{auth()->id()}};
        const messageUserId = parseInt(data.user_id) || data.user_id;
        const isCurrentUser = messageUserId === currentUserId;
        
        console.log('Is current user:', isCurrentUser);
        
        const messageClass = isCurrentUser ? 'right' : '';
        const messageBg = isCurrentUser ? '#f5f7fb' : '#bedcc8';
        const messageColor = isCurrentUser ? '#343a40' : '#fff';
        
        let messageContent = '';
        if (data.type === 'sticker' && data.sticker) {
            messageContent = `<div class="sticker-message">
                <img src="${data.sticker}" alt="Sticker" class="sticker-img">
            </div>`;
        } else {
            messageContent = `<div class="ctext-wrap-content" style="background-color: ${messageBg}; color: ${messageColor};">
                ${data.message}
            </div>`;
        }
        
        messageContainer.innerHTML = `
            <div class="conversation-list ${messageClass}">
                <div class="ctext-wrap">
                    ${messageContent}
                </div>
                <div class="chat-time mb-0">${data.timestamp}</div>
            </div>
        `;
        
        chatMessages.appendChild(messageContainer);
    }
    } // Close the if statement for valid chat
</script>
@endif
<script type="text/javascript">
//  $('.mn-lst li a').on('click',function(){
//     $('.start-chat').hide();
//  });
 $('.s-phone').on('click',function(){
    $('.ss-text').slideToggle();
 });
     $('.closewhts').on('click',function(){
        $('.ss-text').slideUp();
    });
    
    // Refresh button functionality
    $('.refresh-btn').on('click', function() {
        if (typeof checkForNewMessages === 'function') {
            checkForNewMessages();
        } else {
            // Fallback refresh
            location.reload();
        }
    });
    
    // Sticker functionality
    $('#sticker-btn').on('click', function(e) {
        e.preventDefault();
        $('#sticker-popover').toggle();
    });
    
    $('.close-sticker-popover').on('click', function() {
        $('#sticker-popover').hide();
    });
    
    // Close sticker popover when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#sticker-btn, #sticker-popover').length) {
            $('#sticker-popover').hide();
        }
    });
    
    // Handle sticker selection
    $('.sticker-item').on('click', function() {
        const stickerPath = $(this).data('sticker');
        
        // Add hidden inputs to the form
        $('#MsgForm').append('<input type="hidden" name="sticker" value="' + stickerPath + '">');
        $('#MsgForm').append('<input type="hidden" name="type" value="sticker">');
        
        // Submit the form
        $('#MsgForm').submit();
        
        // Hide the popover
        $('#sticker-popover').hide();
    });
    
 $("a.group").fancybox({
    'transitionIn' : 'elastic',
    'transitionOut' : 'elastic',
    'speedIn' : 600,
    'speedOut' : 200,
    'overlayShow' : false
 });
</script>
<script type="text/javascript">
 $(document).on('click','.cilck-user-chat',function(){
    $('.user-chat-box').removeClass('user-chat-show');
    $('.cilck-user-chat').each(function(index,value){
       $(value).removeClass('active');
    });
    $(this).addClass('active');
    $('.user-chat-box').addClass('user-chat-show');
 })
 $(document).on('click','.back-chat-btn',function(){
    $('.user-chat-box').removeClass('user-chat-show');
    $('.back-chat-btn').each(function(index,value){
       $(value).removeClass('active');
    });
 })
</script>
@endsection
