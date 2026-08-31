@php 
   $configurations = getConfigurations();
   $footer_meta = $configurations['footer_meta']; 
   $social_meta = $configurations['social_meta'];
@endphp
   <!-- START -->
      {{-- <section>
         <div class="full-bot-book">
            <div class="container">
               <div class="row">
                  <div class="bot-book">
                     <div class="col-md-12 bb-text">
                        @if(isset($footer_meta['newsletter']['heading_1']))<h4>{{ ($footer_meta['newsletter']['heading_1'])??'' }}</h4>@endif
                        @if(isset($footer_meta['newsletter']['text']))<p>{{ ($footer_meta['newsletter']['text'])??'' }}</p>@endif
                        @if(isset($footer_meta['newsletter']['btn_txt']))<a href="{{ ($footer_meta['newsletter']['btn_link'])??'' }}">{{ ($footer_meta['newsletter']['btn_txt'])??'' }} <i class="material-icons">arrow_forward</i></a>@endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section> --}}
   <!-- END -->
     <section class=" wed-hom-footer">
  <div class="container">
     <div class="row foot-supp">
        <h2>
         @if(isset($footer_meta['support_number']))<span>Free support: </span> {{ ($footer_meta['support_number'])??'' }} @endif 
         @if(isset($footer_meta['support_number']) && isset($footer_meta['support_email'])) &nbsp;&nbsp;|&nbsp;&nbsp; @endif
         @if(isset($footer_meta['support_email']))<span>Email:</span> {{ ($footer_meta['support_email'])??'' }} @endif
        </h2>
     </div>
     <div class="row frc">
        <div class="col-sm-12">
           <div class="appl-div">
              <div class="dn-div">
                  <div class="dn-left">
                     @if(isset($footer_meta['logo']))<img src="{{ url($footer_meta['logo']) }}" alt="{{ ($footer_meta['logo_alt'])??'' }}"> @endif
                  </div><!-- dn-left -->
                 <div class="dn-right">
                     @if(isset($footer_meta['fheading']))<h4>{{ ($footer_meta['fheading'])??'' }}</h4>@endif
                     @if(isset($footer_meta['ftext']))<h5>{{ ($footer_meta['ftext'])??'' }}</h5>@endif
                     @if(isset($footer_meta['frating']))
                        <div class="b-stars">
                           <div class="ratings">
                              <div class="empty-stars"></div>
                              <div class="full-stars" style="width:{{($footer_meta['frating'])??''}}%"></div>
                           </div>
                           @if(isset($footer_meta['fratetext']))<strong>{{ ($footer_meta['fratetext'])??'' }}</strong>@endif
                        </div>
                     @endif
                 </div>
              </div>
              <div class="p-btnss">
                 @if(isset($footer_meta['icon_1']))<a href="{{ ($footer_meta['icon1_link'])??'#' }}"><img src="{{ url($footer_meta['icon_1']) }}" alt="{{ ($footer_meta['icon1_alt'])??'#' }}"></a>@endif
                 @if(isset($footer_meta['icon_2']))<a href="{{ ($footer_meta['icon2_link'])??'#' }}"><img src="{{ url($footer_meta['icon_2']) }}" alt="{{ ($footer_meta['icon2_alt'])??'#' }}"></a>@endif
              </div>
           </div>

        </div><!-- sm12 -->
     </div>
     <div class="row wed-foot-link">
        <div class="col-md-5 foot-tc-mar-t-o">
           @if(isset($footer_meta['heading_1']))<h4>{!! ($footer_meta['heading_1'])??'' !!}</h4>@endif
            @php
               $menu1_items = [];
               $menu1 = getMenuByID($footer_meta['menu_1']);
               if(isset($menu1)){
                  $menu1_items = $menu1['items'];
               }
            @endphp
            @if(isset($footer_meta['menu_1']) && count($menu1_items) > 0)
               <ul>
                  @foreach ($menu1_items as $item)
                     <li>
                        @if($item->slug=='home')
                        <a title="" href="{{url('/')}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @elseif($item->type=='page')
                        <a title="" href="{{route('dynamicPage', $item->slug)}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @elseif($item->type=='custom')
                        <a title="" href="{{$item->url}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @endif
                     </li>
                  @endforeach
               </ul>
            @endif
        </div>
        <div class="col-md-4">
         @if(isset($footer_meta['heading_2']))<h4>{!! ($footer_meta['heading_2'])??'' !!}</h4>@endif
         @php
            $menu2_items = [];
            $menu1 = getMenuByID($footer_meta['menu_2']);
            if(isset($menu1)){
               $menu2_items = $menu1['items'];
            }
         @endphp
         @if(isset($footer_meta['menu_2']) && count($menu2_items) > 0)
            <ul>
               @foreach ($menu2_items as $item)
                  <li>
                     @if($item->slug=='home')
                        <a title="" href="{{url('/')}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @elseif($item->type=='page')
                        <a title="" href="{{route('dynamicPage', $item->slug)}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @elseif($item->type=='custom')
                        <a title="" href="{{$item->url}}" @if($item->new_window==1) target="_blank" @endif>{{$item->title}}</a>
                        @endif
                     {{-- <a href="{{ url($link->url ?? 'javascript:void(0);') }}">{{ $link->title }}</a></li> --}}
               @endforeach
            </ul>
         @endif
        </div>
        <div class="col-md-3">

           <h4>SOCIAL MEDIA</h4>
           <ul class="sopcials">
               @foreach($social_meta as $name => $link)
                  @if($name == 'facebook')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/social/3.png')}}">
                           </a>
                        </li>
                  @endif
                  @if($name == 'twitter')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/social/2.png')}}">
                           </a>
                        </li>
                  @endif
                  @if($name == 'linkedin')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/social/1.png')}}">
                           </a>
                        </li>
                  @endif
                  @if($name == 'youtube')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/social/5.png')}}">
                           </a>
                        </li>
                  @endif
                  @if($name == 'printest')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/social/9.png')}}">
                           </a>
                        </li>
                  @endif
                  @if($name == 'instagram')
                        <li>
                           <a target="_blank" href="{{$link}}">
                              <img src="{{asset('assets_frontend/img/insta.png')}}">
                           </a>
                        </li>
                  @endif
               @endforeach
           </ul>
        </div>
     </div>

  </div>
</section>

     <!-- END -->
     <section>
        <div class="cr">
           <div class="container">
              <div class="row">
                 <p>Copyright &copy; {{date('Y')}}, Salone Goo. Powered by <a href="https://googrp.com/" target="_blank">Goo Group</a></p>
              </div>
           </div>
        </div>
     </section>


     {{-- <div class="modal fade logins" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-body">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
                 <section class=" login-reg">
                    <div class="container">
                       <div class="row">
                          <div class="login-main">
                             <div class="log log-1">
                                <div class="login">
                                   <h4>Member Login</h4>
                                   <form id="login_form" name="login_form" method="post">
                                      <div class="form-group">
                                         <label>Email Address</label>
                                         <input type="email" autocomplete="off" name="email_id" id="email_id" class="form-control" placeholder="Enter email*" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Enter email address" value="rn53themes@gmail.com" required>
                                      </div>
                                      <div class="form-group">
                                         <label>Password</label>
                                         <input type="password" name="password" id="password" class="form-control" placeholder="Enter password*" required value="passwor">
                                      </div>
                                      <button type="submit" name="login_submit" value="submit" class="btn btn-primary">Log In</button>
                                   </form>
                                   <div class="text-right">
                                      <ul>
                                         <li> <span class="ll-3"><a class="fgr" href="#">Forgot password?</a></span>
                                         </li>
                                      </ul>
                                   </div>
                                   <div class="text-center crt">
                                      <p>Not registered? <span class="ll-2">Create an Account</span></p>
                                   </div>

                                   <!-- SOCIAL MEDIA LOGIN -->
                                   <div class="soc-log">
                                      <ul>
                                         <li>
                                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                                         </li>
                                         <!--                                <li>-->
                                         <!--                                    <a href="google_login.html" class="login-goog"><img src="images/icon/seo.png">Continue-->
                                         <!--                                        with Google</a>-->
                                         <!--                                </li>-->

                                      </ul>
                                   </div>
                                   <!-- END SOCIAL MEDIA LOGIN -->
                                </div>
                             </div>
                             <div class="log log-2">
                                <div class="login">
                                   <h4>Create an account</h4>
                                   <form name="register_form" id="register_form" method="post" action="register_update.html">
                                      <div class="form-group">
                                         <label>Email</label>
                                         <input type="email" autocomplete="off" name="email_id" id="email_id" class="form-control" placeholder="Email id*" required>
                                      </div>
                                      <div class="form-group">
                                         <label>Password</label>
                                         <input type="password" name="password" id="password" class="form-control" placeholder="Password*" required>
                                      </div>
                                      <div class="form-group">
                                         <label>Confirm Password</label>
                                         <input type="password" name="password" id="password" class="form-control" placeholder="Confirm Password*" required>
                                      </div>
                                      <div class="form-group">
                                         <label>User Name</label>
                                         <input type="text" autocomplete="off" name="email_id" id="email_id" class="form-control" placeholder="Username" equired>
                                      </div>
                                      <!-- <div class="form-group ca-sh-user">
                                         <select name="user_type" id="user_type" class="form-control ca-check-plan">
                                            <option value="">User type</option>
                                            <option value="General">General user</option>
                                            <option value="Service provider">Service provider</option>
                                         </select> <a href="user-type" class="frmtip" target="_blank">User options</a>
                                      </div> -->
                                      <!-- <div class="form-group ca-sh-plan">
                                         <select name="user_plan" id="user_plan" class="form-control">
                                            <option value="" disabled="disabled" selected="selected">Choose your plan</option>
                                            <option value="1">Free</option>
                                            <option value="2">Standard - $9/year</option>
                                            <option value="3">Premium - $19/year</option>
                                            <option value="4">Premium Plus - $20/year</option>
                                                                 <option>Premium plus plan - $350/year</option>
                                         </select> <a href="pricing-details.html" class="frmtip" target="_blank">Plan details</a>
                                      </div> -->
                                      <button type="submit" name="register_submit" class="btn btn-primary">Register Now</button>
                                   </form>
                                   <div class="text-center crt">
                                      <p>Already registered? <span class="ll-1">Login</span></p>
                                   </div>
                                   <!-- SOCIAL MEDIA LOGIN -->
                                   <div class="soc-log">
                                      <ul>
                                         <li>
                                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                                         </li>
                                         <!--                                        <li>-->
                                         <!--                                            <a href="google_login.html" class="login-goog"><img-->
                                         <!--                                                    src="images/icon/seo.png">Continue-->
                                         <!--                                                with Google</a>-->
                                         <!--                                        </li>-->

                                      </ul>
                                   </div>
                                   <!-- END SOCIAL MEDIA LOGIN -->
                                </div>
                             </div>
                             <div class="log log-3">
                                <div class="login">
                                   <h4>Forgot password</h4>
                                   <form id="forget_form" name="forget_form" method="post" action="forgot_process.html">
                                      <div class="form-group">
                                         <input type="email" autocomplete="off" name="email_id" id="email_id" class="form-control" placeholder="Enter email*" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Invalid email address" required>
                                      </div>
                                      <button type="submit" name="forgot_submit" class="btn btn-primary">Submit</button>
                                   </form>
                                </div>
                             </div>
                             <!--   <div class="log-bot">
                                <ul>
                                   <li> <span class="ll-1">Login?</span>
                                   </li>
                                   <li> <span class="ll-2">Create an account?</span>
                                   </li>

                                </ul>
                             </div> -->
                          </div>
                       </div>
                    </div>
                 </section>

              </div><!-- modal-body -->
              <!--  <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div> -->
           </div>
        </div>
     </div> --}}
