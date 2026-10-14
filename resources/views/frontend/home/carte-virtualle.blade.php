@extends('frontend.layouts.app')
@section('content')
<link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/nice-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/arafat-font.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-rtl.min.css') }}" id="rtl-stylesheet" disabled>

<style>
    /* by Dhananjay: hide the shared purple footer only on this page */
    .footer-sec,
    .bottom-footer {
        display: none !important;
    }
</style>

<!-- start LTR to RTL -->
    
    <!-- end LTR to RTL -->

    <!-- start preloader -->
    <div class="preloader" id="preloader"></div>
    <!-- end preloader -->

    <!-- Scroll To Top Start-->
    <a href="javascript:void(0)" class="scrollToTop"><i class="fas fa-angle-double-up"></i></a>
    <!-- Scroll To Top End -->

    <!-- header-section start -->
    <header class="header-section">
        <div class="overlay">
            <div class="container">
                <div class="row d-flex header-area">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.html">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="logo">
                         </a>
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar-content">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbar-content">
                            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                {{-- by Dhananjay: use Laravel URLs instead of static .html links so navigation works from any route --}}
                                <li class="nav-item dropdown main-navbar">
                                    {{-- <a class="nav-link dropdown-toggle" href="a-propos.html">A propos</a> --}}
                                    <a class="nav-link dropdown-toggle" href="{{ url('a-propos') }}">A propos</a>
                                </li>
                                <li class="nav-item dropdown main-navbar">
                                    {{-- <a class="nav-link dropdown-toggle" href="carte-virtuelle.html">Carte Virtuelle</a> --}}
                                    <a class="nav-link dropdown-toggle" href="{{ url('carte-virtuelle') }}">Carte Virtuelle</a>
                                </li>
                                <li class="nav-item dropdown main-navbar">
                                    <a class="nav-link dropdown-toggle" href="#">Crypto Échange</a>
                                   
                                </li>
                                <li class="nav-item dropdown main-navbar">
                                    <a class="nav-link dropdown-toggle" href="#">Aide</a>
                                    
                                </li>
                            </ul>
                            <div class="right-area header-action d-flex align-items-center max-un">
                                {{-- by Dhananjay: keep auth links using their Laravel routes --}}
                                {{-- <a href="login.html" class="login">Connexion</a> --}}
                                <a href="{{ url('login') }}" class="login">Connexion</a>
                                {{-- <a href="sign-up.html" class="cmn-btn">S'inscrire
                                    <i class="icon-d-right-arrow-2"></i>
                                </a> --}}
                                <a href="{{ url('register') }}" class="cmn-btn">S'inscrire
                                    <i class="icon-d-right-arrow-2"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- header-section end -->

    <!-- Banner Section start -->
    <section class="banner-section corporate-card">
        <div class="overlay">
            <div class="banner-content">
                <div class="container wow fadeInUp">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6 col-md-7">
                            <div class="main-content">
                                <div class="top-area section-text">
                                    <h5 class="sub-title">Solution de paiement globale qui vous libère</h5>
                                    <h1 class="title">Carte bancaire virtuelle gratuite</h1>
                                    <p class="xlr">La carte qui vous fait gagner du temps et de l'argent. Suivez vos dépenses en temps réel et obtenez du cashback sur vos achats numériques.</p>
                                </div>
                                <div class="bottom-area d-xxl-flex">
                                    {{-- by Dhananjay: use the register route instead of a static page link --}}
                                    {{-- <a href="sign-up.html" class="cmn-btn">Créer votre compte</a> --}}
                                    <a href="{{ url('register') }}" class="cmn-btn">Créer votre compte</a>
                                    <a class="cmn-btn active mfp-iframe popupvideo" href="https://www.youtube.com/watch?v=Djz8Nc0Qxwk">Comment elle fonctionne ?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section end -->

    <!-- Feature start -->
    <section class="global-payment feature">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Accédez à vos fonds encore plus rapidement</h5>
                            <h2 class="title">Un seul compte, plusieurs cartes virtuelles.</h2>
                            <p>Créez une ou plusieurs cartes virtuelles en 5 minutes pour effectuer vos achats en ligne à moindre coût. C'est simple, rapide et sûr.</p>
                        </div>
                    </div>
                </div>
                <div class="row cus-mar">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/features-corporate-icon-1.png') }}" alt="icon">
                            <h5>Gagnez du cashback</h5>
                            <p>Vous offre des récompenses. Gagnez 1 % de remise en argent.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/features-corporate-icon-2.png') }}" alt="icon">
                            <h5>Suivi des dépenses</h5>
                            <p>Recevez des notifications en temps réel du bout des doigts. Définissez des budgets à éviter.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/features-corporate-icon-3.png') }}" alt="icon">
                            <h5>Entièrement gratuit</h5>
                            <p>Aucuns frais d'inscription, annuels ou cachés. Commencez en 5 minutes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Feature end -->

    <!-- Multi Currency start -->
    <section class="multi-currency">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <div class="section-text">
                            <h5 class="sub-title">Cartes virtuelles multidevises</h5>
                            <h2 class="title">Économisez grâce à des paiements internationaux 5 fois moins chers</h2>
                            <p>Payez au tarif Visa, avec des frais réduits et transparents. Simple, rapide et transparent. Aspire a permis à plus de 10 000 chefs d'entreprise de réaliser des économies de temps et d'argent.</p>
                        </div>
                        <div class="btn-area">
                            {{-- by Dhananjay: use the register route instead of a static page link --}}
                            {{-- <a href="sign-up.html" class="cmn-btn">Ouvrir un compte</a> --}}
                            <a href="{{ url('register') }}" class="cmn-btn">Ouvrir un compte</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sec-image">
                            <img src="{{ asset('assets/images/multi-currency-img.png') }}" alt="image" class="max-un">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Multi Currency end -->

    <!-- Earn Cashback start -->
    <section class="earn-cashback">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-5 order-md-0 order-1">
                        <div class="sec-image d-rtl">
                            <img src="{{ asset('assets/images/earn-cashback-image.png') }}" alt="image" class="max-un">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-text">
                            <h5 class="sub-title">Bloquez et débloquez facilement votre carte pour éviter les débits imprévus.</h5>
                            <h2 class="title">Acheter en ligne, simplement</h2>
                            <p>Faites des achats en ligne auprès de millions de commerçants sur internet, y compris Facebook, Alibaba et bien d'autres.</p>
                        </div>
                        <div class="btn-area">
                            {{-- by Dhananjay: direct users to the register route --}}
                            {{-- <a href="#" class="cmn-btn">Créez un compte</a> --}}
                            <a href="{{ url('register') }}" class="cmn-btn">Créez un compte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Earn Cashback end -->

    <!-- Stay in Control start -->
    <section class="stay-control">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-5">
                        <div class="section-text">
                            <h5 class="sub-title">Gardez le contrôle, en temps réel</h5>
                            <h2 class="title">Pas de frais cachés, pas de surprises</h2>
                            <p>Avec les cartes virtuelle ZeLink, vous bénéficiez d'une structure de frais totalement transparente. Payez exactement ce que vous attendez, à chaque transaction.</p>
                        </div>
                        <ul>
                            <li>
                                <img src="{{ asset('assets/images/icon/stay-control-icon-1.png') }}" alt="image">
                                <p>Carte de gel</p>
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/stay-control-icon-2.png') }}" alt="image">
                                <p>Définir une limite de dépenses</p>
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/stay-control-icon-3.png') }}" alt="image">
                                <p>Carte de remplacement</p>
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/stay-control-icon-4.png') }}" alt="image">
                                <p>Carte d'annulation</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="sec-image">
                            <img src="{{ asset('assets/images/stay-control-image.png') }}" alt="image" class="max-un">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Stay in Control end -->

    <!-- Secure and integrated start -->
    <section class="secure-integrated">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-5 order-md-0 order-1">
                        <div class="sec-image d-rtl">
                            <img src="{{ asset('assets/images/secure-integrated-illu.png') }}" alt="image" class="max-un">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-text">
                            <h5 class="sub-title">Sécurisé et intégré</h5>
                            <h2 class="title">Contrôlez facilement la sécurité de vos cartes</h2>
                            <p>Annulez ou bloquez vos cartes à tout moment grâce à une protection antifraude avancée. Toutes vos transactions sont automatiquement synchronisées avec votre logiciel comptable..</p>
                        </div>
                        <div class="section-bottom">
                            <ul>
                                <li>
                                    <img src="{{ asset('assets/images/icon/check-3.png') }}" alt="icon">
                                    Gelez temporairement les cartes manquantes dans votre application ou votre tableau de bord web
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/icon/check-3.png') }}" alt="icon">
                                    Activez la sécurité basée sur la localisation pour réduire les transactions frauduleuses
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/icon/check-3.png') }}" alt="icon">
                                    Désactivez les paiements sans contact, en ligne ou par glissement lorsque cela est nécessaire pour garantir la sécurité de votre carte.
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/icon/check-3.png') }}" alt="icon">
                                    Activez ou désactivez la possibilité d'effectuer des retraits d'espèces aux distributeurs automatiques pour plus de sécurité.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Secure and integrated end -->

    <!-- Testimonials start -->
  
    <!-- App Download end -->

    <!-- Call To Action start -->
    <section class="call-action">
        <div class="overlay pt-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 text-center">
                        <div class="section-text">
                            <h2 class="title">Rejoignez ZeLink.</h2>
                            <p>cartes virtuelles instantanées pour plus de sécurité et de flexibilité — le tout configuré avec notre système de gestion des dépenses simplifié.</p>
                        </div>
                        <div class="btn-area">
                            <a href="#" class="cmn-btn">Inscrivez-vous en quelques minutes</a>
                            <a href="#" class="cmn-btn active">Parlez avec un expert</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action end -->
<span></span>
    

    <!--==================================================================-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/slick.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/counter.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/waypoint.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/plugin.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
<script>
    /* by Dhananjay: override the fallback title shown by the shared layout */
    document.title = 'Carte Virtuelle | ZeLink';
</script>
@endsection
