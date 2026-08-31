@extends('layouts.backend')
@section('title', 'Wallet Payments')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/select2/css/select2.min.css')}}">
<style>
.zoom-wrapper {
  width: 100%;
  height: 80vh;
  overflow: hidden;
  position: relative;
  cursor: grab;
}

.zoomable {
  transition: transform 0.3s ease;
  transform-origin: center center;
}

.zoomable.zoomed {
  transform: scale(2);
  cursor: grab;
}
</style>
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
            Wallet Payments
          </h1>
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Wallet Payments
            </li>
          </ol>
        </div>    
        <div class="flex-shrink-0 ms-3">
          <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#settingsModal">
            <i class="fa fa-cog"></i> Settings
          </a>
        </div>
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
        <h3 class="block-title">All Wallet Payments</h3>
        <div class="block-options">
          <div class="dropdown">
            <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Sort By <i class="fa fa-angle-down ms-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['sort' => 'desc']))}}">
                New
              </a>
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['sort' => 'asc']))}}">
                Old
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="block-content">
        <form action="{{request()->url()}}" method="GET">
          <div class="mb-4">
            <div class="row g-3">
              <div class="col-md-3">
                <select class="form-select form-select-sm" name="payment_method">
                  <option value="0">All Payment Types</option>
                  <option value="card" {{($_GET['payment_method']??'') == 'card' ? 'selected' : ''}}>Card</option>
                  <option value="bank" {{($_GET['payment_method']??'') == 'bank' ? 'selected' : ''}}>Bank</option>
                  <option value="orange" {{($_GET['payment_method']??'') == 'orange' ? 'selected' : ''}}>Orange</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-select form-select-sm" name="status">
                  <option value="">All Status</option>
                  <option value="completed" {{($_GET['status']??'') == 'completed' ? 'selected' : ''}}>Completed</option>
                  <option value="pending" {{($_GET['status']??'') == 'pending' ? 'selected' : ''}}>Pending</option>
                  <option value="failed" {{($_GET['status']??'') == 'failed' ? 'selected' : ''}}>Failed</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-select form-select-sm select2" name="user">
                  <option value="0">Search by User</option>
                  @foreach($users as $user)
                    <option value="{{$user->id}}" {{($_GET['user']??0) == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <input type="hidden" name="limit" value="{{$_GET['limit']??10}}">
                <input type="hidden" name="sort" value="{{$_GET['sort']??'desc'}}">
                <button class="btn btn-primary w-100" type="submit">
                  <i class="fa fa-search"></i> Filter
                </button>
              </div>
              <div class="col-md-1">
                <a href="{{request()->url()}}" class="btn btn-outline-secondary">
                  <i class="fa fa-times"></i> Clear
                </a>
              </div>
            </div>
          </div>
        </form>
        <!-- All Products Table -->
        <div class="table-responsive">
          <table class="js-table-checkable table table-hover table-vcenter">
            <thead>
              <tr>
                <th class="d-none d-md-table-cell">User</th>
                <th class="d-none d-md-table-cell">Amount</th>
                <th class="d-none d-md-table-cell">Payment Method</th>
                <th class="d-none d-md-table-cell">Payment Status</th>
                <th class="d-none d-sm-table-cell">Added</th>
                <th class="">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $k => $v)
              <tr data-id="{{$v->id}}" class="view-payment" title="View">
                <td class="fs-sm">{{$v->user->name}}</td>
                <td class="d-none d-md-table-cell fs-sm">{{number_format($v->amount, 2)}} {{baseSymbol()}}</td>
                <td class="d-none d-md-table-cell fs-sm">{{$v->payment_method}}</td>
                <td class="d-none d-md-table-cell fs-sm">
                    {!!$v->payment_status == 'pending' ? '<span class="badge bg-warning">Pending</span>' : '<span class="badge bg-success">Completed</span>'!!}</td>
                <td class="d-none d-sm-table-cell fs-sm">{{$v->created_at->format('d/m/Y')}}</td>
                <td class="fs-sm">
                  @if($v->payment_method != 'card' && $v->payment_method != '')
                  <a class="btn btn-sm btn-alt-secondary view-receipt" href="javascript:;" data-img="{{asset('uploads/wallet/'.$v->ref)}}" data-bs-toggle="tooltip" title="View">
                    <i class="fa fa-fw fa-eye"></i> View Receipt
                  </a>
                  @endif
                  @if($v->payment_status == 'pending')
                    <a class="btn btn-sm btn-alt-success approve-payment" href="javascript:;" data-id="{{$v->id}}" data-bs-toggle="tooltip" title="Approve">
                      <i class="fa fa-fw fa-eye"></i> Approve
                    </a>                    
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- END All Products Table -->

        <!-- Pagination Footer -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center pb-2">
            <span class="me-2">Show:</span>
            <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
              <option value="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['limit' => 10]))}}" {{($_GET['limit']??10) == 10 ? 'selected' : ''}}>10</option>
              <option value="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['limit' => 25]))}}" {{($_GET['limit']??10) == 25 ? 'selected' : ''}}>25</option>
              <option value="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['limit' => 50]))}}" {{($_GET['limit']??10) == 50 ? 'selected' : ''}}>50</option>
              <option value="{{request()->url().'?'.http_build_query(array_merge(request()->query(), ['limit' => 100]))}}" {{($_GET['limit']??10) == 100 ? 'selected' : ''}}>100</option>
            </select>
          </div>
          <div>
            {{$data->appends(request()->query())->links('pagination.custom')}}
          </div>
        </div>
      </div>
    </div>
    <!-- END All Products -->
</div>
<div id="receiptDetailModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" id="receiptDetailContent">
        <div class="zoom-wrapper">
          <img src="" alt="receipt" id="receiptImage" class="img-fluid zoomable">
        </div>
      </div>
    </div>
</div>
<form action="{{route('admin.approveWalletPayment')}}" method="POST" id="approvePaymentForm">
  {{csrf_field()}}
  <input type="hidden" name="id" id="approvePaymentId">
</form>

<div class="modal" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{route('admin.walletSettings')}}" method="POST">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Wallet Settings</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">

            <div class="row justify-content-center">
              <div class="col-md-12">                          
                <div class="mb-4">
                    <label class="form-label" for="meta_title">Bank Transfer Details</label>
                    <textarea class="js-maxlength form-control editor" id="bank_transfer_details" name="wallet_meta[bank_details]" rows="4" data-always-show="true" data-placement="top">{{$wallet_settings['bank_details']??''}}</textarea>
                  </div>
                <div class="mb-4">
                    <label class="form-label" for="orange_money_details">Orange Money Details</label>
                    <textarea class="js-maxlength form-control editor" id="orange_money_details" name="wallet_meta[orange_details]" rows="4" data-always-show="true" data-placement="top">{{$wallet_settings['orange_details']??''}}</textarea>
                  </div>
              </div>
            </div>
          </div>
          <div class="block-content block-content-full text-end bg-body">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary" style="width: 100%;">Save</button>
          </div>          
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('customScripts')
<!-- Page JS Helpers (Table Tools helpers) -->
<script>One.helpersOnLoad(['one-table-tools-checkable', 'one-table-tools-sections']);</script>
<script src="{{asset('assets_backend/js/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/zxhbf3x344fzo897fbfckxk8ntaz1ptnmemotgvsasf9e8ko/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  // $(document).on('click', '.view-receipt', function() {
  //   var _img = $(this).attr('data-img');
  //   $('#receiptImage').attr('src', _img);
  //   $('#receiptDetailModal').modal('show');
  // });
  $(document).on('click', '.approve-payment', function() {
    var _id = $(this).attr('data-id');
    $('#approvePaymentId').val(_id);
    $('#approvePaymentForm').submit();
  });
  tinymce.init({
        selector: '.editor',
        plugins: 'anchor autolink charmap emoticons link lists media searchreplace table visualblocks wordcount media linkchecker code textcolor lists',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | link table | align lineheight | numlist bullist indent outdent | removeformat | code',
        menubar: false,
        relative_urls: false,
        remove_script_host: false
    });
    $('.select2').select2({
        placeholder:'Search by User'
    });
</script>
<script>
  let isZoomed = false;
  let isDragging = false;
  let hasDragged = false;
  let startX, startY;
  let translateX = 0, translateY = 0;
  const scale = 2;
  
  $(document).on('click', '.view-receipt', function () {
    const img = $(this).data('img');
  
    $('#receiptImage')
      .attr('src', img)
      .removeClass('zoomed')
      .css('transform', 'translate(0,0) scale(1)');
  
    isZoomed = false;
    translateX = translateY = 0;
    $('#receiptDetailModal').modal('show');
  });
  
  // CLICK → ZOOM (only if no drag happened)
  $('#receiptImage').on('click', function () {
    if (hasDragged) {
      hasDragged = false;
      return;
    }
  
    isZoomed = !isZoomed;
  
    if (!isZoomed) {
      translateX = translateY = 0;
      this.style.transform = 'translate(0,0) scale(1)';
      this.classList.remove('zoomed');
    } else {
      this.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
      this.classList.add('zoomed');
    }
  });
  
  // MOUSE DOWN → START DRAG
  $('#receiptImage').on('mousedown', function (e) {
    if (!isZoomed) return;
  
    isDragging = true;
    hasDragged = false;
    startX = e.clientX - translateX;
    startY = e.clientY - translateY;
    this.style.cursor = 'grabbing';
    e.preventDefault();
  });
  
  // DRAG MOVE
  $(document).on('mousemove', function (e) {
    if (!isDragging) return;
  
    hasDragged = true;
    translateX = e.clientX - startX;
    translateY = e.clientY - startY;
  
    $('#receiptImage')[0].style.transform =
      `translate(${translateX}px, ${translateY}px) scale(${scale})`;
  });
  
  // MOUSE UP → END DRAG
  $(document).on('mouseup', function () {
    if (!isDragging) return;
  
    isDragging = false;
    $('#receiptImage').css('cursor', 'grab');
  });
  
  // RESET ON MODAL CLOSE
  $('#receiptDetailModal').on('hidden.bs.modal', function () {
    $('#receiptImage')
      .removeClass('zoomed')
      .css('transform', 'translate(0,0) scale(1)');
  
    isZoomed = false;
    translateX = translateY = 0;
  });
  </script>
@endsection
