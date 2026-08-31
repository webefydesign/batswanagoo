@extends('layouts.frontend')
@section('title', 'My Adds | Batswana Goo')
@section('customStyles')

    <style>
        .full-bot-book {
            display: none;
        }

        .badgelabel {
            display: inline-block;
            max-width: 90px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }

        .pname {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }

        .pname img {
            height: 25px;
            width: 25px;
            object-fit: contain;
            text-align: center;
            object-position: center;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .edits:before {
            padding: 0;
        }

        .delets:before {
            padding: 0;
        }

        .viewss:before {
            padding: 0;
        }

        .edits:before {
            padding: 0;
        }
    </style>
@endsection
@section('content')

    <div class="m-container forprfile">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            @include('frontend.dashboard.profile_main_nav')
                        </div>
                    </div>
                </div><!-- sm4 -->
                <div class="col-sm-9">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="tab-heads">
                                    <h3>My Listings</h3>
                                    <div class="myAdtabs">
                                        <ul class="nav nav-tabs">
                                            <li><a class="greenlink active" data-toggle="tab" href="#all">All
                                                    <small>({{ $allAds->total() }})</small></a></li>
                                            <li><a class="yellowlink" data-toggle="tab" href="#active">Active
                                                    <small>({{ $active->total() }})</small></a></li>
                                            <li><a class="blacklink" data-toggle="tab" href="#pending">Pending
                                                    <small>({{ $pending->total() }})</small></a></li>
                                            <li><a class="whitelink" data-toggle="tab" href="#sold">Sold
                                                    <small>({{ $sold->total() }})</small></a></li>
                                        </ul>
                                    </div><!-- mtAdtabs -->
                                </div><!-- tab-heads -->

                            </div><!-- panel-heading -->
                            <div class="panel-body">
                                <div class="tab-content pf-tabcontent">
                                    <div id="all" class="tab-pane fade active show">
                                        <div class="addDiv">

                                            <table class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date Created</th>
                                                        <th scope="col">Sold</th>
                                                        <th scope="col">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach ($allAds as $ad)
                                                        @php  $img = ($ad->gallery[0]->image)??'#'; @endphp
                                                        <tr>
                                                            <th scope="row">{{ $i + 10 * ($allAds->currentPage() - 1) }}
                                                            </th>
                                                            <td title="{{ $ad->title ?? '' }}">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="pname">
                                                                    <img src="{{ asset('uploads/post/' . $img) }}" />
                                                                    <strong>{{ $ad->title }}</strong>
                                                                    {{-- <label class="featured">Featured</label> --}}
                                                                </a>
                                                            </td>
                                                            <td><label title="{{ $ad->category->name ?? '' }}"
                                                                    class="badgelabel">{{ $ad->category->name ?? '' }}</label>
                                                            </td>
                                                            <td>
                                                                @if ($ad->payment_type == 'amount')
                                                                    {{ baseSymbol() }} {{ number_format($ad->price) }}
                                                                @elseif($ad->payment_type == 'contact')
                                                                    Contact For Price
                                                                @else
                                                                    {{ ucFirst($ad->payment_type) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ date('dS M, Y', strtotime($ad->created_at)) }}</td>
                                                            <td align="center">
                                                                <label class="switch-c">
                                                                    <input type="checkbox"
                                                                        @if ($ad->status == 'sold') checked @endif
                                                                        class="sold-ad soldAd{{ $ad->id }}"
                                                                        data-id="{{ $ad->id }}">
                                                                    <span class="slider-c round"></span>
                                                                </label>
                                                            </td>
                                                            <td style="text-transform:capitalize">
                                                                @if ($ad->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                                @elseif($ad->status == 'pending')
                                                                    <div class="badge badge-warning">Pending</div>
                                                                @elseif($ad->status == 'sold')
                                                                    <div class="badge badge-info">Sold</div>
                                                                @endif    
                                                            </td>
                                                            <td class="p-0">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="edits p-0"></a>
                                                                <a href="#" class="delets p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')"></a>
                                                                <a @if ($ad->category == null) href="javascript:void(0);" @else target="_blank" href="{{ url(optional($ad->category)->getSlug(optional($ad->category)->slug) . '/' . $ad->slug) }}" @endif
                                                                    class="viewss p-0"></a>
                                                                <a href="#" class="deletsold p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')">
                                                                    <i class="fa fa-dollar"></i>
                                                                </a>
                                                                <form action="{{ route('dashboard.destroyStore') }}"
                                                                    class="deletAd-{{ $ad->id }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" value="{{ $ad->id }}"
                                                                        name="id">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    @if (count($allAds) == 0)
                                                        <tr>
                                                            <td colspan="8" align="center" class="p-2"> No Ads Found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <!-- {{ $allAds->links() }} -->
                                            {{ $allAds->links('pagination.custom') }}
                                            
                                        </div><!-- profileDiv -->


                                    </div>
                                    <div id="active" class="tab-pane fade">
                                        <!-- <h3>Password Setup</h3> -->
                                        <div class="addDiv mt-3 mb-5">

                                            <table class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date Created</th>
                                                        <th scope="col">Sold</th>
                                                        <th scope="col">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach ($active as $ad)
                                                        @php  $img = ($ad->gallery[0]->image)??'#'; @endphp
                                                        <tr>
                                                            <th scope="row">
                                                                {{ $i + 10 * ($active->currentPage() - 1) }}</th>
                                                            <td title="{{ $ad->title ?? '' }}">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="pname">
                                                                    <img src="{{ asset('uploads/post/' . $img) }}" />
                                                                    <strong>{{ $ad->title }}</strong>
                                                                    {{-- <label class="featured">Featured</label> --}}
                                                                </a>
                                                            </td>
                                                            <td><label title="{{ $ad->category->name ?? '' }}"
                                                                    class="badgelabel">{{ $ad->category->name ?? '' }}</label>
                                                            </td>
                                                            <td>
                                                                @if ($ad->payment_type == 'amount')
                                                                    {{ baseSymbol() }} {{ number_format($ad->price) }}
                                                                @elseif($ad->payment_type == 'contact')
                                                                    Contact For Price
                                                                @else
                                                                    {{ ucFirst($ad->payment_type) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ date('dS M, Y', strtotime($ad->created_at)) }}</td>
                                                            <td align="center">
                                                                <label class="switch-c">
                                                                    <input type="checkbox"
                                                                        @if ($ad->status == 'sold') checked @endif
                                                                        class="sold-ad soldAd{{ $ad->id }}"
                                                                        data-id="{{ $ad->id }}">
                                                                    <span class="slider-c round"></span>
                                                                </label>
                                                            </td>
                                                            <td style="text-transform:capitalize">
                                                                @if ($ad->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                                @elseif($ad->status == 'pending')
                                                                    <div class="badge badge-warning">Pending</div>
                                                                @elseif($ad->status == 'sold')
                                                                    <div class="badge badge-info">Sold</div>
                                                                @endif                                                                
                                                            </td>
                                                            <td class="p-0">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="edits p-0"></a>
                                                                <a href="#" class="delets p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')"></a>
                                                                <a @if ($ad->category == null) href="javascript:void(0);" @else target="_blank" href="{{ url(optional($ad->category)->getSlug(optional($ad->category)->slug) . '/' . $ad->slug) }}" @endif
                                                                    class="viewss p-0"></a>
                                                                <a href="#" class="deletsold p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')">
                                                                    <i class="fa fa-dollar"></i>
                                                                </a>
                                                                <form action="{{ route('dashboard.destroyStore') }}"
                                                                    class="deletAd-{{ $ad->id }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" value="{{ $ad->id }}"
                                                                        name="id">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    @if (count($active) == 0)
                                                        <tr>
                                                            <td colspan="8" align="center" class="p-2"> No Ads
                                                                Found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <!-- {{ $active->links() }} -->
                                            {{ $active->links('pagination.custom') }}

                                        </div><!-- profileDiv -->
                                    </div><!-- tab-pane -->
                                    <div id="pending" class="tab-pane fade">
                                        <div class="addDiv mt-3 mb-5">

                                            <table class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date Created</th>
                                                        <th scope="col">Sold</th>
                                                        <th scope="col">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach ($pending as $ad)
                                                        @php  $img = ($ad->gallery[0]->image)??'#'; @endphp
                                                        <tr>
                                                            <th scope="row">
                                                                {{ $i + 10 * ($pending->currentPage() - 1) }}</th>
                                                            <td title="{{ $ad->title ?? '' }}">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="pname">
                                                                    <img src="{{ asset('uploads/post/' . $img) }}" />
                                                                    <strong>{{ $ad->title }}</strong>
                                                                    {{-- <label class="featured">Featured</label> --}}
                                                                </a>
                                                            </td>
                                                            <td><label title="{{ $ad->category->name ?? '' }}"
                                                                    class="badgelabel">{{ $ad->category->name ?? '' }}</label>
                                                            </td>
                                                            <td>
                                                                @if ($ad->payment_type == 'amount')
                                                                    {{ baseSymbol() }} {{ number_format($ad->price) }}
                                                                @elseif($ad->payment_type == 'contact')
                                                                    Contact For Price
                                                                @else
                                                                    {{ ucFirst($ad->payment_type) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ date('dS M, Y', strtotime($ad->created_at)) }}</td>
                                                            <td align="center">
                                                                <label class="switch-c">
                                                                    <input type="checkbox"
                                                                        @if ($ad->status == 'sold') checked @endif
                                                                        class="sold-ad soldAd{{ $ad->id }}"
                                                                        data-id="{{ $ad->id }}">
                                                                    <span class="slider-c round"></span>
                                                                </label>
                                                            </td>
                                                            <td style="text-transform:capitalize">
                                                                @if ($ad->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                                @elseif($ad->status == 'pending')
                                                                    <div class="badge badge-warning">Pending</div>
                                                                @elseif($ad->status == 'sold')
                                                                    <div class="badge badge-info">Sold</div>
                                                                @endif    
                                                            </td>
                                                            <td class="p-0">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="edits p-0"></a>
                                                                <a href="#" class="delets p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')"></a>
                                                                <a @if ($ad->category == null) href="javascript:void(0);" @else target="_blank" href="{{ url(optional($ad->category)->getSlug(optional($ad->category)->slug) . '/' . $ad->slug) }}" @endif
                                                                    class="viewss p-0"></a>
                                                                <a href="#" class="deletsold p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')">
                                                                    <i class="fa fa-dollar"></i>
                                                                </a>
                                                                <form action="{{ route('dashboard.destroyStore') }}"
                                                                    class="deletAd-{{ $ad->id }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" value="{{ $ad->id }}"
                                                                        name="id">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    @if (count($pending) == 0)
                                                        <tr>
                                                            <td colspan="8" align="center" class="p-2"> No Ads
                                                                Found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <!-- {{ $pending->links() }} -->
                                            {{ $pending->links('pagination.custom') }}

                                        </div>
                                    </div>
                                    <div id="sold" class="tab-pane fade">
                                        <div class="addDiv mt-3 mb-5">

                                            <table class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date Created</th>
                                                        <th scope="col">Sold</th>
                                                        <th scope="col">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach ($sold as $ad)
                                                        @php  $img = ($ad->gallery[0]->image)??'#'; @endphp
                                                        <tr>
                                                            <th scope="row">{{ $i + 10 * ($sold->currentPage() - 1) }}
                                                            </th>
                                                            <td title="{{ $ad->title ?? '' }}">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="pname">
                                                                    <img src="{{ asset('uploads/post/' . $img) }}" />
                                                                    <strong>{{ $ad->title }}</strong>
                                                                    {{-- <label class="featured">Featured</label> --}}
                                                                </a>
                                                            </td>
                                                            <td><label title="{{ $ad->category->name ?? '' }}"
                                                                    class="badgelabel">{{ $ad->category->name ?? '' }}</label>
                                                            </td>
                                                            <td>
                                                                @if ($ad->payment_type == 'amount')
                                                                    {{ baseSymbol() }} {{ number_format($ad->price) }}
                                                                @elseif($ad->payment_type == 'contact')
                                                                    Contact For Price
                                                                @else
                                                                    {{ ucFirst($ad->payment_type) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ date('dS M, Y', strtotime($ad->created_at)) }}</td>
                                                            <td align="center">
                                                                <label class="switch-c">
                                                                    <input type="checkbox"
                                                                        @if ($ad->status == 'sold') checked @endif
                                                                        class="sold-ad soldAd{{ $ad->id }}"
                                                                        data-id="{{ $ad->id }}">
                                                                    <span class="slider-c round"></span>
                                                                </label>
                                                            </td>
                                                            <td style="text-transform:capitalize">
                                                                @if ($ad->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                                @elseif($ad->status == 'pending')
                                                                    <div class="badge badge-warning">Pending</div>
                                                                @elseif($ad->status == 'sold')
                                                                    <div class="badge badge-info">Sold</div>
                                                                @endif    
                                                            </td>
                                                            <td class="p-0">
                                                                <a href="{{ url('dashboard/editPost/' . $ad->id) }}"
                                                                    class="edits p-0"></a>
                                                                <a href="#" class="delets p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')"></a>
                                                                <a @if ($ad->category == null) href="javascript:void(0);" @else target="_blank" href="{{ url(optional($ad->category)->getSlug(optional($ad->category)->slug) . '/' . $ad->slug) }}" @endif
                                                                    class="viewss p-0"></a>
                                                                <a href="#" class="deletsold p-0"
                                                                    onclick="deleteAd('{{ $ad->id }}')">
                                                                    <i class="fa fa-dollar"></i>
                                                                </a>
                                                                <form action="{{ route('dashboard.destroyStore') }}"
                                                                    class="deletAd-{{ $ad->id }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" value="{{ $ad->id }}"
                                                                        name="id">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    @if (count($sold) == 0)
                                                        <tr>
                                                            <td colspan="8" align="center" class="p-2"> No Ads
                                                                Found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <!-- {{ $sold->links() }} -->
                                            {{ $sold->links('pagination.custom') }}

                                        </div>
                                    </div>
                                </div>


                            </div><!-- panl-body -->
                        </div>


                    </div><!-- sm8 -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(() => {
            $('.alert-success').fadeOut(300);
        }, 3000);

        $('[data-toggle="tab"]').on('click', function() {
            var href = $(this).attr('href');
            $('.tab-pane').addClass('fade');
            $('.tab-pane').removeClass('show').removeClass('active');
            $(href).removeClass('fade');
            $(href + '-mob').removeClass('fade');
            $(href).addClass('show').addClass('active');
            $(href + '-mob').addClass('show').addClass('active');
        });

        $(document).on('change', '.sold-ad', function() {
            var _this = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('dashboard.publishAd') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res == 1) {
                        // $(_this).prop('checked', true);
                        $('.soldAd' + id).prop('checked', true);
                    } else {
                        $('.soldAd' + id).prop('checked', false);
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
    </script>
@endsection
