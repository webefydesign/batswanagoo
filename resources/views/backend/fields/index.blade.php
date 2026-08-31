@extends('layouts.backend')
@section('title', 'Fields')
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
            Fields
          </h1>
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Fields
            </li>
          </ol>
        </div>
        <form action="{{route('fields.delete')}}" method="POST" id="del_form" form="del_form">
            {{csrf_field()}}
            <button class="btn btn-outline-danger me-1 mb-3" type="button" id="deleteAll"> <i class="fas fa-trash-alt"></i> Delete </button>        
        </form>
        <a href="{{route('fields.create')}}" class="btn btn-outline-success me-1 mb-3">
            <i class="fa fa-fw fa-plus me-1"></i> Add New
        </a>        
      </div>
    </div>
</div>
<div class="content">
  <div class="row">
    <div class="col-6 col-lg-3">
      <a class="block block-rounded block-link-shadow text-center" href="{{route('make.index')}}">
        <div class="block-content block-content-full">
          <div class="fs-2 fw-semibold text-dark">{{$makes}}</div>
        </div>
        <div class="block-content py-2 bg-body-light">
          <p class="fw-medium fs-sm text-muted mb-0">
            Makes
          </p>
        </div>
      </a>
    </div>
    <div class="col-6 col-lg-3">
      <a class="block block-rounded block-link-shadow text-center" href="{{route('models.index')}}">
        <div class="block-content block-content-full">
          <div class="fs-2 fw-semibold text-dark">{{$models}}</div>
        </div>
        <div class="block-content py-2 bg-body-light">
          <p class="fw-medium fs-sm text-muted mb-0">
            Models
          </p>
        </div>
      </a>
    </div>    
    <div class="col-6 col-lg-3">
      <a class="block block-rounded block-link-shadow text-center" href="{{route('brands.index')}}">
        <div class="block-content block-content-full">
          <div class="fs-2 fw-semibold text-dark">{{$brands}}</div>
        </div>
        <div class="block-content py-2 bg-body-light">
          <p class="fw-medium fs-sm text-muted mb-0">
            Brands
          </p>
        </div>
      </a>
    </div>    
    <div class="col-6 col-lg-3">
      <a class="block block-rounded block-link-shadow text-center" href="{{route('body-types.index')}}">
        <div class="block-content block-content-full">
          <div class="fs-2 fw-semibold text-dark">{{$body_types}}</div>
        </div>
        <div class="block-content py-2 bg-body-light">
          <p class="fw-medium fs-sm text-muted mb-0">
            Vehicle Body Types
          </p>
        </div>
      </a>
    </div>    
  </div>  
  @if(Session::has('success'))
    <div class="alert alert-success alert-icon">
        <em class="icon ni ni-check-circle"></em> <strong>{{Session::get('success')}}</strong>
    </div>
    @endif
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">All Other Fields</h3>
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
                <th class="d-none d-md-table-cell">Title</th>
                <th class="d-none d-md-table-cell">Data</th>
                {{-- <th class="d-none d-sm-table-cell text-center">Added</th> --}}
                <th class="d-none d-sm-table-cell text-center">Last Updated</th>
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
                <td class="d-none d-md-table-cell fs-sm">{{$v->name}}</td>
                <td class="d-none d-md-table-cell fs-sm" style="word-break:break-word;width: 30%;">
                  @if($v->type=='select' || $v->type=='multiselect')
                      {{ is_array($v->data['options'] ?? '') 
                          ? implode(', ', $v->data['options']) 
                          : str_replace(',', ', ', $v->data['options'] ?? '') }}
                  @elseif($v->type=='checkbox')
                      {{ $v->data['data[check_value]'] ?? '' }}
                  @endif
                </td>
                {{-- <td class="d-none d-sm-table-cell text-center fs-sm">{{$v->created_at->format('d/m/Y')}}</td> --}}
                <td class="d-none d-sm-table-cell text-center fs-sm">{{$v->updated_at->format('d/m/Y')}}</td>
                <td>
                  @if($v->is_active==1)
                  <span class="badge bg-success">Published</span>
                  @else
                  <span class="badge bg-warning">Draft</span>
                  @endif
                </td>                
                <td class="text-center fs-sm">
                  <a class="btn btn-sm btn-alt-secondary" href="{{route('fields.status', $v->id)}}" data-bs-toggle="tooltip" title="{{($v->is_active==1)?'Un-publish':'Publish'}}">
                    <i class="fa fa-fw {{($v->is_active==1)?'fa-eye-slash':'fa-eye'}}"></i>
                  </a>
                  <a class="btn btn-sm btn-alt-secondary" href="{{route('fields.edit', $v->id)}}" data-bs-toggle="tooltip" title="Edit">
                    <i class="fa fa-fw fa-pencil"></i>
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
</script>
@endsection