@if ($other == 0)
    <div class="form-group">
        <div class="labelTxt">
            <label>{{ $firstMain['name'] ?? '' }}'s Categories</label>
            <span>(Required)</span>
        </div>
        <input type="hidden" value="{{ $firstMain['id'] }}" name="category[0]">
        <select class="form-control select_2 fetchSubCategory" name="category[{{ $firstMain['id'] }}]"
            data-sub="sub_category_{{ $firstMain['id'] }}">
            <option value="" selected="">Select</option>
            @foreach ($firstMain->childrens as $child)
                <option value="{{ $child->id }}" @if (isset($id) && $id == $child->id) selected @endif>
                    {{ $child->name }}</option>
            @endforeach
        </select>
        <div class="more_sub_category">
            <div class="sub_category_{{ $firstMain['id'] }}"></div>
        </div>
        <p class="categoryMessage"></p>
    </div>
@elseif($other == 1)
    <div class="form-group">
        <div class="labelTxt">
            <label>All Other Categories</label>
            <span>(Required)</span>
        </div>
        <select class="form-control select_2 fetchSubCategory" name="category[0]" data-sub="sub_category_0">
            <option value="" selected="">Select</option>
            @foreach ($firstMain as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="more_sub_category">
            <div class="sub_category_0"></div>
        </div>
        <p class="categoryMessage"></p>
    </div>
@endif
