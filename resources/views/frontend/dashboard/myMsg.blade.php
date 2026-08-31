@extends('layouts.frontend')
@section('title', 'My Messages | Salone Goo')
@section('customStyles')
    <style>
    </style>
@endsection
@section('content')

    <section class="all-list-bre searchbanner msgbanner"
        style="background-image: url('{{asset('assets_frontend/img/electronices.jpg')}}');">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="{{ url('/') }}">Back to Search</a>
                    </li>
                    <li><span>My Message</span>
                    </li>
                </ul>
                <h2 class="hidenMobile" style="visibility: hidden;">My Profile</h2>
                <h1 class="adTitlemy">My Message</h1>
            </div>
        </div>
    </section>


    <section class="flats msg-flat">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="mt-5">
                        <div id="home" class="tab-pane fade active show">
                            <div class="addDiv mt-3 mb-5 desktoptable">
                                <table class="table  table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Contact No</th>
                                            <th scope="col" style="width: 180px;">Message</th>
                                            <th scope="col" style="width: 180px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach($messages as $key => $msg)
                                            @php
                                                $adv = $msg->advertise;
                                                if(isset($adv)){
                                                    $img = ($adv->gallery->first()!=null)?$adv->gallery->first()->image:null;
                                                }
                                            @endphp
                                            @if(isset($adv))
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td style="font-size: 13px;">
                                                    <a href="{{ url(generateUrl($adv->category_id, 'category', $adv->slug)) }}" class="pname">
                                                        <img src="{{asset('uploads/post/'.$img)}}" alt="{{$adv->title}}">
                                                        <strong>{{$adv->title}}</strong>
                                                    </a>
                                                </td>
                                                <td  style="font-size: 13px;"><label class="badgelabel">{{($adv->category->name)??''}}</label></td>
                                                <td style="font-size: 13px;">
                                                    <b>{{$msg->name}}</b> @if($msg->name!=null) <br> @endif
                                                    <a href="mailTo:{{$msg->email}}">{{$msg->email}}</a> @if($msg->email!=null) <br> @endif
                                                    <a href="tel:{{$msg->phone}}">{{$msg->phone}}</a>
                                                </td>
                                                <td style="">
                                                    <span class="textlimti" style="width: auto">
                                                        {!! Str::limit($msg->msg, 80, '...') !!}
                                                    </span>
                                                </td>
                                                <td style="">
                                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary view-msg" data-id="{{$msg->id}}">View</a>
                                                </td>
                                            </tr>
                                            @endif
                                            @php $i++; @endphp
                                        @endforeach
                                        @if(count($messages)==0)
                                        <tr>
                                            <td colspan="7" align="center" class="p-2"> No Message Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example mt-5" class="example mt-5">
                                    {!! $messages->links('pagination::bootstrap-5') !!}
                                    {{-- <ul class="pagination text-center justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul> --}}
                                </nav>
                            </div><!-- profileDiv -->

                            <div class="addDiv mt-3 mb-5 mobileTable">
                                @php $i = 1; @endphp
                                @foreach($messages as $key => $msg)
                                @php
                                    $adv = $msg->advertise;
                                    if(isset($adv)){
                                        $img = ($adv->gallery->first()!=null)?$adv->gallery->first()->thumb_img:null;
                                    }
                                @endphp
                                <div class="m-table">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                                <th class="f-td" scope="col">Product</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Contact No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                               <td colspan="3">
                                                   <table class="table">
                                                        <td class="f-td">
                                                            @if(isset($adv))
                                                                <a href="{{ url(generateUrl($adv->category_id, 'category', $adv->slug)) }}" class="p-image"><img src="{{asset('uploads/post/'.$img)}}"><strong> {{$adv->title}}</strong></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void();">{{$msg->name}}</a>
                                                        </td>
                                                        <td><a href="tel:{{$msg->phone}}">{{$msg->phone}}</a></td>
                                                   </table>
                                                   <div>
                                                       <strong>Message</strong>
                                                       <p>{!! $msg->msg !!}</p>
                                                   </div>
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                                @if(count($messages)==0)
                                <div> <p class="p-2"> No Message Found</p> </div>
                                @endif
                                <nav aria-label="Page navigation example mt-5" class="example mt-5">
                                    {!! $messages->links() !!}
                                    {{-- <ul class="pagination text-center justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul> --}}
                                </nav>
                            </div><!-- profileDiv -->


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

<!-- Msg Detail Modal -->
<div id="msgDetailModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" id="msgDetailContent"></div>
    </div>
</div>
@endsection

@section('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(() => {
            $('.alert-success').fadeOut(300);
        }, 3000);

        $(document).on('change', '.publish-ad', function() {
            var _this = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('publishAd') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res == 1) {
                        // $(_this).prop('checked', true);
                        $('.publishAd' + id).prop('checked', true);
                    } else {
                        $('.publishAd' + id).prop('checked', false);
                        // $(_this).prop('checked', false);
                    }
                }
            })
        });

        function deleteAd(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1eae38',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deletAd-' + id).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }

        $(document).on('click', '.view-msg', function() {
            var mid = $(this).attr('data-id');
            var _this = $(this);
            var btnText = _this.text();
            _this.text('Loading...');

            $.ajax({
                url: "{{ route('dashboard.mymsgDetail') }}",
                type: 'POST',
                data: { id: mid, _token: '{{ csrf_token() }}' },
                success: function(res) {
                    $('#msgDetailContent').html(res);
                    $('#msgDetailModal').modal('show');
                    _this.text(btnText);
                }
            });
        });
    </script>
@endsection
