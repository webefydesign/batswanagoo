@extends('layouts.backend')
@section('title', 'Create Field')
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
    #commaOptionsContainer {
      position: relative;
    }   
    #commaOptionsContainer a#addOptions {
      position: absolute;
      bottom: 3px;
      right: 9px;
      font-size: 9px;
      font-weight: normal;
      padding: 2px;
  }
  .option-row {
      position: relative;
  }
  .option-row .handle {
      position: absolute;
      top: 9px;
      left: -3px;
      color: #24a1b4;
      cursor: move;
  }
</style>
@endsection
@section('content')
<form action="{{route('fields.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Fields
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('fields.index')}}">Fields</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  Create 
                </li>
              </ol>
            </div>
            <button type="submit" class="btn btn-outline-success me-1 mb-3">
                <i class="fa fa-fw fa-save me-1"></i> Save
            </button>        
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
                <label for="">Field Name</label>
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Name" required>
                @csrf
            </div>   
            <div class="col-md-4">
              <label for="">Field Placeholder</label>
              <input type="text" name="placeholder" class="form-control light-fields" placeholder="Placeholder">
              @csrf
          </div>         
            <div class="col-md-4">
              <label for="">Field Type</label>
                <select name="type" class="form-select light-fields" id="fieldType">
                  <option value="text"> Text (Single Line)</option>
                  <option value="textarea"> Textarea (Multi Line)</option>
                  <option value="number"> Number (Numeric)</option>
                  <option value="date"> Date (Date Picker)</option>
                  <option value="select"> Select / Drop Down (Single Select)</option>
                  <option value="checkbox"> Checkbox (Yes/No)</option>
                  <option value="multiselect"> Multi Select (Multiple Select)</option>
                </select>
            </div>

        </div>
        </div>
    </div>
    
    <div class="content field-data" id="data-select" style="display:none;">
      <div class="block block-rounded mt-3">
          <div class="block-header block-header-default">
            <h3 class="block-title text-center">Options Data</h3>
          </div>
          <div class="block-content">
            <div class="row pb-3">
              <div class="col-md-6 offset-3">
                <a href="javascript:;" class="btn btn-link mt-2" id="toggleCommaContainer">Add options separated by comma</a>
                <div id="commaOptionsContainer" style="display:none;">
                  <textarea class="form-control" id="commaOptions" placeholder="Comma separated values"></textarea>
                  <a href="javascript:;" id="addOptions" class="btn btn-sm btn-info mt-2">Add Options to the list <i class="fa fa-arrow-down"></i></a>
                </div>
                <hr>                
                <div id="optionList"></div>
                <a href="javascript:;" id="addOption" class="btn btn-sm btn-success mt-2">Add Option <i class="fa fa-arrow-up"></i></a>
              </div>              
            </div>            
          </div>
      </div>
    </div>
    
    <div class="content field-data" id="data-checkbox" style="display:none;">
      <div class="block block-rounded mt-3">
          <div class="block-header block-header-default">
            <h3 class="block-title text-center">Checkbox Value</h3>
          </div>
          <div class="block-content">
            <div class="row pb-3">
              <div class="col-md-6 offset-3">
                <div class="form-group">
                    <input type="text" name="data[check_value]" class="form-control checkbox-field" placeholder="Enter the checkbox value" disabled>
                </div>                
              </div>              
            </div>            
          </div>
      </div>
    </div>
</form>
@endsection
@section('customScripts')
<script>
    $("#fieldType").change(function() {
      $(".field-data").hide();
      if($(this).val() == 'multiselect'){
        $("#data-select").show();
      } else {
        $("#data-"+$(this).val()).show();
      }
      if($(this).val() == 'checkbox'){
        $(".checkbox-field").attr('disabled', false);
      }else{
        $(".checkbox-field").attr('disabled', true);
      }
    });

    $(document).on('click', "#toggleCommaContainer", function(){
      $("#commaOptionsContainer").toggle('slide');
    });

    $(document).on('click', "#addOptions", function(){
      var options = $("#commaOptions").val();
      var optionsArray = options.split(',');
      for(var i = 0; i < optionsArray.length; i++){
        $("#optionList").append(`<div class="row option-row pb-2">
          <div class="form-group col-md-10">
            <span class="handle"><i class="fa fa-arrows-v"></i></span>
            <input type="text" class="form-control" name="data[options][]" placeholder="Option" required value="${optionsArray[i]}">
          </div>
          <div class="form-group col-md-2">
            <a href="javascript:;" class="btn btn-danger remove-option"><i class="fa fa-trash"></i></a>
          </div>
        </div>`);
      }
      $("#commaOptions").val('');
    });

    $("#addOption").click(function(){
      $("#optionList").append(`<div class="row option-row pb-2">
                  <div class="form-group col-md-10">
                    <span class="handle"><i class="fa fa-arrows-v"></i></span>
                      <input type="text" class="form-control" name="data[options][]" placeholder="Option" required>
                  </div>
                  <div class="form-group col-md-2">
                      <a href="javascript:;" class="btn btn-danger remove-option"><i class="fa fa-trash"></i></a>
                  </div>
                </div>`);
    });
    $(document).on('click', ".remove-option", function(){
      $(this).parent().parent().remove();
    });
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $("#optionList").sortable({
        handle: ".handle",
        axis: 'y'
    });
</script>
@endsection