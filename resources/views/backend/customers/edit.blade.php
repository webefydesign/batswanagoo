@extends('layouts.backend')
@section('title', 'Edit Customer')
@section('customStyles')

<style>
    .light-fields {
        background: transparent;
        border: 2px solid #cecece;
        padding: 11px;
        border-radius: 12px;
    }
    .slug-field {
        position: relative;
    }
    .slug-field a {
        position: absolute;
        top: 11px;
        right: 17px;
    }
    .select2-container--default .select2-selection--single{
        background: transparent;
        border: 2px solid #cecece;
        padding: 7px;
        border-radius: 12px;
        height: 50px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px;
    }
</style>
@endsection
@section('content')
<form action="{{route('customers.update', $data['id'])}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Customers
              </h1>
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('customers.index')}}">Customers</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  Edit
                </li>
              </ol>
            </div>
            <button type="submit" class="btn btn-outline-success me-1 mb-3">
                <i class="fa fa-fw fa-save me-1"></i> Save
            </button>
          </div>
          <hr>
                {{-- Display error messages --}}
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <label for="">First Name</label>
                    <input type="text" name="first_name" class="form-control light-fields" placeholder="First Name" required value="{{ $data['first_name']??$data['name'] }}">
                    @csrf
                </div>            
                <div class="col-md-3">
                    <label for="">Last Name</label>
                    <input type="text" name="last_name" class="form-control light-fields" placeholder="Last Name" value="{{ $data['last_name']??'' }}">
                </div>            
                <div class="col-md-3">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control light-fields" placeholder="Email" required value="{{ old('email', $data->email) }}">
                </div>
                <div class="col-md-3">
                    <label for="">Phone</label>
                    <input type="text" name="phone" class="form-control light-fields" placeholder="Phone" value="{{ ($data['phone'])??'' }}">
                </div>            
            </div>
            <div class="form-group">
                <label for="state">Location <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select fetchStates" name="state" id="state" data-location="city" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->name }}" @if($data->state == $state->name) selected @endif>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="city" class="form-select citySelect" id="city" required>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->name }}" @if($data->city == $city->name) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="">Business Name</label>
                    <input type="text" name="name" class="form-control light-fields" placeholder="Business Name" value="{{ ($data['name'])??'' }}">
                </div>            
                <div class="col-md-3">
                    <label for="">Date of Birth</label>
                    <input type="date" name="dob" class="form-control light-fields" placeholder="DOB" value="{{ ($data['dob'])??'' }}">
                </div>            
                <div class="col-md-3">
                    <label for="">Website</label>
                    <input type="text" name="website" class="form-control light-fields" placeholder="Website" value="{{ ($data['website'])??'' }}">
                </div>
                <div class="col-md-3">
                    <label for="">Gender</label>
                    <select class="form-select" name="gender">
                        <option value="male" @if($data['gender'] == 'male') selected @endif>Male</option>
                        <option value="female" @if($data['gender'] == 'female') selected @endif>Female</option>
                    </select>
                </div>            
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                {{-- <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Details</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="image" class="form-control input-sm" type="text" name="image" value="{{ ($data['image'])??'' }}">
                                </div>
                            </div>
                            <div class="col-md-6 form-group pb-2">
                                <label>Description</label>
                                <textarea name="description" class="form-control editor light-fields">{{ ($data['description'])??'' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</form>
@endsection
@section('customScripts')


@endsection
