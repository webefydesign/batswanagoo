@if(count($category->childrens)>0)
    @foreach ($category->childrens as $category)
        <option value="{{$category->id}}" @if(isset($id)) {{($id==$category->id)?'selected':''}} @endif> {!! $space !!} {{$category->name}}</option>
        @include('backend.categories.options',['category'=>$category, 'space' => $space.'&nbsp;&nbsp;&nbsp;', 'id'=>($id)??null])
    @endforeach
@endif