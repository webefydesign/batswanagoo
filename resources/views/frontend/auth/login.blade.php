@extends('layouts.frontend')
@section('title', 'Register | Batswana Goo')
@section('content')
<section class=" login-reg">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif    

    <div class="container">
       <div class="row">
         @if (Session::has('success'))
            <div class="alert alert-success">
                  {{ Session::get('success') }}
            </div>
         @endif
          <div class="login-main">

             <div class="log log-1">
                <div class="login">
                   <h4>Member Login</h4>
                   <form id="login_form" name="login_form" method="post">
                    {{ csrf_field() }}
                      <div class="form-group">
                         <label>Email Address</label>
                         <input type="email" autocomplete="off" name="email" id="login_email"
                                        class="form-control" placeholder="Enter email*" title="Enter email address"
                                        placeholder="abcd@example.com" required value="{{ old('email') }}">
                      </div>
                      <div class="form-group">
                         <label>Password</label>
                         <input type="password" name="password" id="login_password" class="form-control"
                                        placeholder="Enter password*" required value="passwor">
                      </div>
                      <button type="submit" name="login_submit" value="submit" class="btn btn-primary">Log In</button>
                   </form>
                   <div class="text-right">
                      <ul>
                         <li> <span class="ll-3"><a class="fgr" href="#">Forgot password?</a></span>
                         </li>
                      </ul>
                   </div>
                   <div class="col-md-12">
                     <hr>
                     <a href="https://batswanagoo.co.bw/auth/google">
                        <div class="google_btn">
                            <img src="{{asset('google.png')}}" alt=""> SignIn with Google
                        </div>
                    </a>
                    {{-- <a href="#">
                           <div class="ep_btn">
                              Email
                           </div>
                     </a> --}}
                   </div>
                   <div class="text-center crt">
                      <p>Not registered? <span class="ll-2" id="registerbtn">Create an Account</span></p>
                   </div>

                   <!-- SOCIAL MEDIA LOGIN -->
                   {{-- <div class="soc-log">
                      <ul>
                         <li>
                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                         </li>
                         <!--                                <li>-->
                         <!--                                    <a href="google_login.html" class="login-goog"><img src="images/icon/seo.png">Continue-->
                         <!--                                        with Google</a>-->
                         <!--                                </li>-->

                      </ul>
                   </div> --}}
                   <!-- END SOCIAL MEDIA LOGIN -->
                </div>
             </div>
             <div class="log log-2">
                <div class="login">
                   <h4>Create an account</h4>
                   <form name="register_form" id="register_form" method="post" action="{{ route('register') }}">
                        {{ csrf_field() }}
                      <div class="form-group">
                         <label>Email</label>
                         <input type="email" autocomplete="off" name="email" class="form-control"
                                        placeholder="Email id*" required value="{{ old('email') }}">
                      </div>
                      <div class="form-group">
                         <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*"
                                        required>
                        <div style="font-size: 10px;line-height: 13px !important;margin-top: 6px;color: grey;">Password must contain at least one lowercase letter, one uppercase letter, one digit and special character.</div>
                      </div>
                      <div class="form-group">
                         <label>Confirm Password</label>
                         <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password*" required>
                      </div>
                      <div class="form-group">
                         <label>First Name</label>
                         <input type="text" autocomplete="off" name="first_name" class="form-control"
                                        placeholder="First Name" value="{{ old('first_name') }}" required>
                      </div>
                      <div class="form-group">
                         <label>Last Name</label>
                         <input type="text" autocomplete="off" name="last_name" class="form-control"
                                        placeholder="Last Name" value="{{ old('last_name') }}" required>
                      </div>
                      <button type="submit" name="register_submit" class="btn btn-primary">Register Now</button>
                   </form>
                   <div class="col-md-12">
                     <hr>
                     <a href="https://batswanagoo.co.bw/auth/google">
                        <div class="google_btn">
                            <img src="{{asset('google.png')}}" alt=""> Sign Up with Google
                        </div>
                    </a>
                    {{-- <a href="#">
                           <div class="ep_btn">
                              Email
                           </div>
                     </a> --}}
                   </div>
                   <div class="text-center crt">
                      <p>Already registered? <span class="ll-1">Login</span></p>
                   </div>
                   <!-- SOCIAL MEDIA LOGIN -->
                   <div class="soc-log">
                      <ul>
                         <li>
                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                         </li>
                      </ul>
                   </div>
                   <!-- END SOCIAL MEDIA LOGIN -->
                </div>
             </div>
             <div class="log log-3">
                <div class="login pb-5">
                   <h4>Forgot password</h4>
                   <form id="forget_form" name="forget_form" method="post"
                                action="{{ url('forgot-password') }}">
                        {{ csrf_field() }}
                      <div class="form-group">
                         <input type="email" autocomplete="off" name="email" class="form-control"
                                        pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                        placeholder="Enter email*" title="Invalid email address" required
                                        value="{{ old('email') }}">
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
@endsection

@section('customScripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const hashValue = window.location.hash.substring(1);

            if(hashValue === 'register_form'){
                setTimeout(()=>{$('.ll-2').click()},500);
            }
        });

        window.addEventListener('hashchange', () => {
            const hashValue = window.location.hash.substring(1);

            if(hashValue === 'register_form'){
                setTimeout(()=>{$('.ll-2').click()},500);
            }
        });
    </script>
@endsection
