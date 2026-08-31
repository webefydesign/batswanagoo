<!doctype html>
<html lang="en">

<head>
  <title>
    Salonegoo
  </title>
  <!--== META TAGS ==-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="theme-color" content="#76cef1" />
  <meta property="og:image" content="" />
  <meta name="description" content="">
  <meta name="keyword" content="">
  <!--== FAV ICON(BROWSER TAB ICON) ==-->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!--== GOOGLE FONTS ==-->
  <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">
  <!--== WEB ICON FONTS ==-->
  <link rel="preload" as="font" href="css/icon.woff2" type="font/woff2" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--== CSS FILES ==-->
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/theme-color.php">
  <link rel="stylesheet" href="css/awesome.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="css/performance.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <!--  <link rel="stylesheet" href="css/fonts.css"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
  <!--    Google Analytics Code Starts-->
  <!-- Global site tag (gtag.js) - Google Analytics -->

  <style type="text/css">
    .full-bot-book {
      display: none;
    }
      body {
        background: #f0f0f0d9;
      }
    .v3-list-ql {}
  </style>
</head>

<body>
  <!--    Google Ad Sense Code Starts-->
  <!--    Google Ad Sense Code Ends-->
  <!-- Preloader -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <?php include('includes/header.php'); ?>
  <!-- START -->



  <div class="m-container" style="margin-bottom: 60px;">
    <div class="container">
       <h1> Increase your sales with SaloneGoo Premium Services! </h1>
   </div>

   
   

    <section class="pay-a">
        <div class="container">
          
            <div class="row">
              <div class="col-sm-12">
                <h4 class="text-center mt-4">Choose the right category for your ads and start selling faster</h4>
                <ul class="else-ul mb-5">
                  <li>
                    <a href="#" class="b-carsbtn">
                      <span>
                        <div class="borders"><img src="img/premium-category-real-estate.png"></div>
                        <em><small>Boost Sales in</small> Property</em>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="b-carsbtn">
                      <span>
                        <div class="borders"><img src="img/premium-category-cars.png"></div>
                        <em><small>Boost Sales in</small> Cars</em>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="#"  class="b-othersbtn">
                      <span>
                        <div class="borders"><img src="img/premium-category-others.png"></div>
                         <em><small>Boost Sales in</small> Others</em>
                      </span>
                    </a>
                  </li>
                </ul>

                <div class="hoss">
                    <a href="#">How does it work?</a>
                </div>

              </div>
            </div>
        </div>
    </section>

   


    


  </div>


  <?php include('includes/footer.php'); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/select-opt.js"></script>
  <script type="text/javascript">
    var webpage_full_link = '';
  </script>
  <script type="text/javascript">
    var login_url = 'login?src=jobs/';
  </script>
  <script src="js/slick.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/custom_validation.js"></script>




  <script type="text/javascript">
    $('.seebtn').on('click',function(){        
        $('.seebtn').toggleClass('activeShow');
        $('.lstother').toggleClass('activelstother');        
    });


    $('.plst-btn').on('click',function(){        
        $('.plst-btn').toggleClass('activelstbtn');
        $('.categorylistp').toggleClass('activecategorylst');        
    });
  </script>



    <script type="text/javascript">
       $('.table').find('tr td').on('click',function(){
        //Add Class to First TD in ROW
        $('.table').find('.superStyle').removeClass('superStyle');
        $(this).closest('tr').find("td:nth-child(1)").addClass('superStyle');

        //Add Class to Header <th> Cell above
        $('.table').find('thead th').eq($(this).index()).addClass('superStyle')
        $('.table').find('thead tr:nth-child(2) th').eq($(this).index()).addClass('superStyle')
        $('.table').find('tbody tr td.clientsmore').eq($(this).index()).addClass('superStyle')


    });
            </script>


<script> 
  $(document).ready(function() {
    $('.aa-col-plan').on('click', function() {

      $('input[name="aa-selected-plan"]').attr('checked', false);
      $('.aa-col-plan').removeClass('aa-active');
      
      let plan = 'free';
      if($(this).hasClass('aa-col-plan-vip')) plan = 'vip';
      if($(this).hasClass('aa-col-plan-premium')) plan = 'premium';
      if($(this).hasClass('aa-col-plan-gold')) plan = 'gold';
      if($(this).hasClass('aa-col-plan-diamond')) plan = 'diamond';
      if($(this).hasClass('aa-col-plan-enterprise')) plan = 'enterprise';

      $('.aa-col-plan-' + plan).addClass('aa-active');
      $('input#aa-selected-plan-' + plan).attr('checked', true);

    })
  })
  </script>

  <!-- MDB -->
</body>

</html>