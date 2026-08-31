@extends('layouts.backend')
@section('title', 'Create Currency')
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
</style>
@endsection
@section('content')
<form action="{{route('currencies.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Currencies
              </h1>
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('currencies.index')}}">Currencies</a>
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

            <div class="form-group col-md-4 mb-2">
                <label for="">Code</label>
                <select class="form-control light-fields" name="code" required>
                    <option selected disabled style="display:none">Select Any</option>
                    @if(isset($countries))
                        @foreach($countries as $k => $country)
                            <option value="{{ $country->id }}" @if($k === 0) selected @endif>{{ $country->name }} <small>({{ $country->iso2 }})</small></option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Display Name</label>
                <input type="text" name="name" class="form-control light-fields" placeholder="Display Name" required onkeyup="document.getElementById('cName').innerHTML = this.value;">
                @csrf
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Exchange Rate</label>
                <input type="number" class="form-control light-fields" id="exRate" step="0.00001" name="rate" required="">
                <div class="form-group">
                    1 <span id="cName"></span> is equals to <b id="exDisplay">1</b> {{$default['code'] ?? ''}}
                </div>
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Symbol</label>
                <input type="text" class="form-control light-fields display_input" name="symbol" required="">
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Symbol placement</label>
                <select class="form-control light-fields display_select" name="symbol_place" required="">
                    <option value="left" selected>Left</option>
                    <option value="right">Right</option>
                </select>
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Decimal token</label>
                <input type="text" class="form-control light-fields display_input" name="decimal_token" required="">
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Thousand token</label>
                <input type="text" class="form-control light-fields display_input" name="thousand_token" required="">
            </div>

            <div class="form-group col-md-4 mb-2">
                <label for="">Decimal places</label>
                <select class="form-control light-fields display_select" name="decimal_places">
                    <option value="0" selected="">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="col-md-4 ">
                <div class="form-group" id="displayPrice" style="text-align: center;padding-top: 35px;"><h3>${{number_format(123456,0,'.',',')}}</h3></div>
            </div>

        </div>
        </div>
    </div>
</form>
@endsection
@section('customScripts')
<script>

    $(".display_select").change(function(){
        symbol = $("input[name='symbol']").val();
        if($("select[name='symbol_place']").val()=='right') {
            $("#displayPrice").html("<h3>"+number_format()+symbol+"</h3>");
        } else {
            $("#displayPrice").html("<h3>"+symbol+number_format()+"</h3>");
        }
    });

    $(".display_input").keyup(function(){
        symbol = $("input[name='symbol']").val();
        if($("select[name='symbol_place']").val()=='right') {
            $("#displayPrice").html("<h3>"+number_format()+symbol+"</h3>");
        } else {
            $("#displayPrice").html("<h3>"+symbol+number_format()+"</h3>");
        }
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = 123456;
        decimals = $("select[name='decimal_places']").val();
        dec_point = $("input[name='decimal_token']").val();
        thousands_sep = $("input[name='thousand_token']").val();
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>
@endsection
