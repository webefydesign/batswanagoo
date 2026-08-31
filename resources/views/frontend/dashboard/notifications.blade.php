@extends('layouts.frontend')
@section('title', 'Notifications | Batswana Goo')
@section('customStyles')
    <style>
    .all-list-sh .eve-box {
        display: flex;
        align-items: stretch;
    }
    .forprfile .container {
        background: none;
        border:none;
        padding: 30px;
        max-width: 1300px;
    }
    .forprfile .cr .container {padding:0;}
    .sl-notifications {
        /* background: #e9f2f8; */
        /* border-radius: 8px; */
        /* padding: 10px; */
        width: 100%;
    }

    .notification-item {
        background: transparent;
        border-bottom: 1px solid #cecece;
        transition: background 0.2s ease, opacity 0.3s ease;
    }

    .notification-item.unread {
        background: #f7fcff;
        border-left: 3px solid #1eaf38;
    }

    .notification-item:hover {
        background: #eef7ff;
    }

    .notification-images {
        min-width: 60px;
        flex-wrap: wrap;
    }
    .notification-content {
        font-size: 12px;
    }

    .notification-images img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .mark-read-btn {
        font-size: 12px;
        padding: 4px 8px;
    }
    .panel {
        position: relative;
    }
    .bottom-btns {
        position: absolute;
        width: 100%;
        bottom: -50px;
        right: 0px;
        padding: 10px;
    }
    </style>
@endsection
@section('content')

    <div class="m-container forprfile">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel-group">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                @include('frontend.dashboard.profile_main_nav')
                            </div><!-- panl-body -->
                        </div>
                    </div>                    
                </div><!-- sm4 -->
                <div class="col-sm-9">
                    <div class="panel-group">
                        <div class="panel panel-default">
                          <form action="{{route('dashboard.markAllAsRead')}}" method="post" id="markAllAsReadForm">
                            @csrf
                          </form>
                            <div class="panel-heading">
                                <div class="tab-heads d-flex justify-content-between align-items-center">
                                    <h3>Notifications ({{ $user->unreadNotificationCount() }})</h3>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-success" onclick="document.getElementById('markAllAsReadForm').submit()">Mark all as read</a>                                    
                                </div><!-- tab-heads -->

                            </div><!-- panel-heading -->
                            <div class="panel-body">
                                <div class="sl-notifications">
                                  @foreach($data as $v)
                                    @if($v->type == 'advertise')
                                    @php 
                                      $adUrl = generateUrl($v->ad->category_id, 'category', $v->ad->slug);
                                      if($v->ad->status != 'active') {
                                        $adUrl = route('dashboard.editPost', $v->ad->id);
                                      }
                                    @endphp
                                    <!-- Single image -->
                                    <div class="notification-item {{ $v->is_read == 0 ? 'unread' : '' }} d-flex align-items-center p-3 mb-2 rounded">
                                      <div class="notification-images d-flex me-2">
                                        <a href="{{ url($adUrl) }}">
                                          <img src="{{ asset('uploads/post/' . $v->ad->gallery->first()->image) }}">
                                        </a>
                                      </div>
                                      <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                          <strong><a href="{{ url($adUrl) }}">{{ $v->title }}</a></strong> {{ $v->message }}
                                        </p>
                                        <small class="text-muted">{{ $v->created_at->format('d/m/Y H:i') }}</small>
                                      </div>                                      
                                        <button class="btn btn-sm {{($v->is_read == 0 ? 'btn-outline-primary' : 'btn-outline-secondary')}} ms-auto read-btn" data-type="{{($v->is_read == 0 ? 'unread' : 'read')}}" data-id="{{ $v->id }}">
                                          {{$v->is_read == 0 ? 'Mark as read' : 'Mark as unread'}}
                                        </button>
                                    </div>
                                    @elseif($v->type == 'message')
                                    <div class="notification-item {{ $v->is_read == 0 ? 'unread' : '' }} d-flex align-items-center p-3 mb-2 rounded">
                                      <div class="notification-images d-flex me-2">
                                        <a href="javascript:;" class="view-msg" data-notify-id="{{ $v->id }}" data-id="{{ $v->msg_id }}"><img src="{{ asset('uploads/post/' . $v->ad->gallery->first()->image) }}"></a>
                                      </div>
                                      <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                          <strong><a href="javascript:;" class="view-msg" data-notify-id="{{ $v->id }}" data-id="{{ $v->msg_id }}">{{ $v->title }}</a></strong> {{ $v->message }}
                                        </p>
                                        <small class="text-muted">{{ $v->created_at->format('d/m/Y H:i') }}</small>
                                      </div>
                                      <button class="btn btn-sm {{($v->is_read == 0 ? 'btn-outline-primary' : 'btn-outline-secondary')}} ms-auto read-btn" data-type="{{($v->is_read == 0 ? 'unread' : 'read')}}" data-id="{{ $v->id }}">
                                        {{$v->is_read == 0 ? 'Mark as read' : 'Mark as unread'}}
                                      </button>
                                    </div>
                                    @elseif($v->type == 'wallet')
                                    <div class="notification-item {{ $v->is_read == 0 ? 'unread' : '' }} d-flex align-items-center p-3 mb-2 rounded">
                                      <div class="notification-images d-flex me-2">
                                        <a href="{{ route('dashboard.wallet') }}">
                                          <img src="{{ asset('assets_frontend/img/money.png') }}">
                                        </a>
                                      </div>
                                      <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                          <strong><a href="{{ route('dashboard.wallet') }}">{{ $v->title }}</a></strong> {{ $v->message }}
                                        </p>
                                        <small class="text-muted">{{ $v->created_at->format('d/m/Y H:i') }}</small>
                                      </div>
                                      <button class="btn btn-sm {{($v->is_read == 0 ? 'btn-outline-primary' : 'btn-outline-secondary')}} ms-auto read-btn" data-type="{{($v->is_read == 0 ? 'unread' : 'read')}}" data-id="{{ $v->id }}">
                                        {{$v->is_read == 0 ? 'Mark as read' : 'Mark as unread'}}
                                      </button>
                                    </div>
                                    @endif
                                    @endforeach
                                    <!-- Multiple images -->
                                    {{-- <div class="notification-item unread d-flex align-items-center p-2 mb-2 rounded">
                                      <div class="notification-images d-flex me-2 flex-wrap">
                                        <img src="https://placehold.co/60x60" alt="">
                                        <img src="https://placehold.co/60x60" alt="">
                                        <img src="https://placehold.co/60x60" alt="">
                                      </div>
                                      <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                          <strong>These ads might be interesting for you!</strong> Check now!
                                        </p>
                                        <small class="text-muted">yesterday, 20:36</small>
                                      </div>
                                      <button class="btn btn-sm btn-outline-primary ms-auto mark-read-btn">
                                        Mark as read
                                      </button>
                                    </div> --}}
                                  
                                    <!-- Read item -->
                                    {{-- <div class="notification-item d-flex align-items-center p-2 mb-2 rounded">
                                      <div class="notification-images d-flex me-2">
                                        <img src="https://placehold.co/60x60" alt="">
                                      </div>
                                      <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                          <strong>These ads might be interesting for you!</strong> Check now!
                                        </p>
                                        <small class="text-muted">15/10</small>
                                      </div>
                                      <button class="btn btn-sm btn-outline-secondary ms-auto mark-read-btn" disabled>
                                        Read
                                      </button>
                                    </div> --}}
                                  
                                  </div>
                                {{-- <table class="table table-bordered">
                                    @foreach($data as $v)
                                    <tr>
                                        <td><input type="checkbox" value="{{$v->id}}"></td>
                                        <td> 
                                            <b>{{$v->message}}</b>
                                        </td>
                                        <td>{{$v->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </table> --}}
                                <div class="bottom-btns">
                                    {{ $data->links('pagination::bootstrap-4') }}
                                </div>
                            </div><!-- panl-body -->
                        </div>
                    </div><!-- sm8 -->
                </div>
            </div>
        </div>


 <!-- Msg Detail Modal -->
<div id="msgDetailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" id="msgDetailContent"></div>
  </div>
</div>
    @endsection

    @section('customScripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          $(document).on('click', '.read-btn', function() {
            var id = $(this).data('id');
            var self = $(this);
            var btntext = self.text();
            var type = self.data('type');
            self.html('...');
            var _token = '{{ csrf_token() }}';
            $.ajax({
              url: '{{ route("dashboard.markReadNotification") }}',
              type: 'POST',
              data: { id: id, _token: _token },
              success: function(response) {
                if(response.success) {      
                  if(type == 'unread') {
                    self.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                    self.closest('.notification-item').removeClass('unread');
                    self.text('Mark as unread');
                  } else {
                    self.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                    self.closest('.notification-item').addClass('unread');
                    self.text('Mark as read');
                  }
                }
              }
            });
          });

          $(document).on('click', '.view-msg', function() {
            var mid = $(this).attr('data-id');
            var notify_id = $(this).attr('data-notify-id');            
            var _this = $(this);
            var selfParent = $(this).parents('.notification-item');
            // var btnText = _this.text();
            $.ajax({
                url: "{{ route('dashboard.mymsgDetail') }}",
                type: 'POST',
                data: { id: mid, _token: '{{ csrf_token() }}', nid: notify_id },
                success: function(res) {
                    $('#msgDetailContent').html(res);
                    $('#msgDetailModal').modal('show');
                    // _this.text(btnText);
                    selfParent.find('.read-btn').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                    selfParent.removeClass('unread');
                    selfParent.find('.read-btn').text('Mark as unread');
                }
            });
        });
        </script>
    @endsection
