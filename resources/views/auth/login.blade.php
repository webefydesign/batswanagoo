
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="">
    <!-- App title -->
    <title>Batswana Goo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .account-pages {
            box-shadow: 0 0px 24px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);
            border-radius: 5px;
        }

        .account-logo-box {
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }
        .account-logo-box img {
            width: 150px;
            height: 50px;
        }

        .account-content {
            padding: 30px;
        }
        .form-check label{
            font-size: 14px;
            color: rgba(0, 0, 0, 0.563);
        }
        .login-butn{
            background-color: #EC6120;
            width: 30%;
            align-items: center;
        }
        .login-butn button{
            color: #fff;
        }
        .login-butn button:hover{
            background-color: #F35864;
            color: #ffF;
        }
        .button-wrapper{
            display: flex;
            justify-content: center;
            margin-bottom: -45px;
        }

    </style>
</head>


<body class="bg-transparent">

<!-- HOME -->
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="account-pages mt-5">
                    <div class="text-center account-logo-box" style="background-color: #643a93;">
                        <a href="javascript:void(0);" class="d-inline-block">
                            <img src="{{asset('breez-logo.png')}}" alt="Batswana Goo" height="36"
                                style="background: #fff; padding: 5px; border-radius: 10px; border: 1px solid #383435;">
                        </a>
                    </div>
                    <div class="account-content bg-white">
                        <form method="POST" action="{{ route('login') }}">
                            <div class="mb-3">
                                <input id="email" type="email" class="form-control" name="email" required>
                                @csrf
                            </div>
                            <div class="mb-3">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <div class="button-wrapper">
                                <div class="login-butn d-grid">
                                    <button class="btn" type="submit">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END HOME -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>