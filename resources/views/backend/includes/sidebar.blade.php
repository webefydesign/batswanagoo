<div class="js-sidebar-scroll">
    <!-- Side Navigation -->
    <div class="content-side">
      <ul class="nav-main">
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('dashboard')}}">
            <i class="nav-main-link-icon si si-speedometer"></i>
            <span class="nav-main-link-name">Dashboard</span>
          </a>
        </li>
        <li class="nav-main-heading">Ads Management</li>
        @if(check_access(Auth::user()->id,'sliders','_show')==1)
            <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-list"></i>
                <span class="nav-main-link-name">Slider</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                <a class="nav-main-link" href="{{route('sliders.index')}}">
                    <span class="nav-main-link-name">List</span>
                </a>
                </li>
                <li class="nav-main-item">
                <a class="nav-main-link" href="{{route('sliders.create')}}">
                    <span class="nav-main-link-name">Create</span>
                </a>
                </li>
            </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'categories','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="nav-main-link-icon si si-list"></i>
            <span class="nav-main-link-name">Categories</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('categories.index')}}">
                <span class="nav-main-link-name">Main Categories</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('sub-categories.index')}}">
                <span class="nav-main-link-name">Sub Categories</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'plans','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="nav-main-link-icon fa fa-dollar"></i>
            <span class="nav-main-link-name">Plans</span>
          </a>
          <ul class="nav-main-submenu">
            {{-- Plan Type management disabled - ad posting no longer requires a plan/plan type.
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('plan-types.index')}}">
                <span class="nav-main-link-name">Types</span>
              </a>
            </li>
            --}}
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('plans.index')}}">
                <span class="nav-main-link-name">Plans</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'promotions','_show')==1)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-list"></i>
                <span class="nav-main-link-name">Promotions</span>
                </a>
                <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('promote.index')}}">
                    <span class="nav-main-link-name">List</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('promote.create')}}">
                    <span class="nav-main-link-name">Create</span>
                    </a>
                </li>
                </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'currencies','_show')==1)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-list"></i>
                <span class="nav-main-link-name">Currencies</span>
                </a>
                <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('currencies.index')}}">
                    <span class="nav-main-link-name">List</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('currencies.create')}}">
                    <span class="nav-main-link-name">Create</span>
                    </a>
                </li>
                </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'faqs','_show')==1)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-list"></i>
                <span class="nav-main-link-name">FAQs</span>
                </a>
                <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('faqs.index')}}">
                    <span class="nav-main-link-name">List</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('faqs.create')}}">
                    <span class="nav-main-link-name">Create</span>
                    </a>
                </li>
                </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'sl_faqs','_show')==1)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-list"></i>
                <span class="nav-main-link-name">Batswana Goo Faqs</span>
                </a>
                <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('salonegoo_faqs.index')}}">
                    <span class="nav-main-link-name">List</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('salonegoo_faqs.create')}}">
                    <span class="nav-main-link-name">Create</span>
                    </a>
                </li>
                </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'safeties','_show')==1)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-list"></i>
                    <span class="nav-main-link-name">Safeties</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{route('safeties.index')}}">
                        <span class="nav-main-link-name">List</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{route('safeties.create')}}">
                        <span class="nav-main-link-name">Create</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if(check_access(Auth::user()->id,'fields','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('fields.index')}}">
            <i class="nav-main-link-icon fa fa-code"></i>
            <span class="nav-main-link-name">Fields Management</span>
          </a>
        </li>
        @endif
        {{-- @if(check_access(Auth::user()->id,'promotions','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('fields.index')}}">
            <i class="nav-main-link-icon fa fa-ticket"></i>
            <span class="nav-main-link-name">Promotions</span>
          </a>
        </li>
        @endif --}}
        @if(check_access(Auth::user()->id,'ads','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('advertises.index')}}">
            <i class="nav-main-link-icon fa fa-ticket"></i>
            <span class="nav-main-link-name">Manage Ads</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'payments','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('admin.walletPayments')}}">
            <i class="nav-main-link-icon fa fa-ticket"></i>
            <span class="nav-main-link-name">Wallet Payments <span class="badge bg-info">{{pendingPaymentsCount()}}</span></span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'reports','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('reports.index')}}">
            <i class="nav-main-link-icon fa fa-ticket"></i>
            <span class="nav-main-link-name">Report/Unavailable</span>
          </a>
        </li>
        @endif
        <li class="nav-main-heading">CMS</li>
        @if(check_access(Auth::user()->id,'pages','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="nav-main-link-icon si si-list"></i>
            <span class="nav-main-link-name">Pages</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('pages.index')}}">
                <span class="nav-main-link-name">List</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('pages.create')}}">
                <span class="nav-main-link-name">Create</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'blogs','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="nav-main-link-icon fa fa-clipboard-check"></i>
            <span class="nav-main-link-name">Blogs</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('blogs-categories.index')}}">
                <span class="nav-main-link-name">Categories</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('blogs.index')}}">
                <span class="nav-main-link-name">List</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('blogs.create')}}">
                <span class="nav-main-link-name">Create</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'clients','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('clients.index')}}">
            <i class="nav-main-link-icon fa fa-boxes-stacked"></i>
            <span class="nav-main-link-name">Clients</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'testimonials','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('testimonials.index')}}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Testimonials</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'users','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="nav-main-link-icon fa fa-users-gear"></i>
            <span class="nav-main-link-name">User Management</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('customers.index')}}">
                <span class="nav-main-link-name">Customers</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('users.index')}}">
                <span class="nav-main-link-name">Users</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('usergroups.index')}}">
                <span class="nav-main-link-name">Groups</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('logsPage')}}">
                <span class="nav-main-link-name">Admin Logs</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{route('customersLogs')}}">
                <span class="nav-main-link-name">Customer Logs</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'redirections','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('redirections.index')}}">
            <i class="nav-main-link-icon fa fa-square-arrow-up-right"></i>
            <span class="nav-main-link-name">Redirections</span>
          </a>
        </li>
        @endif

        <li class="nav-main-heading">Additionals</li>
        @if(check_access(Auth::user()->id,'chat-stickers','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('chat-stickers.index')}}">
            <i class="nav-main-link-icon fa fa-rectangle-list"></i>
            <span class="nav-main-link-name">Chat Stickers</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'menu','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('menuEditor')}}">
            <i class="nav-main-link-icon fa fa-rectangle-list"></i>
            <span class="nav-main-link-name">Menu</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'configuration','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('configurationPage')}}">
            <i class="nav-main-link-icon fa fa-cog"></i>
            <span class="nav-main-link-name">Configurations</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'inbox','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('inboxPage')}}">
            <i class="nav-main-link-icon fa fa-inbox"></i>
            <span class="nav-main-link-name">Inbox</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'inbox','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('blogCommentsList')}}">
            <i class="nav-main-link-icon fa fa-inbox"></i>
            <span class="nav-main-link-name">Comments <span class="badge bg-info">{{pendingCommentCounts()}}</span></span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'careers','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('careersPage')}}">
            <i class="nav-main-link-icon fa fa-inbox"></i>
            <span class="nav-main-link-name">Careers</span>
          </a>
        </li>
        @endif
        @if(check_access(Auth::user()->id,'subscribers','_show')==1)
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{route('subscribersPage')}}">
            <i class="nav-main-link-icon fa fa-inbox"></i>
            <span class="nav-main-link-name">Subscribers</span>
          </a>
        </li>
        @endif
      </ul>
    </div>
    <!-- END Side Navigation -->
  </div>
