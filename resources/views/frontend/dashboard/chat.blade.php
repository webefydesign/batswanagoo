@extends('layouts.frontend')
@section('title', 'Chat | Salone Goo')
@section('customStyles')
<link rel="stylesheet" href="{{ asset('assets_frontend/css/chat.css') }}?v=1">
<style>
    .chat-scroll {
        height: 60vh; /* or 100% if parent has fixed height */
        padding-bottom: 50px;
        overflow-y: auto;
        padding-right: 10px;
        scroll-behavior: smooth;
    }
    li.active-chat a {
        background-color: #e6ebf5;
    }
    #picsCount {
      position: absolute;
      top: 16px;
      z-index: 9999999999999;
      color: #000000;
      font-size: 13px;
      left: 39px;
      font-weight: bold;
    }
    .read-tick {
      color: #1d9bf0; /* blue color */
      font-size: 8px;
      margin-left: 5px;
    }
</style>
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
                   <div class="tab-pane fade show active chat-listDiv" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @include('frontend.dashboard.chat-list')
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
                                <i class="material-icons">forum</i>
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
                <div id="chatApp">

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
                                          <div><a href="{{ route('viewProfile', $chat->ad->user->id) }}" class="a-name" style="color: #1caf39;font-weight: bold;">{{$chat->ad && $chat->ad->user ? ($chat->ad->user->first_name ?? $chat->ad->user->name) : 'Unknown User'}}</a></div>
                                          @else
                                          <div><a href="{{ route('viewProfile', $chat->user->id) }}" class="a-name" style="color: #1caf39;font-weight: bold;">{{$chat->user ? ($chat->user->first_name ?? $chat->user->name) : 'Unknown User'}}</a></div>
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
     
                        <div class="chat-scroll" ref="chatContainer">
                            <ul class="list-unstyled mb-0">
                              <template v-for="(group, date) in messages" :key="date">
                                <li class="chat-day-title">
                                  <div><span class="title">@{{ date === today ? 'Today' : date }}</span></div>
                                </li>
                                <template v-for="msg in group" :key="msg.id">
                                  <li :class="msg.user_id == userId ? 'right' : 'left'">
                                    <div class="conversation-list">
                                      <div class="chat-avatar">
                                        <img :src="msg.user?.image ? '/uploads/profile/' + msg.user.image : '/assets_frontend/img/ic-11.png'" />
                                      </div>
                                      <div class="user-chat-content">
                                        <div class="ctext-wrap">
                                          <!-- Sticker -->
                                          <div v-if="msg.type === 'sticker' && msg.sticker" class="sticker-message">
                                            <img :src="msg.sticker" alt="Sticker" class="sticker-img">
                                          </div>
                          
                                          <!-- Images -->
                                          <div v-if="msg.images && msg.images.length" class="ctext-wrap-content">
                                            <ul class="list-inline message-img mb-0">
                                              <li v-for="(img, i) in msg.images" :key="i" class="list-inline-item message-img-list">
                                                <a :href="img" class="popup-img" target="_blank">
                                                  <img :src="img" alt="Image" class="rounded border" style="max-height: 100px;" />
                                                </a>
                                              </li>
                                            </ul>
                                          </div>
                          
                                          <!-- Text -->
                                          <div v-if="msg.message && msg.type === 'text'" class="ctext-wrap-content">
                                            <p>@{{ msg.message }}</p>
                                          </div>
                          
                                          {{-- <p class="chat-time mb-0">
                                            <i class="ri-time-line align-middle"></i>
                                            <span>@{{ formatTime(msg.created_at) }}</span>
                                          </p> --}}
                                          <p class="chat-time mb-0">
                                            <i class="ri-time-line align-middle"></i>
                                            <span>@{{ formatTime(msg.created_at) }}</span>
                                            <span v-if="msg.user_id == userId" class="read-tick">
                                              <template v-if="msg.unread == 0">✓✓</template>
                                              <template v-else>✓</template>
                                            </span>
                                          </p>
                                        </div>
                                        <div class="conversation-name">@{{ msg.user?.first_name || msg.user?.name }}</div>
                                      </div>
                                    </div>
                                  </li>
                                </template>
                              </template>
                            </ul>
                        </div><!-- simplebar -->
                    </div><!-- ms-room -->
                    <div class="chatform">
                        <form id="MsgForm" @submit.prevent="sendMessage" enctype="multipart/form-data">
                            <div class="chatf">
                                <div class="chatLeft">
                                    <ul class="lst-available">
                                         <li v-for="text in quickReplies" :key="text">
                                             <a href="javascript:;" @click="msgText = text" class="c-shorts">@{{ text }}</a>
                                         </li>
                                    </ul>
                                    <ul class="picure-previews" v-if="selectedImages.length">
                                      <li v-for="(file, index) in selectedImages" :key="index">
                                        <img :src="file.preview" alt="preview">
                                      </li>
                                    </ul>
                                    {{-- <textarea class="form-control" name="msg" required v-model="msgText" id="chatMsg"></textarea> --}}
                                    <textarea class="form-control" name="msg" :required="isMsgRequired" v-model="msgText" id="chatMsg"></textarea>
                                </div>
                                <div class="chat-right">
                                     <a href="javascript:;" id="sticker-btn">
                                         <span class="icon-attached">
                                             <img src="{{asset('assets_frontend/sticker-icon.png')}}" style="max-width: 45px; display: inline-block;">
                                         </span>
                                     </a>
                                     <!-- Sticker Popover -->
                                     <div id="sticker-popover" class="sticker-popover" style="display: none;">
                                         <div class="sticker-popover-header">
                                             <h6>Choose Sticker</h6>
                                             <button type="button" class="close-sticker-popover">&times;</button>
                                         </div>
                                         <div class="sticker-grid">
                                             <div v-for="sticker in stickers" class="sticker-item" @click="sendSticker(sticker.sticker)">
                                                 <img :src="sticker.sticker" :alt="sticker.name" />
                                               </div>
                                         </div>
                                     </div>
                                    <label class="uploadFile">
                                      <span class="icon-attached ">
                                        <img src="{{asset('assets_frontend/pic-icon.svg')}}" style="display: inline-block;">
                                       </span>
                                      <!-- <span class="filename">Attachment</span> -->
                                      {{csrf_field()}}
                                      <input type="hidden" name="chat_id" value="{{$chat['id']}}">
                                      <input type="file" class="inputfile form-control" id="msgPics" name="pics[]" multiple accept="image/*" @change="handleFileChange" /> <span id="picsCount"></span>
                                    </label>
                                    <button class="btnchat" id="btnMsg">&#9658;</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- chatform -->
                </div>

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
<script>
  document.addEventListener("DOMContentLoaded", function () {
      const chatListDiv = document.querySelector('.chat-listDiv');
      const urlParams = new URLSearchParams(window.location.search);
      const activeChatId = urlParams.get('chat'); // e.g. "14"
  
      async function refreshChatList() {
          try {
            const response = await fetch(`{{ route('fetchChatList') }}?chat_id=${activeChatId || ''}`);
              const html = await response.text();
  
              chatListDiv.innerHTML = html;              
          } catch (err) {
              console.error("Error refreshing chat list:", err);
          }
      }
  
      // Refresh every 3 seconds
      setInterval(refreshChatList, 3000);
  
      // Initial refresh
      refreshChatList();
  });
</script>
@if(!empty($chat))
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
  const { createApp, ref, onMounted, nextTick, computed } = Vue;
  
  createApp({
    setup() {
      const chatId = {{ $chat->id }};
      const userId = {{ auth()->id() }};
      const messages = ref({});
      const msgText = ref('');
      const selectedImages = ref([]); // track uploaded files
      const today = new Date().toLocaleDateString('en-GB').replace(/\//g, '-');
      const quickReplies = ["Last Piece", "Is this available", "Ask for Location", "Please Call me", "Thanks"];
      const stickers = @json($stickers);
      const chatContainer = ref(null);
  
      const formatTime = (datetime) => {
        const d = new Date(datetime);
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      };
  
      const fetchMessages = async () => {
        const res = await fetch(`{{ route('fetchChatMessages') }}?chat_id=${chatId}`);
        const data = await res.json();
        messages.value = data;
        nextTick(scrollToBottom);
      };
  
      // handle file input change
      // const handleFileChange = (e) => {
      //   selectedImages.value = Array.from(e.target.files);
      //   const countEl = document.getElementById('picsCount');
      //   countEl.textContent = selectedImages.value.length
      //     ? `${selectedImages.value.length}`
      //     : '';
      // };

      const handleFileChange = (e) => {
        const files = Array.from(e.target.files);

        if (files.length > 3) {
          alert("You can only upload a maximum of 3 images.");
          e.target.value = '';
          selectedImages.value = [];
          return;
        }

        // Create preview URLs
        selectedImages.value = files.map(file => {
          file.preview = URL.createObjectURL(file);
          return file;
        });
      };
  
      const sendMessage = async () => {
        const message = msgText.value.trim();
  
        // Prevent sending if both empty
        if (!message && selectedImages.value.length === 0) return;
  
        const formData = new FormData();
        formData.append('chat_id', chatId);
        formData.append('msg', message);
  
        selectedImages.value.forEach((file) => {
          formData.append('pics[]', file);
        });
  
        try {
          await fetch('{{ route('sendMsg') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
          });
  
          // Reset after send
          msgText.value = '';
          selectedImages.value = [];
          const fileInput = document.getElementById('msgPics');
          const countEl = document.getElementById('picsCount');
          if (fileInput) fileInput.value = '';
          if (countEl) countEl.textContent = '';
        } catch (error) {
          console.error('Error sending message:', error);
        }
      };
  
      const sendSticker = async (stickerUrl) => {
        const formData = new FormData();
        formData.append('chat_id', chatId);
        formData.append('sticker', stickerUrl);
  
        await fetch('{{ route('sendMsg') }}', {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: formData,
        });
      };
  
      const scrollToBottom = () => {
        if (chatContainer.value) {
          chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
      };
  
      const listen = () => {
        Pusher.logToConsole = true;
  
        const pusher = new Pusher("a5aa0e9bdb5514e947d1", {
          cluster: "ap1",
          forceTLS: true,
        });
  
        const channel = pusher.subscribe(`chat.${chatId}`);
  
        channel.bind("message.sent", function (data) {
          console.log("📩 New message received:", data);
  
          const msg = data.message;
          const dateKey = new Date(msg.created_at)
            .toLocaleDateString("en-GB")
            .replace(/\//g, "-");
  
          if (!messages.value[dateKey]) messages.value[dateKey] = [];
          messages.value[dateKey].push(msg);
  
          nextTick(scrollToBottom);
        });
      };
  
      onMounted(() => {
        fetchMessages();
        listen();

        setInterval(fetchMessages, 5000);
      });
  
      // 🔹 computed property to control textarea `required`
      const isMsgRequired = computed(() => selectedImages.value.length === 0);
  
      return {
        messages,
        msgText,
        sendMessage,
        sendSticker,
        formatTime,
        today,
        quickReplies,
        stickers,
        userId,
        chatContainer,
        handleFileChange,
        selectedImages,
        isMsgRequired
      };
    },
  }).mount('#chatApp');
</script>
{{-- <script>
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
</script> --}}
<script>
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
</script>
@endif


@endsection
