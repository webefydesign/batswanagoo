@if(isset($type) && $type=='search')
    <option value="{{$cates->id}}" style="font-weight:500 !important;" @if(is_array($meta)) {{(in_array($cates->id, $meta))?'selected':''}} @else {{($meta == $cates->id)?'selected':''}} @endif> {{$dash}} {{$cates->name}}</option>
    @if(count($cates->childrens)>0)
        @foreach ($cates->childrens as $cates)
            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=>$meta, 'cates'=>$cates, 'dash'=> '--'.$dash]);
        @endforeach
    @endif
@else
    @if(count($category->childrens)>0)
        @foreach ($category->childrens as $category)
            <option value="{{$category->id}}" @if(isset($id)) {{($id==$category->id)?'selected':''}} @endif> {!! $space !!} {{$category->name}}</option>
            @include('frontend.includes.category_option',['category'=>$category, 'space' => $space.'&nbsp;&nbsp;&nbsp;', 'id'=>($id)??null])
        @endforeach
    @endif
@endif
