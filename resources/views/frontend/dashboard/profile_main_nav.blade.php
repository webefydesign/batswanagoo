<div class="panel-heading">
    <div class="avr">
        @if(isset(auth()->user()->image))
            <img src="{{ asset('uploads/profile/' . (auth()->check() ? auth()->user()->image : ' ')) }}">
        @else
            <img src="{{asset('assets_frontend')}}/img/ic-11.png"/>
        @endif
        <strong>{{ auth()->check() ? auth()->user()->full_name : '' }}</strong>
        <div class="sets-div"><a href="{{ url('dashboard/profile') }}"><strong>Settings</strong></a></div>
    </div>
</div>
<div class="panel-body">
    <ul class="puser-items">
        @if(auth()->user()->ads->count() > 0)
        <li><a href="{{ route('dashboard.my_ads') }}" class="adicon"><span>My Listings</span></a></li>
        @endif
        <li><a href="{{ route('dashboard.my_list') }}" class="listicon"><span>My List</span></a></li>
        <li><a href="{{ route('dashboard.performance') }}" class="performicon"><span>Performance</span></a></li>
        @if(auth()->user()->ads->count() > 0)
        <li><a href="{{ url('dashboard/feedback/' . auth()->user()->id) }}" class="feedicon"><span>Feedback</span></a></li>
        @endif
        <li><a href="{{ url('faqs') }}" class="faqicon"><span>Frequently Asked Questions</span></a></li>
    </ul>
</div><!-- panl-body -->
