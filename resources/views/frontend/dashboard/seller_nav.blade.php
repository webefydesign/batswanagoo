<div class="card card-s">
    <div class="card-body">

        <div class="slr">

            @if(isset($user->image))
            <img src="{{ asset('uploads/profile/' . $user->image) }}" style="object-fit: cover;">
            @else
                <img src="{{ asset('assets_frontend/img/ic-11.png') }}" style="object-fit: cover;">
            @endif
            <strong>{{ $user->name }}</strong>
            <ul class="s--ul">
                @if($user->is_login && $user->last_activity > now()->subMinutes(5))
                <li ><span class="li-status-online"></span> <em>Online</em></li>
                @else
                <li> <span class="li-status"></span>  <em>Last seen {{ ($user->login_datetime!=null)?\Carbon\Carbon::parse($user->login_datetime)->diffForHumans():'never' }}</em> </li>
                @endif
                <li><em>Selling for {{ $user->created_at->diffForHumans() }}</em></li>
            </ul>

        </div>
    </div>
</div>
<div class="card card-s mt-3">
    <div class="card-body">
        <div class="slr-about">
            <h4>About {{ $user->name }}</h4>
            <p>{{ $user->about_company ?? '' }}</p>
        </div>
    </div>
</div>

@if(auth()->check())
<div class="card card-s mt-3">
    <div class="card-body">
        <div class="slr-about">
            <div class="wh-div">
                <h4>Working Hours</h4>
                <h5>{{ $user->working_time_start ?? '' }} - {{ $user->working_time_end ?? '' }}</h5>
            </div>
        </div>
        <div class="checkTime">
            @php
                $workingDays = $user->working_day ?? [];
            @endphp
            <ul>
                @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <li>
                        <label class="containercks">
                            <input type="checkbox" value="{{ $day }}" {{ in_array($day, $workingDays) ? 'checked' : '' }} disabled readonly>
                            <span class="checkmark" ></span>
                            <b>{{ $day }}</b>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<div class="card card-s mt-3">
    <div class="card-body">
        <div class="slr-about">
            <h4>Address</h4>
            <p>{{ $user->company_address ?? '' }}</p>
            <hr>

            <h4>Phone</h4>
            <p><a href="tel:061-526550">{{ $user->phone ?? '' }}</a></p>
            <hr>
            <hr>
            <h4>Email</h4>
            <p><a href="Mail:{{ $user->email }}">{{ $user->email }}</a></p>
        </div>
    </div>
</div>


@if($user->social_links && $user->social_links != null)
@if(isset($user->social_links->facebook) || isset($user->social_links->twitter) || isset($user->social_links->linkedin) || isset($user->social_links->youtube) || isset($user->social_links->pinterest) || isset($user->social_links->instagram))
<style>
    .sellet-socials { justify-content: center; }
</style>
<div class="card card-s mt-3">
    <div class="card-body">
        <div class="slr-about">
            <ul class="sellet-socials">
                @if(isset($user->social_links->facebook))
                <li>
                    <a target="_blank" href="{{$user->social_links->facebook}}">
                        <img src="{{ asset('assets_frontend/img/social/3.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->twitter))
                <li>
                    <a target="_blank" href="{{$user->social_links->twitter}}">
                        <img src="{{ asset('assets_frontend/img/social/2.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->linkedin))
                <li>
                    <a target="_blank" href="{{$user->social_links->linkedin}}">
                        <img src="{{ asset('assets_frontend/img/social/1.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->youtube))
                <li>
                    <a target="_blank" href="{{$user->social_links->youtube}}">
                        <img src="{{ asset('assets_frontend/img/social/5.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->pinterest))
                <li>
                    <a target="_blank" href="{{$user->social_links->pinterest}}">
                        <img src="{{ asset('assets_frontend/img/social/9.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->instagram))
                <li>
                    <a target="_blank" href="{{$user->social_links->instagram}}">
                        <img src="{{ asset('assets_frontend/img/social/insta.png') }}">
                    </a>
                </li>
                @endif
                @if(isset($user->social_links->tiktok))
                <li>
                    <a target="_blank" href="{{$user->social_links->tiktok}}">
                        <img src="{{ asset('assets_frontend/img/social/tiktok.png') }}">
                    </a>
                </li>
                @endif
            </ul>

        </div>
    </div>
</div>
@endif
@endif

@else
<a href="{{ url('login') }}" style="font-size: 13px;margin: 0 auto;display: block;text-align: center;width: 90%;" class="btn btn-outline-success mt-2">View more information</a>
@endif