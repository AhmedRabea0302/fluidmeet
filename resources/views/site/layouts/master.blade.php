<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Phrmacies | fluidmeet</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- bootstrap 3.0.2 -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->
    <link href="{{asset('assets/css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- NOTY -->
    <link href="{{asset('assets/css/noty.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Main Styles -->
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css"/>

</head>
<body>
    <div class="wrapper">

        @include('site.layouts.header')
        <div>
            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section><!-- /.content -->

        </div>

        @include('site.layouts.footer')

    </div><!-- ./wrapper -->

    <!-- JQuery -->
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/js/bootstrap.js')}}" type="text/javascript"></script>
    @yield('scripts')

    <script>
        // Preview Image
        $(".image").change(function () {

            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.imag-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]); // convert to base64 string
            }
        });
    </script>
</body>
</html>