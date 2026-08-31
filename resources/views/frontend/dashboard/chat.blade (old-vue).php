@extends('layouts.frontend')
@section('title', 'Chat | Salone Goo')
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
                       <button class="nav-link" :class="{active: activeTab === 'active'}" @click="setActiveTab('active')" type="button">Active</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" :class="{active: activeTab === 'archived'}" @click="setActiveTab('archived')" type="button">Archive</button>
                     </li>
                   </ul>
                  </div>
               </div><!-- msg-tabs -->
               <div class="tab-content" id="myTabContent">
                   <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="mn-lst">
                            <div v-if="filteredChats.length === 0" class="no-chats">
                                <i class="material-icons" style="font-size: 48px; color: #dee2e6;">chat_bubble_outline</i>
                                <h6 class="mt-2">No messages yet</h6>
                                <p class="text-muted">Start a conversation by messaging someone</p>
                            </div>
                            <li v-for="chat in filteredChats" class="chat-item" :key="chat.id">
                             <a href="javascript:void(0);" @click="selectChat(chat)" :class="{active: selectedChat && selectedChat.id === chat.id, 'unread-msg': chat.is_new}">
                                <div class="m-img">
                                    <img :src="chat.ad_image" alt="Ad"/>
                                </div>
                                <div class="m-name">
                                  <div class="m-header">
                                    <strong>@{{ chat.user_name }}</strong>
                                    <em>@{{ chat.created_at }}</em>
                                  </div>
                                  <span>@{{ chat.ad_title }}</span>
                                  <p>@{{ chat.last_message || 'No messages yet' }}</p>
                              </div>
                              <span v-if="chat.unread_count && (!selectedChat || selectedChat.id !== chat.id)" class="badge bg-success chat-undread-count">@{{ chat.unread_count }}</span>
                              <div class="m-time">
                                  
                              </div>
                            </a>
                          </li>
                       </ul>
                   </div><!-- tab-pane -->
               </div><!-- tab-content -->
           </div><!-- ms-sidebar -->
           <div class="ms-frame user-chat-box" :class="{'user-chat-show': selectedChat}">
                <div v-if="!selectedChat" class="start-chat">
                    <div class="select-chat-message">
                        <div class="select-chat-icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <h3>Select a chat to start messaging</h3>
                        <p>Choose a conversation from the left sidebar to begin chatting</p>
                    </div>
                </div>
                <div v-else>
               <div class="ms-room chat-conversation">
                   <div class="frame-header">
                       <div class="fh-left">
                           <div class="fram-name">
                                <a class="back-chat-btn" href="javascript:void(0);" @click="selectedChat = null"></a>
                                <img :src="selectedChat.ad_image" alt="Ad"/>
                           </div>
                           <div class="f-lst">
                               <div class="f-lsta">
                                    <div><a href="#" class="a-name">@{{ selectedChat.user_name }}</a></div>
                                   <div><a href="#" class="a-add"><em>@{{ selectedChat.ad_title }}</em></a></div>
                               </div>
                           </div>
                       </div>
                       <div class="fh-right">
                        <div v-if="selectedChat.ad_phone" class="f-lst-Phone">
                            <div class="p-phone">
                                <a href="javascript:void(0);" class="s-phone">Contact</a>
                                <div class="ss-text">
                                    <div class="noDiv">
                                    <a href="#" class="closewhts">X</a>
                                        <a :href="'tel:' + selectedChat.ad_phone">@{{ selectedChat.ad_phone }}</a>
                                        <span>|</span>
                                        <a :href="'https://wa.me/' + selectedChat.ad_phone" target="_blank"><img src="{{asset('assets_frontend/whatsapp.png')}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span v-if="selectedChat.ad_phone" class="span">|</span>
                           <a href="javascript:void(0);" class="archivebtn">
                               <span class="material-icons">archive</span>
                           </a>
                           <span class="span">|</span>
                           <a href="javascript:void(0);" class="refresh-btn" title="Refresh messages" @click="refreshMessages">
                               <span class="material-icons">refresh</span>
                           </a>
                       </div>
                   </div>
                   <div class="simplebar-content-wrapper" style="flex: 1; overflow-y: auto;">
                     <div class="simplebar-content" id="chatMessages" ref="messagesContainer">
                        <div v-if="loadingMessages" class="loading">
                            Loading messages...
                        </div>
                        <div v-else>
                            <div v-for="day in messages" :key="day.date" class="mb-4">
                                <div class="text-center mb-3">
                                    <span class="badge bg-secondary">@{{ formatDate(day.date) }}</span>
                                </div>
                                
                                <div v-for="message in day.messages" :key="message.id" 
                                     class="conversation-list" 
                                     :class="{right: message.is_current_user}"
                                     :style="message.is_current_user ? 'float: right; text-align: right; margin-bottom: 15px; clear: both;' : 'float: left; text-align: left; margin-bottom: 15px; clear: both;'">
                                    <div class="ctext-wrap">
                                        <div v-if="message.type === 'sticker' && message.sticker" class="sticker-message">
                                            <img :src="message.sticker" alt="Sticker" class="sticker-img">
                                        </div>
                                        <div v-else class="ctext-wrap-content" :style="message.is_current_user ? 'background-color: #bedcc8; color: #fff;' : 'background-color: #f5f7fb; color: #343a40;'">
                                            <div v-if="message.images && message.images.length" class="mb-2">
                                                <div class="d-flex flex-wrap gap-1">
                                                    <img v-for="image in message.images" :key="image" 
                                                         :src="image" alt="Image" 
                                                         class="rounded" 
                                                         style="max-width: 100px; max-height: 100px; object-fit: cover; cursor: pointer;"
                                                         @click="openImageModal(image)">
                                                </div>
                                            </div>
                                            <div v-if="message.message">@{{ message.message }}</div>
                                        </div>
                                    </div>
                                    <div class="chat-time mb-0">@{{ message.timestamp }}</div>
                                </div>
                            </div>
                        </div>
                     </div>
                   </div><!-- simplebar -->
               <div class="chatform">
                   <form @submit.prevent="sendMessage">
                       <div class="chatf">
                           <div class="chatLeft">
                               <ul class="lst-available">
                                    <li><a href="javascript:;" class="c-shorts" @click="setQuickMessage('Last Price')">Last Price</a></li>
                                    <li><a href="javascript:;" class="c-shorts" @click="setQuickMessage('Is this available')">Is this available</a></li>
                                    <li><a href="javascript:;" class="c-shorts" @click="setQuickMessage('Ask for Location')">Ask for Location</a></li>
                                    <li><a href="javascript:;" class="c-shorts" @click="setQuickMessage('Please Call me')">Please Call me</a></li>
                                    <li><a href="javascript:;" class="c-shorts" @click="setQuickMessage('Thanks')">Thanks</a></li>
                               </ul>
                               <textarea class="form-control" v-model="newMessage" required placeholder="Type your message..." :disabled="sending"></textarea>
                           </div>
                           <div class="chat-right">
                                <a href="javascript:;" @click="showStickers = !showStickers">
                                    <span class="icon-attached">
                                        <img src="{{asset('assets_frontend/sticker-icon.png')}}" style="max-width: 55px; display: inline-block;">
                                    </span>
                                </a>
                                <!-- Sticker Popover -->
                                <div v-if="showStickers" class="sticker-popover">
                                    <div class="sticker-popover-header">
                                        <h6>Choose Sticker</h6>
                                        <button type="button" @click="showStickers = false">&times;</button>
                                    </div>
                                    <div class="sticker-grid">
                                        <div v-for="sticker in stickers" :key="sticker.id" 
                                             class="sticker-item" 
                                             @click="sendSticker(sticker.sticker)">
                                            <img :src="sticker.sticker" :alt="sticker.name" :title="sticker.name">
                                        </div>
                                    </div>
                                </div>
                               <label class="uploadFile">
                                 <span class="icon-attached ">
                                   <img src="{{asset('assets_frontend/pic-icon.svg')}}" style="display: inline-block;">
                                  </span>
                                 <input type="file" class="inputfile form-control" @change="handleFileUpload" multiple accept="image/*"><span id="picsCount"></span>
                               </label>
                               <button class="btnchat" type="submit" :disabled="!newMessage.trim() && !selectedFiles.length || sending">
                                   <span v-if="sending">&infin;</span>
                                   <span v-else>&#9658;</span>
                               </button>
                           </div>
                       </div>
                   </form>
               </div><!-- chatform -->
                </div>
           </div><!-- ms-frame -->
       </div><!-- ms-container -->
    </div><!-- container -->
</section>
    
    <!-- Image Modal -->
    <div v-if="showImageModal" class="modal fade" tabindex="-1" @click.self="closeImageModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Image</h5> --}}
                    <button type="button" class="btn-close" @click="closeImageModal"><i class="material-icons">close</i></button>
                </div>
                <div class="modal-body text-center">
                    <img :src="selectedImage" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
new Vue({
    el: '.chatlst',
    data: {
        // Chat data
        chats: [],
        selectedChat: null,
        messages: [],
        activeTab: 'active',
        
        // UI state
        loading: true,
        loadingMessages: false,
        sending: false,
        showContactInfo: false,
        showStickers: false,
        showImageModal: false,
        selectedImage: null,
        
        // Message input
        newMessage: '',
        selectedFiles: [],
        
        // Stickers
        stickers: [],
        
        // Pusher
        pusher: null,
        channels: {},
        
        // Auto refresh
        chatRefreshInterval: null,
        
        // Current user
        currentUserId: {{ auth()->id() }}
    },
    
    computed: {
        filteredChats() {
            // Ensure chats is always an array
            const chatsArray = Array.isArray(this.chats) ? this.chats : [];
            console.log('filteredChats - chatsArray:', chatsArray);
            console.log('filteredChats - activeTab:', this.activeTab);
            
            const filtered = chatsArray.filter(chat => {
                console.log('Filtering chat:', chat);
                console.log('chat.is_archived:', chat.is_archived, 'type:', typeof chat.is_archived);
                
                if (this.activeTab === 'active') {
                    return !chat.is_archived || chat.is_archived === 0 || chat.is_archived === '0';
                } else {
                    return chat.is_archived === 1 || chat.is_archived === '1' || chat.is_archived === true;
                }
            });
            
            console.log('filteredChats - filtered result:', filtered);
            return filtered;
        }
    },
    
    mounted() {
        // Ensure image modal is closed on page load
        this.showImageModal = false;
        this.selectedImage = null;
        
        this.initializePusher();
        this.loadStickers();
        this.loadChats();
        this.startAutoRefresh();
        
        // Add keyboard event listener for closing modal
        this.handleKeydown = (e) => {
            if (e.key === 'Escape' && this.showImageModal) {
                this.closeImageModal();
            }
        };
        document.addEventListener('keydown', this.handleKeydown);
    },
    
    beforeDestroy() {
        if (this.chatRefreshInterval) {
            clearInterval(this.chatRefreshInterval);
        }
        if (this.pusher) {
            this.pusher.disconnect();
        }
        
        // Remove keyboard event listener
        document.removeEventListener('keydown', this.handleKeydown);
    },
    
    methods: {
        initializePusher() {
            try {
                this.pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
                    cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
                    forceTLS: true,
                    enabledTransports: ['ws','wss']
                });
                
                this.pusher.connection.bind('connected', () => {
                    console.log('Pusher connected successfully');
                });
                
                this.pusher.connection.bind('error', (err) => {
                    console.error('Pusher connection error:', err);
                });
                
            } catch (error) {
                console.error('Error initializing Pusher:', error);
            }
        },
        
        loadChats() {
            this.loading = true;
            fetch('/dashboard/api/chats')
                .then(response => response.json())
                .then(data => {
                    console.log('API Response:', data);
                    console.log('Chats data:', data.chats);
                    console.log('Is array:', Array.isArray(data.chats));
                    
                    // Convert object with numeric keys to array if needed
                    let chatsData = data.chats;
                    if (!Array.isArray(chatsData) && typeof chatsData === 'object') {
                        // Convert object with numeric keys to array
                        chatsData = Object.values(chatsData);
                        console.log('Converted object to array:', chatsData);
                    }
                    
                    // Ensure chats is always an array
                    this.chats = Array.isArray(chatsData) ? chatsData : [];
                    console.log('Final chats:', this.chats);
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error loading chats:', error);
                    this.chats = []; // Set to empty array on error
                    this.loading = false;
                });
        },
        
        loadMessages(chatId) {
            if (!chatId) return;
            
            this.loadingMessages = true;
            fetch(`/dashboard/api/messages/${chatId}`)
                .then(response => response.json())
                .then(data => {
                    this.selectedChat = data.chat;
                    
                    // Process messages to ensure proper user identification
                    this.messages = Object.values(data.messages).map(dayGroup => {
                        return {
                            date: dayGroup.date,
                            messages: dayGroup.messages.map(msg => {
                                const isCurrentUser = parseInt(msg.user_id) === parseInt(this.currentUserId);
                                console.log('LoadMessages Debug - msg.user_id:', msg.user_id, 'currentUserId:', this.currentUserId, 'isCurrentUser:', isCurrentUser);
                                return {
                                    ...msg,
                                    is_current_user: isCurrentUser
                                };
                            })
                        };
                    });
                    
                    this.loadingMessages = false;
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                    
                    // Subscribe to chat channel for real-time updates
                    this.subscribeToChat(chatId);
                    // After opening, refresh chat list to update unread counts
                    this.loadChats();
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    this.loadingMessages = false;
                });
        },
        
        subscribeToChat(chatId) {
            if (!this.pusher) return;
            
            // Unsubscribe from previous channel
            if (this.channels[chatId]) {
                this.pusher.unsubscribe(`chat.${chatId}`);
            }
            
            // Subscribe to new channel
            const channel = this.pusher.subscribe(`chat.${chatId}`);
            channel.bind('pusher:subscription_succeeded', () => {
                console.log('Subscribed to chat channel', `chat.${chatId}`);
            });
            channel.bind('pusher:subscription_error', (status) => {
                console.error('Subscription error', status);
            });
            
            channel.bind('chat-msg', (data) => {
                console.log('Received message:', data);
                this.addMessage(data);
            });
            
            this.channels[chatId] = channel;
        },
        
        addMessage(messageData) {
            const today = new Date();
            const messageDate = messageData.date || today.toISOString().split('T')[0];
            
            // Format timestamp if not provided
            let timestamp = messageData.timestamp;
            if (!timestamp) {
                const now = new Date();
                timestamp = now.toLocaleString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
            }
            
            // Find or create day group
            let dayGroup = this.messages.find(day => day.date === messageDate);
            if (!dayGroup) {
                dayGroup = { date: messageDate, messages: [] };
                this.messages.push(dayGroup);
            }
            
            // Prevent duplicates by id (if provided)
            const isCurrentUser = parseInt(messageData.user_id) === parseInt(this.currentUserId);
            if (messageData.id) {
                const exists = dayGroup.messages.some(m => m.id === messageData.id);
                if (exists) {
                    console.log('Duplicate message ignored (id):', messageData.id);
                    return;
                }
            }
            console.log('Debug - messageData.user_id:', messageData.user_id, 'currentUserId:', this.currentUserId, 'isCurrentUser:', isCurrentUser);
            console.log('Debug - messageData:', messageData);
            
            dayGroup.messages.push({
                id: messageData.id || Date.now(), // Use provided ID or generate temporary one
                user_id: messageData.user_id,
                message: messageData.message,
                type: messageData.type || 'text',
                sticker: messageData.sticker,
                images: messageData.images,
                user_name: messageData.user_name,
                user_image: messageData.user_image,
                timestamp: timestamp,
                is_current_user: isCurrentUser
            });
            
            this.$nextTick(() => {
                this.scrollToBottom();
            });
        },
        
        selectChat(chat) {
            this.selectedChat = chat;
            this.loadMessages(chat.id);
        },
        
        setActiveTab(tab) {
            this.activeTab = tab;
        },
        
        sendMessage() {
            if (!this.selectedChat || (!this.newMessage.trim() && !this.selectedFiles.length) || this.sending) {
                return;
            }
            
            this.sending = true;
            
            const formData = new FormData();
            formData.append('chat_id', this.selectedChat.id);
            formData.append('msg', this.newMessage);
            
            // Add files
            this.selectedFiles.forEach(file => {
                formData.append('pics[]', file.file);
            });
            
            fetch('/dashboard/api/send-message', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear inputs; do not append optimistically; wait for broadcast
                    this.newMessage = '';
                    this.selectedFiles = [];
                }
                this.sending = false;
            })
            .catch(error => {
                console.error('Error sending message:', error);
                this.sending = false;
            });
        },
        
        sendSticker(stickerPath) {
            if (!this.selectedChat || this.sending) return;
            
            this.sending = true;
            
            const formData = new FormData();
            formData.append('chat_id', this.selectedChat.id);
            formData.append('sticker', stickerPath);
            formData.append('type', 'sticker');
            
            fetch('/dashboard/api/send-message', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.addMessage(data.message);
                }
                this.sending = false;
                this.showStickers = false;
            })
            .catch(error => {
                console.error('Error sending sticker:', error);
                this.sending = false;
            });
        },
        
        setQuickMessage(message) {
            this.newMessage = message;
        },
        
        handleFileUpload(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.selectedFiles.push({
                            file: file,
                            preview: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
            event.target.value = '';
        },
        
        removeFile(index) {
            this.selectedFiles.splice(index, 1);
        },
        
        loadStickers() {
            fetch('/dashboard/api/stickers')
                .then(response => response.json())
                .then(data => {
                    this.stickers = data.stickers || [];
                })
                .catch(error => {
                    console.error('Error loading stickers:', error);
                });
        },
        
        refreshMessages() {
            if (this.selectedChat) {
                this.loadMessages(this.selectedChat.id);
            }
        },
        
        startAutoRefresh() {
            // Refresh chat list every 20 seconds
            this.chatRefreshInterval = setInterval(() => {
                this.loadChats();
            }, 20000);
        },
        
        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },
        
        formatDate(dateString) {
            const date = new Date(dateString.split('-').reverse().join('-'));
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            
            if (date.toDateString() === today.toDateString()) {
                return 'Today';
            } else if (date.toDateString() === yesterday.toDateString()) {
                return 'Yesterday';
            } else {
                return date.toLocaleDateString();
            }
        },
        
        openImageModal(imageSrc) {
            this.selectedImage = imageSrc;
            this.showImageModal = true;
        },
        
        closeImageModal() {
            this.showImageModal = false;
            this.selectedImage = null;
        }
    }
});
</script>
@endsection
