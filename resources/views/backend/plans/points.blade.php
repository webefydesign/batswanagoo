@foreach($typePoints as $key => $value)
    <div class="col-sm-12 el_row">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label>{{($value)??''}}</label>
                    <input type="text" class="form-control input-sm" name="points[{{$key}}][text]" value="{{($points[$key]['text'])??''}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Options</label>
                    <select class="form-control input-sm" name="points[{{$key}}][include]">
                        <option value="text" {{(isset($points[$key]['include']) && $points[$key]['include'] == 'text')?'selected':''}}>Show Text</option>
                        <option value="yes" {{(isset($points[$key]['include']) && $points[$key]['include'] == 'yes')?'selected':''}}>Yes</option>
                        <option value="no" {{(isset($points[$key]['include']) && $points[$key]['include'] == 'no')?'selected':''}}>No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endforeach