@extends('layouts.backend')
@section('title', 'Advertise')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets_backend/css/bootstrap-tagsinput.css')}}" />
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/select2/css/select2.min.css')}}">
<style>
  .prom_a {
            font-size: 11px;
            font-weight: 600;
            color: #28a300;
            line-height: 15px;
        }
        .slider-nav{
            display: flex;
            width: 100%;
            overflow-y: hidden;
            overflow-x: scroll;
            height: 266px;
            background: #bfbfbf;
            align-items: flex-start;
            justify-content: flex-start;
        }
        /* width */
        .slider-nav::-webkit-scrollbar {
            height: 5px;
        }

        /* Track */
        .slider-nav::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey; 
        border-radius: 10px;
        }
        
        /* Handle */
        .slider-nav::-webkit-scrollbar-thumb {
        background: #424242 
        border-radius: 10px;
        }

        /* Handle on hover */
        .slider-nav::-webkit-scrollbar-thumb:hover {
        background:#6d6d6d; 
        }
        .slider-nav img{
            height: 250px;
            width: auto;
            margin: 5px 3px;
            object-fit: cover;
        }
        .uimg{
            width: 80px;
            border-radius: 50%;
            height: 80px;
            margin: 10px 0px 20px;
            object-fit: cover;
        }
        .table_border_type{
            border: solid 1px #ebebeb;
            padding: 6px 10px;
        }
        .allstatus{
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .allstatus button{
            margin-right: 3px;
        }
        .sweet-overlay{
            z-index: 1050;
        }
        .sbar select{
            width: 100%;
            height: 34px;
            border: none;
            padding: 0px 8px;
        }
        .img-thumbnail {
          width: 100px;
          height: 100px;
          object-fit: contain;
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
            Advertise
          </h1>
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Advertise
            </li>
          </ol>
        </div>
        <form action="{{route('advertises.delete')}}" method="POST" id="del_form" form="del_form">
            {{csrf_field()}}
            <button class="btn btn-outline-danger me-1 mb-3" type="button" id="deleteAll"> <i class="fas fa-trash-alt"></i> Delete </button>        
        </form>                
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
        <h3 class="block-title">All Ads</h3>
        <div class="block-options">
          <div class="dropdown">
            <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Sort By <i class="fa fa-angle-down ms-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=desc&limit='.($_GET['limit']??25)}}">
                New
              </a>
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=asc&limit='.($_GET['limit']??25)}}">
                Old
              </a>
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{request()->url().'?sort=title&limit='.($_GET['limit']??25)}}">
                Title / Name
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="block-content">
        <!-- Filters and Search Form -->
        <form action="{{request()->url()}}" method="GET">
          <div class="mb-4">
            <div class="row g-3">
              <div class="col-md-2">
                <select class="form-select form-select-sm" name="promo">
                  <option value="0">All Promotions</option>
                  @foreach($promotions as $promo)
                    <option value="{{$promo->id}}" {{($_GET['promo']??0) == $promo->id ? 'selected' : ''}}>{{$promo->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-select form-select-sm" name="status">
                  <option value="">All Status</option>
                  <option value="active" {{($_GET['status']??'') == 'active' ? 'selected' : ''}}>Active</option>
                  <option value="pending" {{($_GET['status']??'') == 'pending' ? 'selected' : ''}}>Pending</option>
                  <option value="expired" {{($_GET['status']??'') == 'expired' ? 'selected' : ''}}>Expired</option>
                  <option value="sold" {{($_GET['status']??'') == 'sold' ? 'selected' : ''}}>Sold</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-select form-select-sm select2" name="user">
                  <option value="0">Search by User</option>
                  @foreach($users as $user)
                    <option value="{{$user->id}}" {{($_GET['user']??0) == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" class="form-control form-control-alt" id="one-ecom-products-search" name="q" placeholder="Search all items.." value="{{$_GET['q']??''}}">
                  <input type="hidden" name="limit" value="{{$_GET['limit']??25}}">
                  <input type="hidden" name="sort" value="{{$_GET['sort']??'desc'}}">
                  <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </div>
              <div class="col-md-2">
                <a href="{{request()->url()}}" class="btn btn-outline-secondary">
                  <i class="fa fa-times"></i> Clear
                </a>
              </div>
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
                <th class="text-center" style="width: 100px;"></th>
                <th class="d-none d-md-table-cell">Name</th>
                <th class="d-none d-md-table-cell">Category</th>
                <th class="d-none d-md-table-cell">Price</th>
                {{-- <th class="d-none d-md-table-cell">Money Spent</th> --}}
                <th>Promotions</th>
                <th>Status</th>
                <th class="d-none d-sm-table-cell text-center">Chats</th>
                <th class="d-none d-sm-table-cell text-center">Created at</th>
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
                <td class="text-center fs-sm">
                  @php
                      $img = $v->gallery->first();
                      if($img == null){
                          $img = null;
                      }else{
                          $img = $img->image;
                      }
                  @endphp
                  @if ($img != null)
                      <img src="{{ asset('uploads/post/' . $img) }}" class="img-responsive img-thumbnail">
                  @else
                      <img src="{{ asset('placeholder.jpg') }}" class="img-responsive img-thumbnail">
                  @endif
                </td>
                <td class="d-none d-md-table-cell fs-sm">                  
                  <a href="javascript:void(0)" data-target="#advDetail{{$v->id}}" 
                      class="txtTitle open-modal"><b>{{ mb_strimwidth($v->title, 0, 40, '...') }}</b></a>
                  <br>
                  <b>
                      <a href="javascript:void(0)" class="open-modal" data-target="#adv_uDetail{{$v->id}}" style="color:#2c8bb9;">
                          Posted By: @if($v->user) {{ $v->user->name ?? $v->user->first_name}} @else user deleted @endif
                      </a>
                  </b>
                  {{-- @if($v->status == 'active' && $v->published == 1)
                    <a href="{{ url(optional($v->category)->getSlug(optional($v->category)->slug) . '/' . $v->slug) }}" class="badge bg-secondary" target="_blank"><i class="fa fa-eye"></i> view ad</a>        
                  @endif --}}
                </td>
                <td class="d-none d-md-table-cell fs-sm">{{ $v->category->name ?? 'Uncategorized' }}</td>
                <td class="d-none d-md-table-cell fs-sm">
                  @if ($v->payment_type == 'negotiable' || $v->payment_type == 'amount')
                      <b>{{ getCurrency()['symbol'] }} {{ number_format($v->price) }}</b>
                  @else
                      <b>Call Of Price</b>
                  @endif
                </td>
                <td class="d-none d-md-table-cell fs-sm">
                  @foreach ($v->promotions as $promo)
                      <div class="prom_a">{{ $promo->promo_name }}</div>
                  @endforeach
                </td>
                <td>
                    @if ($v->status == 'active')
                    <span class="badge bg-success">Active</span>                    
                    @elseif($v->status == 'pending')
                        <div class="badge bg-warning">Pending</div>
                    @elseif($v->status == 'expired')
                        <div class="badge bg-danger">Expired</div>
                    @elseif($v->status == 'sold')
                        <div class="badge bg-info">Sold</div>
                    @endif
                  </td>
                <td>
                  <div class="badge bg-info open-modal" data-target="#advOffer{{$v->id}}"><i class="fa fa-comment"></i> {{count($v->offers)}} </div>
                  <div class="badge bg-secondary open-modal" data-target="#advMessage{{$v->id}}"><i class="fa fa-envelope"></i> {{count($v->messages)}} </div>
                </td>
                <td class="d-none d-sm-table-cell text-center fs-sm">{{ date('dS M, Y', strtotime($v->created_at)) }}</td>
                <td class="text-center fs-sm">
                  <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled open-modal" href="javascript:;" data-target="#advDetail{{$v->id}}" data-bs-toggle="tooltip" aria-label="View" data-bs-original-title="View">
                    <i class="fa fa-fw fa-eye"></i>
                  </a>
                  <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('advertises.edit', $v->id) }}" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                    <i class="fa fa-fw fa-edit"></i>
                  </a>
                  <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled open-seo-modal" data-id="{{$v->id}}" href="javascript:;" data-bs-toggle="tooltip" aria-label="Manage SEO" data-bs-original-title="Manage SEO">
                    <span class="seo-text">SEO</span>
                    <span class="seo-loader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></span>
                  </a>                  
                </td>
              </tr>
              
              <div class="modal" id="advDetail{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="advDetail{{$v->id}}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                      <div class="block-header block-header-default">
                        <h3 class="block-title">             
                          {{ $v->title }} 
                          <br>
                          @if ($v->payment_type == 'amount')
                              <div class="text-success"> {{ formatPrice($v->price) }} </div>
                          @elseif($v->payment_type == 'negotiable')
                              <div class="text-success"> {{ formatPrice($v->price) }} <em>or</em> <small><a href="javascrip:void()" class="makeOffer">Make an Offer</a></small></div>
                          @else
                              <div class="text-success"><small><a href="javascrip:void()" class="makeOffer">Make an Offer</a></small></div>
                          @endif        
                        </h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content fs-sm">
              
                        <div class="allstatus">
                          <button class="btn-sm btn btn-success status_is_{{$v->id}}_active" onclick="statusChange('{{$v->id}}','active')"> <b> @if($v->status=='active') <i class="fa fa-check"></i>  @endif </b> Active </button>
                          <button class="btn-sm btn btn-warning status_is_{{$v->id}}_pending" onclick="statusChange('{{$v->id}}','pending')"> <b> @if($v->status=='pending') <i class="fa fa-check"></i> @endif </b> Pending </button>
                          {{-- <button class="btn-sm btn btn-danger status_is_{{$v->id}}_expired" onclick="statusChange('{{$v->id}}','expired')"> <b> @if($v->status=='expired') <i class="fa fa-check"></i> @endif </b> Expired </button> --}}
                          <button class="btn-sm btn btn-info status_is_{{$v->id}}_sold" onclick="statusChange('{{$v->id}}','sold')"> <b> @if($v->status=='sold') <i class="fa fa-check"></i> @endif </b> Sold </button>
                      </div>
                      <div class="slider-nav">
                          @foreach ($v->gallery as $img)
                              <div class="thumb-slide"><img
                                      src="{{ asset('uploads/post/' . $img->mobile_img ?? '#') }}"
                                      alt="{{ $v->name }}"></div>
                          @endforeach
                      </div>
                      <div class="pglist-p-com-ti ">
                          <h4 style="margin: 20px 0px 19px 0px;">General Details</h4>
                          <p>
                              {!! ($v->description)??null !!}
                          </p>
                      </div>
                      <div class="row">
                          <div class="col-sm-6 m-t-10">
                              <div class="list-pg-inn-sp">
                                  <div class=" pg-list-ser">
                                      <div class="row">
                                          <div class="col-sm-6 mb-2 table_border_type">
                                              <b> Country </b>: <span style="color:#1eaf38;">{{$v->country}}</span>
                                          </div>
                                          <div class="col-sm-6 mb-2 table_border_type">
                                              <b> State </b>: <span style="color:#1eaf38;">{{$v->state}}</span>
                                          </div>
                                          <div class="col-sm-6 mb-2 table_border_type">
                                              <b> City </b>: <span style="color:#1eaf38;">{{$v->city}}</span>
                                          </div>
                                          @if(isset($v->fields))
                                          @foreach($v->fields as $key => $val)
                                              <div class="col-sm-6 mb-2 table_border_type">
                                                  <b> {{$val['name']}} </b>: {{$val['value']}}
                                              </div>
                                          @endforeach
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <h4> Promotions </h4>
                              @php $i=1; @endphp
                              @foreach ($v->promotions->where('paid',1)->sortByDesc('created_at') as $promo)
                                  <div class="mb-2">
                                      <p> {{$i}}. <span style="color:#1eaf38;">{{$promo->days}} Days </span> {{$promo->promo_name}} promotion from {{date('dS M, Y', strtotime($promo->start_date))}} - {{date('dS M, Y', strtotime($promo->end_date))}}</p>
                                  </div>
                                  @php $i++; @endphp
                              @endforeach
                          </div>
                        </div>    
                      </div>                  
                    </div>
                  </div>
                </div>
              </div>


              
              <div class="modal" id="adv_uDetail{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="adv_uDetail{{$v->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                      <!-- <div class="block-header block-header-default">
                        <h3 class="block-title">Offer</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div> -->
                      <div class="block-content fs-sm">
                        <div class="row">
                          <div class="col-sm-12 m-t-10" style="text-align: center;">
                              <div style="padding:10px;border:solid 1px #ebebeb;padding-bottom: 40px;">
                                  <h4> User Detail </h4>
                                  @if($v->user)
                                  <img class="uimg" src="{{asset('uploads/profile/'.$v->user->image)}}" alt="">
                                  <div class="mb-2">
                                      <b> Name </b>: <span style="color:#1eaf38;">
                                        {{$v->user->name ?? $v->user->first_name}}                                        
                                      </span>
                                  </div>
                                  {{-- <div class="mb-2">
                                      <b> First Name </b>: <span style="color:#1eaf38;">{{$v->user->first_name}}</span>
                                  </div> --}}
                                  {{-- <div class="mb-2">
                                      <b> Last Name </b>: <span style="color:#1eaf38;">{{$v->user->last_name}}</span>
                                  </div> --}}
                                  <div class="mb-2">
                                      <b> Country </b>: <span style="color:#1eaf38;">{{$v->user->country}}</span>
                                  </div>
                                  <div class="mb-2">
                                      <b> State </b>: <span style="color:#1eaf38;">{{$v->user->state}}</span>
                                  </div>
                                  <div class="mb-2">
                                      <b> City </b>: <span style="color:#1eaf38;">{{$v->user->city}}</span>
                                  </div>
                                  @else
                                  <div class="mb-2">
                                      <b> User has been deleted</b></span>
                                  </div>
                                  @endif
                              </div>
                          </div>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal" id="advOffer{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="advOffer{{$v->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                      <div class="block-header block-header-default">
                        <h3 class="block-title">Offer</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content fs-sm">
                      <div class="row">
                            <div class="col-sm-12">
                                @php $i=1; @endphp
                                @foreach ($v->offers as $ofer)
                                    <div class="mb-2">
                                        <p> {{$i}}. <span style="color:#1eaf38;">{{$ofer->phone}} offers </span> <br> {!! $ofer->msg !!}</p>
                                    </div>
                                    @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal" id="advMessage{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="advMessage{{$v->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                      <div class="block-header block-header-default">
                        <h3 class="block-title">Offer</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content fs-sm">
                        <div class="row">
                          <div class="col-sm-12">
                              @php $i=1; @endphp
                              @foreach ($v->messages as $ofer)
                                  <div class="mb-2">
                                      <p> {{$i}}. <span style="color:#1eaf38;">{{$ofer->name}} ({{$ofer->phone}} - {{$ofer->email}}) </span> <br> {!! $ofer->msg !!}</p>
                                  </div>
                                  @php $i++; @endphp
                              @endforeach
                          </div>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </div>
              </div>
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
              <option value="{{request()->url().'?sort='.($_GET['sort']??'desc').'&limit=25'}}" {{($_GET['limit']??25) == 25 ? 'selected' : ''}}>25</option>
              <option value="{{request()->url().'?sort='.($_GET['sort']??'desc').'&limit=50'}}" {{($_GET['limit']??25) == 50 ? 'selected' : ''}}>50</option>
              <option value="{{request()->url().'?sort='.($_GET['sort']??'desc').'&limit=100'}}" {{($_GET['limit']??25) == 100 ? 'selected' : ''}}>100</option>
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

<!-- SEO Modal -->
<div class="modal" id="seoModal" tabindex="-1" role="dialog" aria-labelledby="seoModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="block block-rounded block-transparent mb-0">
        <div class="block-header block-header-default">
          <h3 class="block-title" id="seoModalTitle">Manage SEO - <span id="adTitle"></span></h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content fs-sm" id="seoFormDiv" style="max-height: 90vh; overflow-y: auto;">
          <!-- SEO form will be loaded here -->
        </div>                  
      </div>
    </div>
  </div>
</div>
<!-- End SEO Modal -->
@endsection
@section('customScripts')
<!-- Page JS Helpers (Table Tools helpers) -->
<script>One.helpersOnLoad(['one-table-tools-checkable', 'one-table-tools-sections']);</script>
<script src="{{asset('assets_backend/js/plugins/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets_backend/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets_backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{asset('assets_backend/js/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $('.select2').select2({ 
    placeholder:'Search by User'
  });
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
  $(".open-modal").click(function(){
    $($(this).data('target')).modal('show');
  });

  $('.image-placeholder').filemanager('image');

  // SEO Modal functionality
  $(".open-seo-modal").click(function(){
    var adId = $(this).data('id');
    var $btn = $(this);
    var $seoText = $btn.find('.seo-text');
    var $seoLoader = $btn.find('.seo-loader');
    
    // Show loader
    $seoText.hide();
    $seoLoader.show();
    
    loadSeoData(adId, $btn);
  });

  function loadSeoData(adId, $btn) {
    $.ajax({
      url: '/admin/advertises/' + adId + '/seo',
      type: 'GET',
      success: function(response) {
        if (response.success) {
          // Load the HTML into the modal
          $('#seoFormDiv').html(response.html);
          
          // Set modal title
          $('#adTitle').text(response.adTitle);
          
          // Set form action
          $('#seoForm').attr('action', '/admin/advertises/' + adId + '/seo');
          
          // Set advertise ID
          $('#advertise_id').val(adId);
          
          // Initialize file manager
          $('.image-placeholder').filemanager('image');
          
          // Clear any existing success/error messages
          $('#seoSuccessMessage').remove();
          
          // Show modal
          $('#seoModal').modal('show');
        }
      },
      error: function() {
        One.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: 'Error loading SEO data'});
      },
      complete: function() {
        // Hide loader
        var $seoText = $btn.find('.seo-text');
        var $seoLoader = $btn.find('.seo-loader');
        $seoText.show();
        $seoLoader.hide();
      }
    });
  }

  // Handle SEO switches
  $(document).on('change', '.seo-switch', function() {
    var type = $(this).data('type');
    var isChecked = $(this).is(':checked');
    
    if (type === 'og_tag') {
      $('#og_tag_div').toggle(isChecked);
    } else if (type === 'twitter_tag') {
      $('#twitter_tag_div').toggle(isChecked);
    } else if (type === 'schema') {
      $('#schema_div').toggle(isChecked);
    } else if (type === 'tags') {
      $('#tags_div').toggle(isChecked);
    } else if (type === 'canonicals') {
      $('#canonicals_div').toggle(isChecked);
    }
  });

  // Handle canonical add/remove
  $(document).on('click', '.add-canonical', function() {
    var canonicalCount = $('.link-can div').length;
    var newCanonical = '<div style="position:relative;margin-top:5px;">' +
      '<input type="text" class="form-control" name="seo_meta[canonical][]" id="canonical_' + canonicalCount + '" value="">' +
      '<button type="button" class="btn btn-xs btn-danger remove-canonical" style="position:absolute;top:0px;right:5px;"><i class="fa fa-times"></i></button>' +
      '</div>';
    $('.link-can').append(newCanonical);
  });

  $(document).on('click', '.remove-canonical', function() {
    $(this).parent().remove();
  });

  // Handle SEO form submission
  $(document).on('submit', '#seoForm', function(e) {
    e.preventDefault();
    
    // Show loading state on submit button
    var $submitBtn = $(this).find('button[type="submit"]');
    var originalText = $submitBtn.html();
    $submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    
    // Remove any existing success message
    $('#seoSuccessMessage').remove();
    
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
              success: function(response) {
          if (response.success) {
            // Add success message at the bottom of the modal
            var successHtml = '<div id="seoSuccessMessage" class="alert alert-success mt-3 mb-0">' +
              '<i class="fa fa-check me-1"></i>' + response.message +
              '</div>';
            $('#seoForm').after(successHtml);
            
            // Scroll to the success message
            $('#seoFormDiv').scrollTop($('#seoFormDiv')[0].scrollHeight);
          }
        },
      error: function() {
        // Add error message at the bottom of the modal
        var errorHtml = '<div id="seoSuccessMessage" class="alert alert-danger mt-3 mb-0">' +
          '<i class="fa fa-times me-1"></i> Error updating SEO data' +
          '</div>';
        $('#seoForm').after(errorHtml);
      },
      complete: function() {
        // Restore submit button
        $submitBtn.html(originalText).prop('disabled', false);
      }
    });
  });
//   $('.view-user').click(function(){

//     $("#viewModal").modal('show');
//   });
</script>
<script>
  function statusChange(id, status){
      if(status == 'active'){
          var text = 'You want to active this ad';
          var type = 'success';
          var confirmButtonClass = 'btn-success btn-md waves-effect waves-light';
          var confirmButtonText = 'Active!';
          var td = '<div class="badge badge-success">Active</div>'; 
      }else if(status == 'pending'){
          var text = 'You want to change this ad status to pending';
          var type = 'warning';
          var confirmButtonClass = 'btn-warning btn-md waves-effect waves-light';
          var confirmButtonText = 'Pending!';
          var td = '<div class="badge badge-warning">Pending</div>'; 
      }else if(status == 'expired'){
          var text = 'You want to expire this ad';
          var type = 'error';
          var confirmButtonClass = 'btn-danger btn-md waves-effect waves-light';
          var confirmButtonText = 'Expired!';
          var td = '<div class="badge badge-danger">Expired</div>'; 
      }else if(status == 'sold'){
          var text = 'You wantt to change this ad status to sold';
          var type = 'info';
          var confirmButtonClass = 'btn-info btn-md waves-effect waves-light';
          var confirmButtonText = 'Info!';
          var td = '<div class="badge badge-info">Sold</div>'; 
      }

      Swal.fire({
          title: 'Are you sure?',
          text: text,
          type: type,
          showCancelButton: true,
          confirmButtonClass: confirmButtonClass,
          confirmButtonText: confirmButtonText,
        }).then((result) => {
          if (result.isConfirmed) {
            var data = { '_token': "{{ csrf_token() }}", 'id': id, 'status': status };
            $.ajax({
                url: '{{ route("advertises.status") }}',
                type: 'POST',
                data: data,
                success: function(res) {
                  location.reload();
                    // $('.allstatus button').find('b').html('');
                    // $('.status_is_'+id+'_'+status).find('b').html('<i class="fa fa-check"></i>');
                    // $('.status_'+id).html(td)

                }
            });
          } else {
            console.log('canceled');
          }
        }); 
  }
</script>
@endsection