@extends('layouts.frontend')
@section('title', 'Home | Batswana Goo')
@section('content')
<!-- START -->
<section>
    <div class="all-jobs-ban">
        <div class="container">
            <div class="row">
                <div class="jtit">
                <h1>Find your needs here</h1>
                <p>Over 100,000+ items are waiting for you</p>
                </div>
                <br>
                <div class="job-sear">
                <form name="job_filter_form" id="job_filter_form" class="job_filter_form">
                    <ul>
                        <li class="sr-sea">
                            <select class="chosen-select" id="job-select-search" name="serjobs">
                            <option value="54">Software</option>
                            <option value="53">Technology</option>
                            <option value="52">Service Industry:</option>
                            <option value="51">Medical</option>
                            <option value="50">Media</option>
                            <option value="49">Law Enforcement</option>
                            <option value="48">Education</option>
                            <option value="47">Business</option>
                            <option value="46">Arts</option>
                            <option value="45">Aviation</option>
                            </select>
                        </li>
                        <li class="sr-loc">
                            <select class="chosen-select" id="job-select-city" name="serjobsloc">
                            <option value="7">New york</option>
                            <option value="9">Illunois</option>
                            <option value="10">Los Angeles</option>
                            <option value="17">Dallas</option>
                            </select>
                        </li>
                        <li class="sr-btn">
                            <button id="" type="button" onclick="return false;"><i class="material-icons">search</i></button>
                        </li>
                    </ul>
                </form>
                </div>
                <div class="ban-short-links" style="display: none;">
                <ul>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/shop.png" alt="">
                            <h4>Cars & Bakkies</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/expert.png" alt="">
                            <h4>Electronics</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/employee.png" alt="">
                            <h4>Home & Garden</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/hot-air-balloon.png" alt="">
                            <h4>Property</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/news.png" alt="">
                            <h4>Jobs</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/calendar.png" alt="">
                            <h4>Automotive Vehicles</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/cart.png" alt="">
                            <h4>Services</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/cart.png" alt="">
                            <h4>Boats</h4>
                            <a href="#" class="fclick"></a>
                        </div>
                    </li>
                    <!--<li>
                        <div>
                            <img src="{{asset('assets_frontend')}}/img/blog1.png" alt="">
                            <h4>Blogs</h4>
                            <a href="https://bizbookdirectorytemplate.com/blog-posts" class="fclick"></a>
                        </div>
                        </li>-->
                </ul>
                </div>
                <!--  <div class="job-pop-tag">
                <a href="#">Software</a>
                <a href="#">Medical</a>
                <a href="#">Aviation</a>
                <a href="#">Arts</a>
                <a href="#">Business</a>
                </div> -->
                <div class="job-counts" style="display:none;">
                <ul>
                    <li>
                        <span class="count1">05</span>
                        <h4>Job Posted</h4>
                    </li>
                    <li>
                        <span class="count1">05</span>
                        <h4>Companies</h4>
                    </li>
                    <li>
                        <span class="count1">03</span>
                        <h4>Employees</h4>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
<section class="news-hom-ban-sli">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <div class="sub-tit text-left">
                <div class="sp-t">
                    <div>
                        <h2>Sponsored ads</h2>
                        <small>Best buys in cars & bakkies</small>
                    </div>
                    <a href="listing-page.php">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                        </svg>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news-hom-ban-sli-inn">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <ul class="multiple-items1">
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/c3.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">PKR 3,000</span>
                            <h2>Like a drone that you sit in – but would you feel safe?</h2>
                            <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                        </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c1.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 4,000</span>
                                <h2>Covid: Face mask rules and Covid passes to end in World</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c2.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 8,000</span>
                                <h2>U.S. Futures Rise as Traders Mull Virus, China Vow: Markets Wrap</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c3.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 3,000</span>
                                <h2>South Georgiea: The museum at the end of the world reopens for business</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/c4.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">PKR 4,000</span>
                            <h2>Kiribatii goes into first lockdown after Covid flight cases</h2>
                            <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                        </div>
                    </a>
                    </li>
                    <li>
                        <a href="details.php">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/c5.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">PKR 6,000</span>
                            <h2>What is the expected price of Teslaa Model 3?</h2>
                            <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                        </div>
                    </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c6.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 3,000</span>
                                <h2>Amazan Alexa returns after morning snooze</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            <a href="details.php"
                                class="fclick"></a>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c6.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 3,000</span>
                                <h2>Amazan Alexa returns after morning snooze</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="details.php">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/c6.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">PKR 3,000</span>
                            <h2>Amazan Alexa returns after morning snooze</h2>
                            <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                        </div>
                    </a>
                    </li>
                    <li>
                        <a href="details.php">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/c6.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <span class="news-cate">PKR 3,000</span>
                                <h2>Amazan Alexa returns after morning snooze</h2>
                                <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span>
                            </div>
                            </div>
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="news-hom-ban-sli">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <div class="sub-tit text-left">
                <div class="sp-t">
                    <div>
                        <h2>We think you'll love these</h2>
                        <small>Our most popular categories</small>
                    </div>
                    <a href="#">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                        </svg>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news-hom-ban-sli-inn">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <ul class="multiple-items2">
                    <li>
                        <a href="#">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/b1.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <!--  <span class="news-cate">PKR 3,999</span> -->
                                <h2>Sports & Fitness Gear</h2>
                                <!-- <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/b2.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <!--  <span class="news-cate">PKR 3,999</span> -->
                                <h2>Camping Gear</h2>
                                <!-- <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/b3.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <!--  <span class="news-cate">PKR 3,999</span> -->
                                <h2>Camping Gear</h2>
                                <!-- <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                            <a href="#"
                                class="fclick"></a>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/b4.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <!--  <span class="news-cate">PKR 3,999</span> -->
                            <h2>Motorcycles & Scooters</h2>
                            <!-- <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                        </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/b5.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <!--  <span class="news-cate">PKR 3,999</span> -->
                            <h2>Motorcycles & Scooters</h2>
                            <!-- <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                        </div>
                    </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="news-hban-box">
                            <div class="im">
                                <img
                                    src="{{asset('assets_frontend')}}/img/b6.jpg"
                                    alt="">
                            </div>
                            <div class="txt">
                                <!--  <span class="news-cate">PKR 3,999</span> -->
                                <h2>Motorcycles & Scooters</h2>
                                <!-- <span
                                    class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                        <div class="news-hban-box">
                            <div class="im">
                            <img
                                src="{{asset('assets_frontend')}}/img/b7.jpg"
                                alt="">
                            </div>
                            <div class="txt">
                            <!--  <span class="news-cate">PKR 3,999</span> -->
                            <h2>Motorcycles & Scooters</h2>
                            <!-- <span
                                class="news-date"><i class="fas fa-map-marker"></i> Blueberg</span> -->
                            </div>
                        </div>
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="news-hom-all-lat">
    <div class="news-hom-all-lat-inn">
        <div class="container">
            <div class="row">
                <div class="sub-tit">
                <h2>Fresh Recommendations</h2>
                <p>Find items from different cities</p>
                </div>
                <div class="col-sm-2">
                <div class="filt-com lhs-ads lhs-ads-new">
                    <div class="ads-box1">
                        <a href="">
                            <!-- <span>Ad</span> -->
                            <img src="{{asset('assets_frontend')}}/img/add1.jpeg" alt="">
                        </a>
                    </div>
                    <div class="ads-box1">
                        <a href="">
                            <!-- <span>Ad</span> -->
                            <img class="omor-ad" src="{{asset('assets_frontend')}}/img/add2.jpeg" alt="">
                        </a>
                    </div>
                </div>
                </div>
                <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/16302pexels-markus-spiske-3970332.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 25</span>
                            <h2>Covid: Face mask rules and Covid passes to end in World</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/13439pexels-nadexriotic-3551498.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 60</span>
                            <h2>South Georgiea: The museum at the end of the $ 60 reopens for business</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/c3.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 5</span>
                            <h2>Like a drone that you sit in � but would you feel safe?</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/26117pexels-kaboompics-com-6444.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 5</span>
                            <h2>Applee AirTags - 'A perfect tool for stalking'</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/21313pexels-pixabay-248021.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 100</span>
                            <h2>Amazan Alexa returns after morning snooze</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/28270pexels-pixabay-164041.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 25</span>
                            <h2>Kiribatii goes into first lockdown after Covid flight cases</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/80044pexels-photo-1077785.jpeg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 60</span>
                            <h2>What is the expected price of Teslaa Model 3?</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/374279.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 60</span>
                            <h2>U.S. Futures Rise as Traders Mull Virus, China Vow: Markets Wrap</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/26117pexels-kaboompics-com-6444.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 5</span>
                            <h2>Applee AirTags - 'A perfect tool for stalking'</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/21313pexels-pixabay-248021.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 6</span>
                            <h2>Amazan Alexa returns after morning snooze</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/28270pexels-pixabay-164041.jpg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 25</span>
                            <h2>Kiribatii goes into first lockdown after Covid flight cases</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="news-home-box">
                            <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/80044pexels-photo-1077785.jpeg" alt="">
                            </div>
                            <div class="txt">
                            <span class="news-cate">$ 60</span>
                            <h2>What is the expected price of Teslaa Model 3?</h2>
                            <strong>$ 250</strong>
                            <span class="news-location"><img src="{{asset('assets_frontend')}}/img/icon/3.png">Karachi</span>
                            </div>
                            <a href="#" class="fclick"></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center mt-4">
                    <a href="#" class="deltabtn">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                        </svg>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
<!-- START -->
<section class="top-categoriesdiv">
    <div class="top-categories" style="padding:0px 0;">
        <div class="container">
            <div class="row">
                <div class="sub-tit">
                <h2>Our top categories</h2>
                </div>
                <div class="col-md-12">
                <div class="Wrap-top-categories">
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-car">
                            <img src="{{asset('assets_frontend')}}/img/car.png">
                        </div>
                        <span class="textWrap">Car & Bakkies</span>
                    </a>
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-tool">
                            <img src="{{asset('assets_frontend')}}/img/tool.png">
                        </div>
                        <span class="textWrap">Garden & Braai Equipment</span>
                    </a>
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-pet">
                            <img src="{{asset('assets_frontend')}}/img/pets.png">
                        </div>
                        <span class="textWrap">Pets</span>
                    </a>
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-toy">
                            <img src="{{asset('assets_frontend')}}/img/toy.png">
                        </div>
                        <span class="textWrap">Baby & Kids</span>
                    </a>
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-house">
                            <img src="{{asset('assets_frontend')}}/img/house.png">
                        </div>
                        <span class="textWrap">House & Flat Rentals</span>
                    </a>
                    <a href="#">
                        <div class="{{asset('assets_frontend')}}/img-Wrap img-Wrap-book">
                            <img src="{{asset('assets_frontend')}}/img/book.png">
                        </div>
                        <span class="textWrap">Jobs</span>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
<!-- START -->
<section>
    <div id="demo" class="carousel slide cate-sli caro-home" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <a href="#"><img src="{{asset('assets_frontend')}}/img/slid1.jpeg" alt="Los Angeles"></a>
            </div>
            <div class="carousel-item active">
                <a href="#"><img src="{{asset('assets_frontend')}}/img/slid2.jpeg" alt="Los Angeles"></a>
            </div>
        </div>
        <a class="carousel-control-prev" href="#" data-target="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#" data-target="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</section>
<!--END-->
<!-- END -->
<!-- START -->
<!--END-->
<section class="listar-sectionspace">
    <div class="news-home-box-2" style="padding: 30px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="sub-tit">
                    <h2>Browse <span> 1,032,646</span> live ads</h2>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Automotive Vehicles</h3>
                        <span class="listar-cateicon icon-foods"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Car & Bakkies</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>PlaceAuto Parts & Accessories</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Motorcycle Parts & Accessories</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Medium & Heavy Commercials</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Entertainment</h3>
                        <span class="listar-cateicon icon-entertainment"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Movie Theater</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Art Gallery</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Museum</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Stadium</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Local Services</h3>
                        <span class="listar-cateicon icon-localservice"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Motor Machine</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Car Machine</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Car Wash Station</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Electrician Shop</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Nightlife</h3>
                        <span class="listar-cateicon icon-nightlife"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Dance Floor</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Brewery</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Bar</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Pubs</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Educational</h3>
                        <span class="listar-cateicon icon-education"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>College</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>School</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Distance Learning</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Home Tutors</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Health &amp; Fitness</h3>
                        <span class="listar-cateicon icon-healthfitness"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Disease</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Drugs</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Fitness</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Nutrition</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Lodging</h3>
                        <span class="listar-cateicon icon-tourism"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Hotels</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Apartments</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Guest Room</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>City Tours</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Shops</h3>
                        <span class="listar-cateicon icon-shopping"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Bank</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Furniture</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Boutiques</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Sport Equipment</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Community</h3>
                        <span class="listar-cateicon icon-entertainment"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Activities & Hobbies</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Classes & Adult Education</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Lost & Found</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Carpool & Rideshare</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Shops</h3>
                        <span class="listar-cateicon icon-shopping"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Bank</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Furniture</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Boutiques</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Sport Equipment</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="listar-categorybox">
                    <div class="listar-categorytitle">
                        <h3>Shops</h3>
                        <span class="listar-cateicon icon-shopping"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                            <span>Bank</span>
                            <span>12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Furniture</span>
                            <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Boutiques</span>
                            <span>45</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <span>Sport Equipment</span>
                            <span>6</span>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
<section class="news-hom-all-lat news">
    <div class="news-hom-all-lat-inn">
        <div class="container">
            <div class="row">
                <div class="sub-tit text-left">
                <div class="sp-t">
                    <div>
                        <h2>Our Latest Posts</h2>
                    </div>
                    <a href="#">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                        </svg>
                    </a>
                </div>
                </div>
                <div class="row mt-3">
                <div class="col-md-4">
                    <div class="news-home-box">
                        <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/16302pexels-markus-spiske-3970332.jpg" alt="">
                        </div>
                        <div class="txt">
                            <span class="news-cate">Health</span>
                            <h2>Covid: Face mask rules and Covid passes to end in World</h2>
                            <span class="news-date">22, Jan 2022</span>
                            <span class="news-views">85 Views</span>
                        </div>
                        <a href="#" class="fclick"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-home-box">
                        <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/13439pexels-nadexriotic-3551498.jpg" alt="">
                        </div>
                        <div class="txt">
                            <span class="news-cate">World</span>
                            <h2>South Georgiea: The museum at the end of the world reopens for business</h2>
                            <span class="news-date">22, Jan 2022</span>
                            <span class="news-views">87 Views</span>
                        </div>
                        <a href="#" class="fclick"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-home-box">
                        <div class="im">
                            <img src="{{asset('assets_frontend')}}/img/90994pexels-josh-sorenson-378268.jpg" alt="">
                        </div>
                        <div class="txt">
                            <span class="news-cate">Entertainment</span>
                            <h2>Like a drone that you sit in – but would you feel safe?</h2>
                            <span class="news-date">22, Jan 2022</span>
                            <span class="news-views">91 Views</span>
                        </div>
                        <a href="#" class="fclick"></a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customScripts')
@endsection
