@php
    $adv = $data->advertise;
    if(isset($adv)){
        $img = ($adv->gallery->first()!=null)?$adv->gallery->first()->image:null;
    }
@endphp
<div class="modal-header">
    <h4 class="modal-title">{{$adv->title ?? 'Message Detail'}}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            {{-- <p><b>Name:</b> {{$data->name}}</p> --}}
            <p><b>Email:</b> {{$data->email}}</p>
            <p><b>Phone:</b> {{$data->phone}}</p>
            <p><b>Message:</b><br /> {{$data->msg}}</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('uploads/post/' . $img) }}" alt="{{$adv->title}}" class="img-fluid rounded">
        </div>
    </div>    
</div>
{{-- <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save</button>
</div> --}}
