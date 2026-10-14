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
    <section class="banner-section payment">
        <div class="overlay">
            <div class="shape-area">
                <img src="{{ asset('assets/images/payment-illus-2.png') }}" class="obj-1" alt="image">
                <img src="{{ asset('assets/images/payment-illus.png') }}" class="obj-2" alt="image">
            </div>
            <div class="banner-content">
                <div class="container wow fadeInUp">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6 col-md-7">
                            <div class="main-content">
                                <div class="top-area section-text">
                                    <h5 class="sub-title">Transfert d'argent et Change</h5>
                                    <h1 class="title">Nous sommes ZeLink GROUP</h1>
                                    <p class="xlr">Notre Mission est apporter des solutions innovantes dans le secteur financier pour les particuliers et les entreprises.</p>
                                </div>
                                <div class="bottom-area d-xxl-flex">
                                    {{-- by Dhananjay: use the register route instead of a static page link --}}
                                    {{-- <a href="sign-up.html" class="cmn-btn">Créer un compte</a> --}}
                                    <a href="{{ url('register') }}" class="cmn-btn">Créer un compte</a>
                                    <a class="cmn-btn active mfp-iframe popupvideo" href="https://www.youtube.com/watch?v=Djz8Nc0Qxwk">Comment ça marche?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section end -->

    <!-- Features start -->
    <section class="global-payment features">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-5 order-xl-0 order-1">
                        <div class="image-area d-rtl left-side">
                            <img src="{{ asset('assets/images/global-payment-2.png') }}" alt="images" class="max-un">
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-7">
                        <div class="row cus-mar">
                            <div class="col-lg-12">
                                <div class="section-header">
                                    <h5 class="sub-title">Tout le savoir dans le domaine du Fintech</h5>
                                    <h2 class="title">Nous avons la technologie et des partenaires solides</h2>
                                    <p>Notre rôle est de permettre à tous d'effectuer des paiements et des encaissements internationaux, facilement et efficacement et en toute sécurité.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/features-icon-1.png') }}" alt="icon">
                                    <h5>Moins cher que les banques</h5>
                                    <p>Réalisez des économies importantes sur vos paiements.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/features-icon-2.png') }}" alt="icon">
                                    <h5>Plus rapide que les banques</h5>
                                    <p>Un traitement plus rapide des envois ou des demandes.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/features-icon-3.png') }}" alt="icon">
                                    <h5>Portée mondiale</h5>
                                    <p>Vous êtes en déplacement avec votre portefeuille.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/features-icon-4.png') }}" alt="icon">
                                    <h5>Un support local</h5>
                                    <p>Bénéficiez du soutien total en toute sérénité.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features end -->

    <!-- More Features start -->
    <section class="more-features">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-xl-6 text-center">
                        <div class="section-header dark-sec">
                            <h5 class="sub-title">Simple, rapide et puissant</h5>
                            <h2 class="title">La plateforme pour aider votre entreprise à se développer</h2>
                            <p>ZeLink GROUP met à votre disposition une seule plateforme pour accepter les paiements, protéger vos revenus et contrôler vos finances.</p>
                        </div>
                    </div>
                </div>
                <div class="row cus-mar">
                    <div class="col-md-4 col-sm-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/more-features-icon-1.png') }}" alt="icon">
                            <h5>Couverture mondiale</h5>
                            <p>Développez-vous sur les marchés internationaux en acceptant les paiements où que soient vos clients, via leurs moyens de paiement préférés...</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/more-features-icon-2.png') }}" alt="icon">
                            <h5>Intégration simple</h5>
                            <p>Accédez à notre plateforme de paiement via une intégration API simple, via votre panier d'achat ou votre site web.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/more-features-icon-3.png') }}" alt="icon">
                            <h5>Scalable</h5>
                            <p>Nous avons construit dès le départ une infrastructure hautement évolutive axée sur la sécurité, la stabilité et la rapidité.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- More Features end -->

    <!-- Accept Payments Everywhere start -->
    <section class="accept-payments">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-lg-0 order-1">
                        <div class="image-area d-rtl left-side">
                            <img src="{{ asset('assets/images/accept-payment-img.png') }}" alt="images" class="max-un">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-header">
                            <h5 class="sub-title">La plateforme pour aider votre entreprise à se développer</h5>
                            <h2 class="title">Acceptez les paiements partout et depuis n'importe où</h2>
                            <p>Laissez vos clients payer où et comme ils le souhaitent. Collaborez avec un seul prestataire pour accepter, traiter et encaisser les paiements.</p>
                        </div>
                        <div class="main-content">
                            <div class="single-item">
                                <h5>Paiements en ligne ›</h5>
                                <p>Acceptez les cartes, les portefeuilles mobiles et plus encore sur n'importe quel canal ou appareil numérique.</p>
                            </div>
                            <div class="single-item">
                                <h5>Paiements en personne ›</h5>
                                <p>Optimisez votre système de point de vente et choisissez un terminal adapté à tous vos besoins.</p>
                            </div>
                            <div class="single-item">
                                <h5>Commerce unifié ›</h5>
                                <p>Centralisez vos données de paiement en ligne et en magasin dans un seul système.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Accept Payments Everywhere end -->

    <!-- Business Model start -->
    <!-- <section class="our-solutions business-model">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header dark-sec text-center">
                            <h5 class="sub-title">Solutions built for your business model</h5>
                            <h2 class="title">All-in-one finance for growing businesses</h2>
                            <p>Save time and money with borderless payments, corporate cards, expense management, and more. All in one account.</p>
                        </div>
                    </div>
                </div>
                <div class="row cus-mar">
                    <div class="col-xl-4 col-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/business-model-icon-1.png') }}" alt="icon">
                            <h5>Open an Account</h5>
                            <p>Get an account number and virtual card instantly upon approval. Manage it all from your..</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/business-model-icon-2.png') }}" alt="icon">
                            <h5>No hidden fees</h5>
                            <p>Enjoy the lowest transfer fees in the market with transparent pricing and no monthly fees.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-6">
                        <div class="single-item">
                            <img src="{{ asset('assets/images/icon/business-model-icon-3.png') }}" alt="icon">
                            <h5>All in one place</h5>
                            <p>No need for separate accounts, cards, or software. Scale faster with a fully integrated..</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Business Model end -->

    <!-- Features built for business start -->
    <section class="features-built">
        <div class="overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Des fonctionnalités conçues pour les entreprises</h5>
                            <h2 class="title">Faites des affaires en toute confiance</h2>
                            <p>Faites de ZeLink la plateforme centrale de vos paiements et encaissements transfrontaliers et multidevises et bénéficiez de notre interface utilisateur intuitive et de notre suivi des paiements.</p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-xl-6 cus-mar">
                        <div class="single-area">
                            <div class="icon-area">
                                <img src="{{ asset('assets/images/icon/features-built-icon-1.png') }}" alt="icon">
                            </div>
                            <div class="text-area">
                                <h5>La sécurité est au cœur de notre activité.</h5>
                                <p>Tous nos comptes sont activés par l'authentification à deux facteurs afin de garantir des transactions ultra-sécurisées.</p>
                            </div>
                        </div>
                        <div class="single-area">
                            <div class="icon-area">
                                <img src="{{ asset('assets/images/icon/features-built-icon-2.png') }}" alt="icon">
                            </div>
                            <div class="text-area">
                                <h5>Vos données sont protégées</h5>
                                <p>Tous nos comptes sont activés par l'authentification à deux facteurs afin de garantir des transactions ultra-sécurisées.</p>
                            </div>
                        </div>
                        <div class="single-area">
                            <div class="icon-area">
                                <img src="{{ asset('assets/images/icon/features-built-icon-3.png') }}" alt="icon">
                            </div>
                            <div class="text-area">
                                <h5>Le service à la clientèle est notre priorité</h5>
                                <p>Tous nos comptes sont activés par l'authentification à deux facteurs afin de garantir des transactions ultra-sécurisées.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 text-center">
                        <div class="image-area">
                            <img src="{{ asset('assets/images/features-built-frame.png') }}" alt="images" class="max-un">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features built for business end -->
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
    document.title = 'À Propos | ZeLink';
</script>
@endsection
