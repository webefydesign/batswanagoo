@foreach($categories as $key => $category)
    @php
        if(isset($plan_cat)){
            $plan = $plan_cat->where('category_id', $category->id)->first();
        }else{
            $plan = null;
        }
    @endphp
    <div class="col-sm-12">
        <div class="form-group">
            <label style="display: flex;align-items: center;justify-content: space-between;">
                <div>{{ $category->name }} @if($category->parent_id != null) ({{$category->parent->name}}) @endif </div>
                <div>
                    <label>
                        <input type="checkbox" name="category[{{ $key }}][unlimited]" value="1" {{ (isset($plan['unlimited']) && $plan['unlimited'] == 1) ?'checked':null }}>
                        <span style="position:relative;top:-2px;">Unlimited</span>
                    </label>
                </div>
            </label>
            <input type="hidden" class="form-control" name="category[{{ $key }}][category_id]" value="{{ $category->id }}">
            <input type="number" class="form-control input-sm" name="category[{{ $key }}][ads]" value="{{ $plan['ads'] ?? null }}">
        </div>
    </div>
@endforeach
