@extends('layouts.backend')
@section('title', 'Comments')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.css')}}">
@endsection
@section('content')
@php
$l_sort = $_GET['sort']??'desc';
@endphp
<div class="content">
    <div class="row">      
      <div class="col-md-12 col-xl-12">
        <!-- Message List -->
        <div class="block block-rounded">
          <div class="block-header block-header-default">
            <h3 class="block-title">
              {{$data->currentPage()}}-{{$data->lastPage()}} <span class="fw-normal text-lowercase">from</span> {{$data->total()}}
            </h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-toggle="tooltip" data-bs-placement="left" title="Previous 15 Messages">
                <i class="si si-arrow-left"></i>
              </button>
              <button type="button" class="btn-block-option" data-bs-toggle="tooltip" data-bs-placement="left" title="Next 15 Messages">
                <i class="si si-arrow-right"></i>
              </button>
              <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                <i class="si si-refresh"></i>
              </button>
              <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
          </div>
          <div class="block-content py-0"><!-- Messages and Checkable Table (.js-table-checkable class is initialized in Helpers.oneTableToolsCheckable()) -->
            <div class="pull-x">
              <table class="js-table-checkable table table-hover table-vcenter fs-sm">
                <thead>
                  <tr>
                    <td class="text-center">
                      <div class="form-check d-inline-block">
                        <input class="form-check-input" type="checkbox" value="" id="inbox-msg15" name="inbox-msg-all">
                        <label class="form-check-label" for="inbox-msg-all"></label>
                      </div>
                    </td>
                    <td colspan="4">
                      <!-- Messages Options -->
                      <div class="d-flex justify-content-between">
                        {{-- <div class="btn-group">
                          <button class="btn btn-sm btn-alt-secondary" type="button">
                            <i class="fa fa-archive text-primary"></i>
                            <span class="d-none d-sm-inline ms-1">Archive</span>
                          </button>
                          <button class="btn btn-sm btn-alt-secondary" type="button">
                            <i class="fa fa-star text-warning"></i>
                            <span class="d-none d-sm-inline ms-1">Star</span>
                          </button>
                        </div> --}}
                        <form action="{{route('deletAllComments')}}" method="POST" id="del_form" form="del_form">
                          {{csrf_field()}}
                            <button class="btn btn-sm btn-alt-secondary" type="button" id="deleteAll">
                              <i class="fa fa-times text-danger"></i>
                              <span class="d-none d-sm-inline ms-1">Delete</span>
                            </button>
                        </form>
                      </div>
                      <!-- END Messages Options -->
                    </td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $value)
                  <tr>
                    <td class="text-center" style="width: 60px;">
                      <div class="form-check d-inline-block">
                        <input class="form-check-input checkItem" type="checkbox" value="{{$value->id}}" id="row_{{$value->id}}" name="ids[]" required form="del_form">
                        <label class="form-check-label" for="row_{{$value->id}}"></label>
                      </div>
                    </td>                    
                    <td class="d-none d-sm-table-cell fw-semibold" style="width: 140px;">{{$value->name}} <br /> <small>{{$value->email}}</small></td>
                    <td>
                      <a class="fw-semibold text-success mt-1 open-this" data-name="{{$value->name}}" data-blog="{{$value->blog->title??''}}" data-email="{{$value->email}}" data-comment="{{$value->comment??''}}" data-created="{{$value->created_at->diffForHumans()}}" href="javascript:;"><strong>Blog: </strong>{{$value->blog->title??''}}</a> <br />
                      <small>{{Str::limit($value->comment, 96, '...')}}</small>
                    </td>
                    <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                      @if($value->is_active==1)
                      <a href="{{route('activeBlogComment', $value->id)}}" class="badge bg-success">Approved</a>
                      @else
                      <a href="{{route('activeBlogComment', $value->id)}}" class="badge bg-warning">Pending</a>
                      @endif
                    </td>
                    <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                      <em>{{$value->created_at->diffForHumans()}}</em>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- END Messages and Checkable Table -->
          </div>
        </div>
        <!-- END Message List -->
      </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModal" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content">
          <div class="block block-rounded block-transparent mb-0">
            <div class="block-header block-header-default">
              <h3 class="block-title" id="show-blog"></h3>
              <div class="block-options">                
                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa fa-fw fa-times"></i>
                </button>
              </div>
            </div>
            {{-- <div class="block-content block-content-full text-center bg-image" style="background-image: url('assets/media/photos/photo7.jpg');">
              <img class="img-avatar img-avatar96 img-avatar-thumb" src="assets/media/avatars/avatar4.jpg" alt="">
            </div> --}}
            <div class="block-content block-content-full fs-sm d-flex justify-content-between bg-body-light">
              <a href="javascript:void(0)" class="text-muted" id="show-name"></a>
              <a href="javascript:void(0)" id="show-email"></a>
              <span class="text-muted"><em id="show-created"></em></span>
            </div>
            <div class="block-content">
              <div class="form-group">
                <label for=""><b>Comment:</b></label>
                <p id="show-comment"></p>
              </div>
            </div>            
          </div>
        </div>
      </div>
    </div>
    <!-- END Message Modal -->
  </div>

@endsection
@section('customScripts')
<!-- Page JS Helpers (Table Tools helpers) -->
<script>One.helpersOnLoad(['one-table-tools-checkable', 'one-table-tools-sections']);</script>
<script src="{{asset('assets_backend/js/plugins/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
  $(document).on('click','#deleteAll',function(e){
      if($('.checkItem').is(':checked')){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $("#del_form").submit();            
          } else {
            console.log('Deletion canceled');
          }
        });          
      } 
      else {
        One.helpers('jq-notify', {type: 'warning', icon: 'fa fa-exclamation me-1', message: 'Select one or more item'});
      }
  });

  $('.open-this').click(function(){
    $("#show-blog").html($(this).data('blog'));
    $("#show-name").html($(this).data('name'));
    $("#show-comment").html($(this).data('comment'));
    $("#show-email").html($(this).data('email'));
    $("#show-created").html($(this).data('created'));
    $("#show-email").attr('href', 'mailto:'+$(this).data('email'));
    $("#emailModal").modal('show');
  });
</script>
@endsection