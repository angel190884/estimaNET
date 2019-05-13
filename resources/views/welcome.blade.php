<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Estimanet</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <!--<style>
            html, body {
                background-image: url("{{ asset('storage/imgs/fondo.jpg') }}");
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>-->
        <style>
            /*!
            * Start Bootstrap - Freelancer v5.0.4 (https://startbootstrap.com/template-overviews/freelancer)
            * Copyright 2013-2019 Start Bootstrap
            * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-freelancer/blob/master/LICENSE)
            */

            body {
            font-family: 'Lato';
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
            font-weight: 700;
            font-family: 'Montserrat';
            }

            hr.star-light,
            hr.star-dark {
            max-width: 15rem;
            padding: 0;
            text-align: center;
            border: none;
            border-top: solid 0.25rem;
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            margin-left: auto;
            margin-right: auto;
            }

            hr.star-light:after,
            hr.star-dark:after {
            position: relative;
            top: -.8em;
            display: inline-block;
            padding: 0 0.25em;
            content: '\f005';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 2em;
            }

            hr.star-light {
            border-color: #fff;
            }

            hr.star-light:after {
            color: #fff;
            background-color: #18BC9C;
            }

            hr.star-dark {
            border-color: #2C3E50;
            }

            hr.star-dark:after {
            color: #2C3E50;
            background-color: white;
            }

            section {
            padding: 6rem 0;
            }

            section h2 {
            font-size: 2.25rem;
            line-height: 2rem;
            }

            @media (min-width: 992px) {
            section h2 {
                font-size: 3rem;
                line-height: 2.5rem;
            }
            }

            .btn-xl {
            padding: 1rem 1.75rem;
            font-size: 1.25rem;
            }

            .btn-social {
            width: 3.25rem;
            height: 3.25rem;
            font-size: 1.25rem;
            line-height: 2rem;
            }

            .scroll-to-top {
            z-index: 1042;
            right: 1rem;
            bottom: 1rem;
            display: none;
            }

            .scroll-to-top a {
            width: 3.5rem;
            height: 3.5rem;
            background-color: rgba(33, 37, 41, 0.5);
            line-height: 3.1rem;
            }

            #mainNav {
            padding-top: 1rem;
            padding-bottom: 1rem;
            font-weight: 700;
            font-family: 'Montserrat';
            }

            #mainNav .navbar-brand {
            color: #fff;
            }

            #mainNav .navbar-nav {
            margin-top: 1rem;
            letter-spacing: 0.0625rem;
            }

            #mainNav .navbar-nav li.nav-item a.nav-link {
            color: #fff;
            }

            #mainNav .navbar-nav li.nav-item a.nav-link:hover {
            color: #18BC9C;
            }

            #mainNav .navbar-nav li.nav-item a.nav-link:active, #mainNav .navbar-nav li.nav-item a.nav-link:focus {
            color: #fff;
            }

            #mainNav .navbar-nav li.nav-item a.nav-link.active {
            color: #18BC9C;
            }

            #mainNav .navbar-toggler {
            font-size: 80%;
            padding: 0.8rem;
            }

            @media (min-width: 992px) {
            #mainNav {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
                -webkit-transition: padding-top 0.3s, padding-bottom 0.3s;
                transition: padding-top 0.3s, padding-bottom 0.3s;
            }
            #mainNav .navbar-brand {
                font-size: 2em;
                -webkit-transition: font-size 0.3s;
                transition: font-size 0.3s;
            }
            #mainNav .navbar-nav {
                margin-top: 0;
            }
            #mainNav .navbar-nav > li.nav-item > a.nav-link.active {
                color: #fff;
                background: #18BC9C;
            }
            #mainNav .navbar-nav > li.nav-item > a.nav-link.active:active, #mainNav .navbar-nav > li.nav-item > a.nav-link.active:focus, #mainNav .navbar-nav > li.nav-item > a.nav-link.active:hover {
                color: #fff;
                background: #18BC9C;
            }
            #mainNav.navbar-shrink {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }
            #mainNav.navbar-shrink .navbar-brand {
                font-size: 1.5em;
            }
            }

            header.masthead {
            padding-top: calc(6rem + 72px);
            padding-bottom: 6rem;
            }

            header.masthead h1 {
            font-size: 3rem;
            line-height: 3rem;
            }

            header.masthead h2 {
            font-size: 1.3rem;
            font-family: 'Lato';
            }

            @media (min-width: 992px) {
            header.masthead {
                padding-top: calc(6rem + 106px);
                padding-bottom: 6rem;
            }
            header.masthead h1 {
                font-size: 4.75em;
                line-height: 4rem;
            }
            header.masthead h2 {
                font-size: 1.75em;
            }
            }

            .portfolio {
            margin-bottom: -15px;
            }

            .portfolio .portfolio-item {
            position: relative;
            display: block;
            max-width: 25rem;
            margin-bottom: 15px;
            }

            .portfolio .portfolio-item .portfolio-item-caption {
            -webkit-transition: all ease 0.5s;
            transition: all ease 0.5s;
            opacity: 0;
            background-color: rgba(24, 188, 156, 0.9);
            }

            .portfolio .portfolio-item .portfolio-item-caption:hover {
            opacity: 1;
            }

            .portfolio .portfolio-item .portfolio-item-caption .portfolio-item-caption-content {
            font-size: 1.5rem;
            }

            @media (min-width: 576px) {
            .portfolio {
                margin-bottom: -30px;
            }
            .portfolio .portfolio-item {
                margin-bottom: 30px;
            }
            }

            .portfolio-modal .portfolio-modal-dialog {
            padding: 3rem 1rem;
            min-height: calc(100vh - 2rem);
            margin: 1rem calc(1rem - 8px);
            position: relative;
            z-index: 2;
            -webkit-box-shadow: 0 0 3rem 1rem rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 3rem 1rem rgba(0, 0, 0, 0.5);
            }

            .portfolio-modal .portfolio-modal-dialog .close-button {
            position: absolute;
            top: 2rem;
            right: 2rem;
            }

            .portfolio-modal .portfolio-modal-dialog .close-button i {
            line-height: 38px;
            }

            .portfolio-modal .portfolio-modal-dialog h2 {
            font-size: 2rem;
            }

            @media (min-width: 768px) {
            .portfolio-modal .portfolio-modal-dialog {
                min-height: 100vh;
                padding: 5rem;
                margin: 3rem calc(3rem - 8px);
            }
            .portfolio-modal .portfolio-modal-dialog h2 {
                font-size: 3rem;
            }
            }

            .floating-label-form-group {
            position: relative;
            border-bottom: 1px solid #e9ecef;
            }

            .floating-label-form-group input,
            .floating-label-form-group textarea {
            font-size: 1.5em;
            position: relative;
            z-index: 1;
            padding-right: 0;
            padding-left: 0;
            resize: none;
            border: none;
            border-radius: 0;
            background: none;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            }

            .floating-label-form-group label {
            font-size: 0.85em;
            line-height: 1.764705882em;
            position: relative;
            z-index: 0;
            top: 2em;
            display: block;
            margin: 0;
            -webkit-transition: top 0.3s ease, opacity 0.3s ease;
            transition: top 0.3s ease, opacity 0.3s ease;
            vertical-align: middle;
            vertical-align: baseline;
            opacity: 0;
            }

            .floating-label-form-group:not(:first-child) {
            padding-left: 14px;
            border-left: 1px solid #e9ecef;
            }

            .floating-label-form-group-with-value label {
            top: 0;
            opacity: 1;
            }

            .floating-label-form-group-with-focus label {
            color: #18BC9C;
            }

            form .row:first-child .floating-label-form-group {
            border-top: 1px solid #e9ecef;
            }

            .footer {
            padding-top: 5rem;
            padding-bottom: 5rem;
            background-color: #2C3E50;
            color: #fff;
            }

            .copyright {
            background-color: #1a252f;
            }

            a {
            color: #18BC9C;
            }

            a:focus, a:hover, a:active {
            color: #128f76;
            }

            .btn {
            border-width: 2px;
            }

            .bg-primary {
            background-color: #18BC9C !important;
            }

            .bg-secondary {
            background-color: #2C3E50 !important;
            }

            .text-primary {
            color: #18BC9C !important;
            }

            .text-secondary {
            color: #2C3E50 !important;
            }

            .btn-primary {
            background-color: #18BC9C;
            border-color: #18BC9C;
            }

            .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #128f76;
            border-color: #128f76;
            }

            .btn-secondary {
            background-color: #2C3E50;
            border-color: #2C3E50;
            }

            .btn-secondary:hover, .btn-secondary:focus, .btn-secondary:active {
            background-color: #1a252f;
            border-color: #1a252f;
            }

        </style>
    </head>
    <!--<body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ env('APP_NAME') }}
                </div>

                <div class="links">
                    <a href="{{ route('login') }}" title="Ingresar">Sistema Integral para el seguimiento de estimaciones en Obra.</a>
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>-->
    <body id="page-top">

            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
              <div class="container">
                    <a class="navbar-brand js-scroll-trigger" href="#page-top">EstimaNET</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                  Menu
                  <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#page-top">Inicio</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#benefit">Ventajas</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Acerca de</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Contacto</a>
                    </li>
                        @auth
                            <li class="nav-item mx-0 mx-lg-1">
                                <a href="{{ url('/home') }}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Home</a>
                            </li>    
                        @else
                            <li class="nav-item mx-0 mx-lg-1">
                                <a href="{{ route('login') }}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item mx-0 mx-lg-1">    
                                    <a href="{{ route('register') }}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Register</a>
                                </li>
                            @endif
                        @endauth
                    
                  </ul>
                </div>
              </div>
            </nav>
          
            <!-- Header -->
            <header class="masthead bg-primary text-white text-center">
              <div class="container">
                <img class="img-fluid mb-5 d-block mx-auto" src="{{ asset('storage/imgs/profile.png') }}" alt="">
                <h1 class="text-uppercase mb-0">EstimaNET</h1>
                <hr class="star-light">
                <h2 class="font-weight-light mb-0">Sistema Integral para el control de estimaciones en Obra.</h2>
              </div>
            </header>
          
            <!-- Portfolio Grid Section -->
            <section class="portfolio" id="benefit">
              <div class="container">
                <h2 class="text-center text-uppercase text-secondary mb-0">Ventajas</h2>
                <hr class="star-dark mb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-4 text-center text-secondary">
                        <h3>Control de Obra</h3>
                        <a type="button" class="d-block mx-auto" data-toggle="modal" data-target="#modal-1">
                            <img class="img-fluid" src="{{ asset('storage/imgs/cabin-min.png') }}" alt="Control de Obra">
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4 text-center text-secondary">
                        <h3>Reportes en PDF's</h3>
                        <a type="button" class="d-block mx-auto" data-toggle="modal" data-target="#modal-2">
                            <img class="img-fluid" src="{{ asset('storage/imgs/cake-min.png') }}" alt="Reportes de Avances">
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4 text-center text-secondary">
                        <h3>Seguimiento</h3>
                        <a type="button" class="d-block mx-auto" data-toggle="modal" data-target="#modal-3"> 
                            <img class="img-fluid" src="{{ asset('storage/imgs/circus-min.png') }}" alt="Seguimiento de Estimaciones">
                        </a>
                    </div>
                </div>
              </div>
            </section>
            <!-- Modal 1-->
            <div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Control de la Obra</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <h2 class="text-secondary text-uppercase mb-0 text-center">Control de Obra</h2>
                                    <hr class="star-dark mb-5">
                                    <img class="img-fluid mb-5" src="{{ asset('storage/imgs/cabin-min.png') }}" alt="">
                                    <p class="mb-5">Con tan solo unos cuantos clicks podrás llevar tu obra bajo control, 
                                            cargar tus catalogos y subir tus generadores para llenar así tus estados contables,
                                            todos los calculos son automaticos.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal 2-->
            <div class="modal fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reportes en PDF's</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <h2 class="text-secondary text-uppercase mb-0 text-center">Reportes</h2>
                                    <hr class="star-dark mb-5">
                                    <img class="img-fluid mb-5" src="{{ asset('storage/imgs/cake-min.png') }}" alt="">
                                    <p class="mb-5">Podras generar tus reportes en formato PDF.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal 3-->
            <div class="modal fade" id="modal-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Seguimiento de Estimaciones</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <h2 class="text-secondary text-uppercase mb-0 text-center">Seguimiento</h2>
                                    <hr class="star-dark mb-5">
                                    <img class="img-fluid mb-5" src="{{ asset('storage/imgs/circus-min.png') }}" alt="">
                                    <p class="mb-5">
                                            Podrás situar cualquier estimación en algún punto para tener un control mas 
                                            preciso de donde se encuentran tus estimaciones a lo largo de proceso con la dependencia.</p>
                                    <div class="col-auto">
                                        <button class="btn btn-outline-light text-black-50" title="Empresa Contratista" id="status-1"><i class="fas fa-snowplow fa-2x"></i></button>
                                        <button class="btn btn-outline-primary" title="Supervisión Externa" id="status-2"><i class="fas fa-eye fa-2x"></i></button>
                                        <button class="btn btn-outline-secondary" title="Supervisión Interna" id="status-3"><i class="fas fa-clipboard-check fa-2x"></i></button>
                                        <button class="btn btn-outline-info" title="JUD para revisión" id="status-4"><i class="fas fa-feather-alt fa-2x"></i></button>
                                        <button class="btn btn-outline-warning text-dark" title="Director de Supervisión para revisión" id="status-5"><i class="fas fa-feather fa-2x"></i></button>
                                        <button class="btn btn-outline-danger" title="Control Técnico para revisión" id="status-6"><i class="fas fa-cogs fa-2x"></i></button>
                                        <button class="btn btn-outline-dark" title="Finanzas para autorización" id="status-6"><i class="fas fa-dollar-sign fa-2x"></i></button>
                                        <button class="btn btn-outline-success" title="Pagada con CLC" id="status-6"><i class="fas fa-hand-holding-usd fa-2x"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- About Section -->
            <section class="bg-primary text-white mb-0" id="about">
              <div class="container">
                <h2 class="text-center text-uppercase text-white">Acerca de</h2>
                <hr class="star-light mb-5">
                <div class="row">
                  <div class="col-lg-4 ml-auto text-center">
                    <p class="lead">Estimanet es un software online capaz de generar el control acumulativo
                         y estados contables de tus estimaciones para así hacer que las constructoras se centren
                         en la obra.</p>
                  </div>
                  <div class="col-lg-4 mr-auto text-center">
                    <p class="lead">Las ventajas de ser en linea y responsivo es que puedes accesar desde cualquier 
                        lugar a cualquier hora y se adapata a tu dispositivo de acceso, ya sea movil o pc/mac.</p>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <a class="btn btn-xl btn-outline-light" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Entrar!
                  </a>
                </div>
              </div>
            </section>
          
            <!-- Contact Section -->
            <section id="contact">
              <div class="container">
                <h2 class="text-center text-uppercase text-dark mb-0">Contacto</h2>
                <hr class="star-dark mb-5 text-danger">
                <div class="row">
                  <div class="col-lg-8 mx-auto">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name="contact">
                      <div class="control-group bg-white m-3">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                          <label>Nombre</label>
                          <input class="form-control" id="name" type="text" placeholder="Nombre" required="required">
                          <p class="help-block text-danger"></p>
                        </div>
                      </div>
                      <div class="control-group bg-white m-3">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                          <label>Email</label>
                          <input class="form-control" id="email" type="email" placeholder="Email" required="required">
                          <p class="help-block text-danger"></p>
                        </div>
                      </div>
                      <div class="control-group bg-white m-3">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                          <label>Teléfono</label>
                          <input class="form-control" id="phone" type="tel" placeholder="Teléfono" required="required">
                          <p class="help-block text-danger"></p>
                        </div>
                      </div>
                      <div class="control-group bg-white m-3">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                          <label>Escribenos tus comentarios/dudas</label>
                          <textarea class="form-control" id="message" rows="5" placeholder="Mensaje o dudas" required="required"></textarea>
                          <p class="help-block text-danger"></p>
                        </div>
                      </div>
                      <br>
                      <div id="success"></div>
                      <div class="form-group m-3">
                        <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Enviar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </section>
          
            <!-- Footer -->
            <!-- Footer -->
            <footer class="pt-4" style="background-color: #2C3E50 !important">

                <!-- Footer Elements -->
                <div class="container text-white-50">

                    <!-- Social buttons -->
                    <ul class="list-unstyled list-inline text-center">
                    <li class="list-inline-item">
                        <a class="btn-floating btn-fb mx-1">
                            <i class="fab fa-facebook-f fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn-floating btn-tw mx-1">
                            <i class="fab fa-twitter fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn-floating btn-gplus mx-1">
                            <i class="fab fa-instagram fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn-floating btn-li mx-1">
                            <i class="fab fa-linkedin-in fa-2x"> </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn-floating btn-dribbble mx-1">
                            <i class="fab fa-chrome fa-2x"> </i>
                        </a>
                    </li>
                    </ul>
                    <!-- Social buttons -->

                </div>
                <!-- Footer Elements -->

                <!-- Copyright -->
                <div class="footer-copyright text-center text-white-50 py-3">© 2019 Copyright : 
                    <a href="#"> Adx Software S.A. de C.V.</a>
                </div>
                <!-- Copyright -->

            </footer>
            <!-- Footer -->

            <!-- Bootstrap core JavaScript -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            
            <!--<script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->
          
            <!-- Plugin JavaScript -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js "></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
          
            <!-- Contact Form JavaScript -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqBootstrapValidation/1.3.7/jqBootstrapValidation.min.js"></script>
            <!--<script src="js/contact_me.js"></script>-->
          
            <!-- Custom scripts for this template -->
            <script>
                (function($) {
                    "use strict"; // Start of use strict

                    // Smooth scrolling using jQuery easing
                    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
                        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html, body').animate({
                            scrollTop: (target.offset().top - 70)
                            }, 1000, "easeInOutExpo");
                            return false;
                        }
                        }
                    });

                    // Scroll to top button appear
                    $(document).scroll(function() {
                        var scrollDistance = $(this).scrollTop();
                        if (scrollDistance > 100) {
                        $('.scroll-to-top').fadeIn();
                        } else {
                        $('.scroll-to-top').fadeOut();
                        }
                    });

                    // Closes responsive menu when a scroll trigger link is clicked
                    $('.js-scroll-trigger').click(function() {
                        $('.navbar-collapse').collapse('hide');
                    });

                    // Activate scrollspy to add active class to navbar items on scroll
                    $('body').scrollspy({
                        target: '#mainNav',
                        offset: 80
                    });

                    // Collapse Navbar
                    var navbarCollapse = function() {
                        if ($("#mainNav").offset().top > 100) {
                        $("#mainNav").addClass("navbar-shrink");
                        } else {
                        $("#mainNav").removeClass("navbar-shrink");
                        }
                    };
                    // Collapse now if page is not at top
                    navbarCollapse();
                    // Collapse the navbar when page is scrolled
                    $(window).scroll(navbarCollapse);

                    // Modal popup$(function () {
                    $('.portfolio-item').magnificPopup({
                        type: 'inline',
                        preloader: false,
                        focus: '#username',
                        modal: true
                    });
                    $(document).on('click', '.portfolio-modal-dismiss', function(e) {
                        e.preventDefault();
                        $.magnificPopup.close();
                    });

                    // Floating label headings for the contact form
                    $(function() {
                        $("body").on("input propertychange", ".floating-label-form-group", function(e) {
                        $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
                        }).on("focus", ".floating-label-form-group", function() {
                        $(this).addClass("floating-label-form-group-with-focus");
                        }).on("blur", ".floating-label-form-group", function() {
                        $(this).removeClass("floating-label-form-group-with-focus");
                        });
                    });

                })(jQuery); // End of use strict
            </script>
            
          </body>
</html>
