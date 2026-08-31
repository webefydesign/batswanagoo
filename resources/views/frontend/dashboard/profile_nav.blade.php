<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="setarrow">
                <a href="{{ url('dashboard/my_ads') }}">
                    <i class="fa fa-chevron-right"></i>
                </a>
                <strong>
                    Settings
                </strong>
            </div>
            <div class="ps-ul">
                <ul>
                    <li><a href="{{ url('dashboard/profile') }}">Personal details</a></li>
                    <li><a href="{{ url('dashboard/business-information') }}">Business information</a></li>
                </ul>
            </div>
            <div class="ps-ul">
                <ul>
                    {{-- <li><a href="{{ url('dashboard/change-number') }}">Update phone number</a></li> --}}
                    <li><a href="{{ url('dashboard/change-email') }}">Update email address</a></li>
                    <!-- <li><a href="#">Change language </a></li> -->
                </ul>
            </div>
            <div class="ps-ul">
                <ul>
                    <li><a href="{{ url('dashboard/disable-chats') }}">Disable chats</a></li>
                    <li><a href="{{ url('dashboard/disable-feedback') }}">Disable Feedback</a></li>
                    <li><a href="{{ url('dashboard/social-links') }}">Social Links</a></li>
                    {{-- <li><a href="{{ url('dashboard/manage-notification') }}">Manage notifications </a></li> --}}
                </ul>
            </div>
            <div class="ps-ul">
                <ul>
                    <li><a href="{{ url('dashboard/change-password') }}">Change password </a></li>
                    <li><a href="{{ url('dashboard/delete-account') }}">Delete my account </a></li>
                    <li><a href="javascript:void(0);" class="logout-me">Log out</a></li>
                </ul>
            </div>
        </div><!-- panl-body -->
    </div>

</div>
