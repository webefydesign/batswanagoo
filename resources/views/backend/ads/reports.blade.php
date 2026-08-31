@extends('layouts.backend')
@section('title', 'Reports')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.css')}}">
@endsection
@section('content')
@php
$l_sort = $_GET['sort']??'desc';
@endphp
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Reports
          </h1>
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Reports
            </li>
          </ol>
        </div>
        <form action="{{route('clients.delete')}}" method="POST" id="del_form" form="del_form">
            {{csrf_field()}}
            <button class="btn btn-outline-danger me-1 mb-3" type="button" id="deleteAll"> <i class="fas fa-trash-alt"></i> Delete </button>        
        </form>
        {{-- <a href="javascript:;" class="btn btn-outline-success me-1 mb-3"  data-bs-toggle="modal" data-bs-target="#addNewModal">
            <i class="fa fa-fw fa-plus me-1"></i> Add New
        </a>         --}}
      </div>
    </div>
</div>
  <div class="content">  
    @if(Session::has('success'))
      <div class="alert alert-success alert-icon">
          <em class="icon ni ni-check-circle"></em> <strong>{{Session::get('success')}}</strong>
      </div>
    @endif
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">All Reports</h3>
        <div class="block-options">
          <div class="dropdown">
            <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Sort By <i class="fa fa-angle-down ms-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=desc&limit='.$data->perPage()}}">
                New
              </a>
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=desc&limit='.$data->perPage()}}">
                Old
              </a>
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=title&limit='.$data->perPage()}}">
                Title / Name
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="block-content">
        <!-- Search Form -->
        <form action="{{request()->url()}}">
          <div class="mb-4">
            <div class="input-group">
              <input type="text" class="form-control form-control-alt" id="one-ecom-products-search" name="q" placeholder="Search all items.." value="{{$_GET['q']??''}}">
              <span class="input-group-text bg-body border-0">
                <i class="fa fa-search"></i>
              </span>
            </div>
          </div>
        </form>
        <!-- END Search Form -->

        <!-- All Products Table -->
        <div class="table-responsive">
          <table class="js-table-checkable table table-hover table-vcenter">
            <thead>
              <tr>
                <th class="text-center" style="width: 70px;">
                  <div class="form-check d-inline-block">
                    <input class="form-check-input" type="checkbox" value="" id="check-all" name="check-all">
                    <label class="form-check-label" for="check-all"></label>
                  </div>
                </th>
                <th class="d-none d-md-table-cell">Product Name</th>
                <th class="d-none d-md-table-cell">Report</th>
                <th class="d-none d-md-table-cell">Unavailable</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $k => $v)
              <tr>
                <td class="text-center">
                  <div class="form-check d-inline-block">
                    <input class="form-check-input checkItem" type="checkbox" value="{{$v->id}}" id="row_{{$v->id}}" name="ids[]" required form="del_form">
                    <label class="form-check-label" for="row_{{$v->id}}"></label>
                  </div>
                </td>
                <td class="d-none d-md-table-cell fs-sm">{{$v->title}}</td>
                <td class="d-none d-md-table-cell fs-sm">{{ $v->reports->count() }}</td>
                <td class="d-none d-md-table-cell fs-sm">{{ $v->unavailables->count() }}</td>
                <td>
                  @if($v->status == 1)
                    <button type="button" class="btn btn-sm btn-alt-danger status_s" onclick="statusChange('{{$v->id}}', 0)">In-Active This Ad</button>
                  @else
                    <button type="button" class="btn btn-sm btn-alt-success status_s" onclick="statusChange('{{$v->id}}', 1)">Active This Ad</button>
                  @endif
                </td>          
                <td class="text-center fs-sm">
                  <a href="javascript:;" class="btn btn-sm btn-alt-secondary"  data-bs-toggle="modal" data-bs-target="#myModal{{ $v->id}}">
                    <i class="fa fa-fw fa-eye"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- END All Products Table -->

        <!-- Pagination -->
        {{$data->links('pagination.custom')}}        
      </div>
    </div>
    <!-- END All Products -->
  </div>

  @foreach ($data as $key => $value)
    <div class="modal" id="myModal{{ $value->id}}" tabindex="-1" role="dialog" aria-labelledby="myModal{{ $value->id}}" aria-hidden="true">
      <div class="modal-dialog" role="document" style="min-width: 80%;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
              Report / Unavalibale 
            </h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-1">Report </h4>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reason</th>
                            <th>Description</th>
                            <th>Created at</th>
                        </tr>

                        @foreach($value->reports as $report)
                        <tr>
                            <td>{{ $report->user->name }}</td>
                            <td>{{ $report->user->email }}</td>
                            <td>{{ ($report->reason_type)??'-' }}</td>
                            <td>{{ ($report->reason_desc)??'-' }}</td>
                            <td>{{date('dS M, Y', strtotime($report->created_at))}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-sm-6">
                    <h4 class="mb-1">Unavalibale</h4>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reason</th>
                            <th>Description</th>
                            <th>Created at</th>
                        </tr>

                        @foreach($value->unavailables as $unavalibale)
                        <tr>
                            <td>{{ $unavalibale->user->name }}</td>
                            <td>{{ $unavalibale->user->email }}</td>
                            <td>{{ ($unavalibale->reason_type)??'-' }}</td>
                            <td>{{ ($unavalibale->reason_desc)??'-' }}</td>
                            <td>{{date('dS M, Y', strtotime($unavalibale->created_at))}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection
@section('customScripts')
<!-- Page JS Helpers (Table Tools helpers) -->
<script>One.helpersOnLoad(['one-table-tools-checkable', 'one-table-tools-sections']);</script>
<script src="{{asset('assets_backend/js/plugins/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
  $('.image-placeholder').filemanager('image');
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
  $('.edit-client').click(function(){
    $("#editForm").attr('action', $(this).data('url'));
    $("#editImg").val($(this).data('image'));
    $("#edit-title").val($(this).data('title'));
    $("#editTitle").text($(this).data('title'));
    $("#edit-order").val($(this).data('order'));
    $("#edit-link").val($(this).data('link'));
    $("#editModal").modal('show');
  });
  function statusChange(id, status){
    if(status == 1){
        var text = 'You want to active this ad';
        var type = 'success';
        var confirmButtonClass = '#139a52';
        var confirmButtonText = 'Active!';
        var td = '<div class="badge badge-success">Active</div>'; 
    }else if(status == 0){
        var text = 'You want to change this ad status to pending';
        var type = 'warning';
        var confirmButtonClass = '#ea580c';
        var confirmButtonText = 'Pending!';
        var td = '<div class="badge badge-warning">Pending</div>'; 
    }else if(status == 'expired'){
        var text = 'You want to expire this ad';
        var type = 'error';
        var confirmButtonClass = '#d61f47';
        var confirmButtonText = 'Expired!';
        var td = '<div class="badge badge-danger">Expired</div>'; 
    }else if(status == 'sold'){
        var text = 'You wantt to change this ad status to sold';
        var type = 'info';
        var confirmButtonClass = '#1391aa';
        var confirmButtonText = 'Info!';
        var td = '<div class="badge badge-info">Sold</div>'; 
    }

    Swal.fire({
      title: 'Are you sure?',
      text: text,
      icon: type,
      showCancelButton: true,
      confirmButtonColor: confirmButtonClass,
      cancelButtonColor: '#d33',
      confirmButtonText: confirmButtonText,
    }).then((result) => {
      if (result.isConfirmed) {
        var data = { '_token': "{{ csrf_token() }}", 'id': id, 'status': status };
        $.ajax({
            url: '{{ url('admin/advertises-status') }}',
            type: 'POST',
            data: data,
            success: function(res) {
                location.reload();
            }
        });     
      } else {
      }
    });
  }
</script>
@endsection