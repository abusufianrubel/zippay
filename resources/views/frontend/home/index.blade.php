@extends('frontend.layouts.app')
@section('content')
<link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/nice-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/arafat-font.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugin/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-rtl.min.css') }}" id="rtl-stylesheet" disabled>

<style>
    /* Hide parent layout footer and extra header elements */
    .footer-sec, .bottom-footer { 
        display: none !important; 
    }
    header:not(.header-section), .navbar:not(.navbar-light) { 
        display: none !important; 
    } 

    /* Custom Slider Styles - FIXED SO CARDS ARE NEVER INVISIBLE */
    .testimonials-wrapper {
        overflow: hidden;
        width: 100%;
        position: relative;
        padding: 40px 0;
    }
    .testimonials-carousel {
        display: flex;
        transition: transform 0.4s ease-in-out;
    }
    .testimonials-carousel .single-slide {
        min-width: 33.333%;
        box-sizing: border-box;
        padding: 0 15px;
        transition: all 0.4s ease-in-out;
        opacity: 0.5; /* Safe minimum visibility */
        filter: blur(2px);
        transform: scale(0.95);
    }
    /* Highlighted center card */
    .testimonials-carousel .single-slide.active-center {
        opacity: 1 !important;
        filter: blur(0px) !important;
        transform: scale(1.05) !important;
        z-index: 2;
    }
    @media (max-width: 1199px) {
        .testimonials-carousel .single-slide { min-width: 50%; }
    }
    @media (max-width: 676px) {
        .testimonials-carousel .single-slide { 
            min-width: 100%; 
            opacity: 1; 
            filter: blur(0px); 
            transform: scale(1);
        }
    }
    .testimonial-controls {
        text-align: center;
        margin-top: 30px;
    }
    .testimonial-controls button {
        background: #6c5ce7;
        color: #fff;
        border: none;
        padding: 10px 20px;
        margin: 0 5px;
        cursor: pointer;
        border-radius: 5px;
        font-weight: 600;
    }
</style>

    <!-- Scroll To Top Start-->
    <a href="javascript:void(0)" class="scrollToTop"><i class="fas fa-angle-double-up"></i></a>
    <!-- Scroll To Top End -->

    <!-- header-section start -->
    <header class="header-section">
        <div class="overlay">
            <div class="container">
                <div class="row d-flex header-area">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="logo">
                        </a>
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar-content">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbar-content">
                            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown main-navbar">
                                    <a class="nav-link dropdown-toggle" href="{{ url('a-propos') }}">A propos</a>
                                </li>
                                <li class="nav-item dropdown main-navbar">
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
                                <a href="{{ url('login') }}" class="login">Connexion</a>
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
    <section class="banner-section index">
        <div class="overlay">
            <div class="shape-area">
                <img src="{{ asset('assets/images/banner-box.png') }}" class="obj-1" alt="image">
                <img src="{{ asset('assets/images/banner-human.png') }}" class="obj-2" alt="image">
                <img src="{{ asset('assets/images/banner-rocket.png') }}" class="obj-3" alt="image">
                <img src="{{ asset('assets/images/banner-clock.png') }}" class="obj-4" alt="image">
            </div>
            <div class="banner-content">
                <div class="container wow fadeInUp">
                    <div class="content-shape">
                        <img src="{{ asset('assets/images/banner-wallet.png') }}" class="obj-1" alt="image">
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="main-content">
                                <div class="top-area section-text">
                                    <h5 class="sub-title">Adopté par un million de clients</h5>
                                    <h1 class="title">Transfert d'argent et Change</h1>
                                    <p class="xlr">Envoyez, recevez et demandez de l'argent rapidement et facilement en ligne avec ZeLink</p>
                                </div>
                                <div class="bottom-area d-xxl-flex">
                                    <a href="{{ url('register') }}" class="cmn-btn">Ouvrir un compte</a>
                                    <a class="cmn-btn active mfp-iframe popupvideo" href="https://www.youtube.com/watch?v=Djz8Nc0Qxwk">Comment ça marche ?</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-5 col-md-6">
                            <div class="send-money">
                                <form action="#">
                                    <div class="currency-area">
                                        <div class="left-side">
                                            <span class="mdr">Vous envoyez</span>
                                            <input type="text" class="xlr" placeholder="Enter Amount" value="1000">
                                        </div>
                                        <div class="right-side">
                                            <select>
                                                <option value="1">USD</option>
                                                <option value="2">GBP</option>
                                                <option value="3">AUS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="calculation">
                                        <div class="head-area">
                                            <img src="{{ asset('assets/images/icon/conversion.png') }}" alt="image">
                                            <span class="mdr highlight">Afficher le calcul</span>    
                                        </div>
                                        <div class="calculation-details">
                                            <div class="single-area d-flex align-items-center">
                                                <div class="left-area">
                                                    <i class="fas fa-minus"></i>
                                                    <span class="mdr">10.04 USD</span>
                                                </div>
                                                <div class="right-area">
                                                    <span class="mdr">Nos frais</span>
                                                </div>
                                            </div>
                                            <div class="single-area d-flex align-items-center">
                                                <div class="left-area">
                                                    <i class="fas fa-equals"></i>
                                                    <span class="mdr">989.96 USD</span>
                                                </div>
                                                <div class="right-area">
                                                    <span class="mdr">Nous convertirons</span>
                                                </div>
                                            </div>
                                            <div class="single-area d-flex align-items-center">
                                                <div class="left-area">
                                                    <i class="fas fa-times"></i>
                                                    <span class="mdr">1.3947</span>
                                                </div>
                                                <div class="right-area">
                                                    <span class="mdr highlight">Taux ZeLink</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="currency-area">
                                        <div class="left-side">
                                            <span class="mdr">Le bénéficiaire reçoit</span>
                                            <h5>1,380.69</h5>
                                        </div>
                                        <div class="right-side recipient">
                                            <select>
                                                <option value="1">AUS</option>
                                                <option value="2">USD</option>
                                                <option value="3">GBP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="btn-area mt-40">
                                        <a href="javascript:void(0)" class="cmn-btn w-100">Démarrer</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="counter-section">
            <div class="container wow fadeInUp">
                <div class="row cus-mar">
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="single-area d-flex align-items-center justify-content-center">
                            <div class="text-area text-center">
                                <h2><span class="counter">50</span><span>+</span></h2>
                                <p>Devises supportées</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="single-area d-flex align-items-center justify-content-center">
                            <div class="text-area text-center">
                                <h2><span class="counter">100</span><span>+</span></h2>
                                <p>Pays disponibles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="single-area d-flex align-items-center justify-content-center">
                            <div class="text-area text-center">
                                <h2><span class="counter">70</span><span>+</span></h2>
                                <p>Methodes de Paiement</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="single-area d-flex align-items-center justify-content-center">
                            <div class="text-area text-center">
                                <h2><span class="counter">7</span><span>/</span><span class="counter">24</span><span>+</span></h2>
                                <p>Équipe de Soutien</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section end -->

    <!-- Global Payment start -->
    <section class="global-payment">
        <div class="overlay pt-120 pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Envoyez de l'argent en un clin d'œil</h5>
                            <h2 class="title">Le monde à votre portée</h2>
                            <p>Transférez votre argent là où cela compte. Économisez sur vos transferts internationaux dans plusieurs devises, le tout sans frais cachés.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-6 col-xl-5 order-xl-0 order-1">
                        <div class="image-area d-rtl left-side">
                            <img src="{{ asset('assets/images/global-payment-img.png') }}" alt="images" class="max-un">
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-7">
                        <div class="row cus-mar">
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/global-payment-icon-1.png') }}" alt="icon">
                                    <h5>Compte personnel</h5>
                                    <p>Votre portefeuille digitale, vous pouvez désormais demander un paiement d'une personne à une autre, en quelques secondes.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/global-payment-icon-2.png') }}" alt="icon">
                                    <h5>Compte Business</h5>
                                    <p>Créez des pages de paiement ou générez rapidement et facilement des lien de paiement à envoyer à vos clients en un clic.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/global-payment-icon-3.png') }}" alt="icon">
                                    <h5>Crypto Exchange</h5>
                                    <p>L'échange de devises est très simple et rapide. Les cryptomonnaies sont également prises en charge.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="single-item">
                                    <img src="{{ asset('assets/images/icon/global-payment-icon-4.png') }}" alt="icon">
                                    <h5>Intégration API</h5>
                                    <p>Elle gérera l'expérience de paiement de vos clients en intégrant notre interface API transparente à votre site web.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Global Payment end -->

    <!-- How it Works start -->
    <section class="how-it-works">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Comment ça marche?</h5>
                            <h2 class="title">En Quelques étapes seulement</h2>
                            <p>C'est plus facile que vous ne le pensez. Suivez 3 étapes simples.</p>
                        </div>
                    </div>
                </div>
                <div class="row cus-mar">
                    <div class="col-xl-3 col-sm-6 col-6">
                        <div class="single-item first text-center">
                            <img src="{{ asset('assets/images/icon/how-works-icon-1.png') }}" alt="icon">
                            <h5>Inscrivez-vous gratuitement</h5>
                            <p>Inscrivez-vous gratuitement en ligne et de vérifier votre identité.</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-6">
                        <div class="single-item second text-center">
                            <img src="{{ asset('assets/images/icon/how-works-icon-2.png') }}" alt="icon">
                            <h5>Configurez votre transfert</h5>
                            <p>Ajoutez les coordonnées du destinataire et choisissez la devise ...</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-6">
                        <div class="single-item first text-center">
                            <img src="{{ asset('assets/images/icon/how-works-icon-3.png') }}" alt="icon">
                            <h5>Effectuez votre paiement</h5>
                            <p>Suivez les étapes pour effectuer votre paiement en toute sécurité..</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-6">
                        <div class="single-item text-center">
                            <img src="{{ asset('assets/images/icon/how-works-icon-4.png') }}" alt="icon">
                            <h5>C'est terminé !</h5>
                            <p>Nous informerons votre destinataire qui recevra une notification ...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How it Works end -->

    <!-- App Download start -->
    <section class="app-download">
        <div class="overlay pb-120">
            <div class="container wow fadeInUp">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 order-lg-0 order-1">
                        <div class="image-area d-rtl left-side">
                            <img src="{{ asset('assets/images/app-download-img.png') }}" alt="images" class="max-un">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="section-area">
                            <h5 class="sub-title">Téléchargez notre application</h5>
                            <h2 class="title">Transferts d'argent rapides et sécurisés</h2>
                            <p>Accédez à votre compte depuis votre mobile. Consultez votre solde, effectuez vos opérations et visualisez vos transactions de partout.</p>
                        </div>
                        <ul class="features">
                            <li>
                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="icon">
                                Connexion sécurisé à double authentification.
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="icon">
                                Envoyer de l'argent en quelques clics seulement.
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="icon">
                                Consultez l'historique des transactions.
                            </li>
                            <li>
                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="icon">
                                Recevez des notifications instantanées de l'application.
                            </li>
                        </ul>
                        <div class="brand-area mt-40">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/GooglePlay-btn.png') }}" alt="icon">
                            </a>
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/apple-btn.png') }}" alt="icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- App Download end -->

    <!-- Testimonials start -->
    <section class="testimonials">
        <div class="overlay pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Témoignages</h5>
                            <h2 class="title">Ce que disent nos clients</h2>
                            <p>Plus de 02 millions de clients satisfaits à travers l'Afrique et le monde.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container-fluid wow fadeInUp">
                <div class="testimonials-wrapper">
                    <div class="testimonials-carousel" id="customTestimonialSlider">
                        <div class="single-slide">
                            <div class="single-content">
                                <div class="start-area">
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                </div>
                                <h5 class="title-area">Service excellent, rapide et fiable</h5>
                                <p class="xlr">"ZeLink a toujours été une solution fiable pour mon entreprise..."</p>
                                <div class="profile-area d-flex align-items-center">
                                    <div class="icon-area"><img src="{{ asset('assets/images/testimonials-img-1.png') }}" alt="icon"></div>
                                    <div class="text-area"><h5>Aspen Press</h5><p>Web Designer</p></div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="single-slide">
                            <div class="single-content">
                                <div class="start-area">
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                </div>
                                <h5 class="title-area">Service excellent, rapide et fiable</h5>
                                <p class="xlr">"ZeLink a toujours été une solution fiable pour mon entreprise..."</p>
                                <div class="profile-area d-flex align-items-center">
                                    <div class="icon-area"><img src="{{ asset('assets/images/testimonials-img-2.png') }}" alt="icon"></div>
                                    <div class="text-area"><h5>Courtney Henry</h5><p>Balance Studio</p></div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="single-slide">
                            <div class="single-content">
                                <div class="start-area">
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                </div>
                                <h5 class="title-area">Service excellent, rapide et fiable</h5>
                                <p class="xlr">"ZeLink a toujours été une solution fiable pour mon entreprise..."</p>
                                <div class="profile-area d-flex align-items-center">
                                    <div class="icon-area"><img src="{{ asset('assets/images/testimonials-img-3.png') }}" alt="icon"></div>
                                    <div class="text-area"><h5>Paul Howell</h5><p>President of Sales</p></div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 4 -->
                        <div class="single-slide">
                            <div class="single-content">
                                <div class="start-area">
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0)"><i class="fas fa-star"></i></a>
                                </div>
                                <h5 class="title-area">Service excellent, rapide et fiable</h5>
                                <p class="xlr">"ZeLink a toujours été une solution fiable pour mon entreprise..."</p>
                                <div class="profile-area d-flex align-items-center">
                                    <div class="icon-area"><img src="{{ asset('assets/images/testimonials-img-2.png') }}" alt="icon"></div>
                                    <div class="text-area"><h5>Courtney Henry</h5><p>Balance Studio</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Manual Next / Prev Buttons -->
                <div class="testimonial-controls">
                    <button id="customPrevBtn"><i class="fas fa-arrow-left"></i> Précédent</button>
                    <button id="customNextBtn">Suivant <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials end -->

    <!-- FAQs In start -->
    <section class="faqs-section">
        <div class="overlay pt-120 pb-120">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-7">
                        <div class="section-header text-center">
                            <h5 class="sub-title">Foire aux questions</h5>
                            <h2 class="title">Si vous avez des questions, nous avons les réponses.</h2>
                            <p>Nous avons une liste de questions fréquemment posées à notre sujet.</p>
                        </div>
                    </div>
                </div>
                <div class="row cus-mar">
                    <div class="col-lg-6">
                        <div class="accordion" id="accordionLeft">
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingLeftOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseLeftOne"
                                        aria-expanded="false" aria-controls="collapseLeftOne">
                                        Comment envoyer de l'argent en ligne?
                                    </button>
                                </h6>
                                <div id="collapseLeftOne" class="accordion-collapse collapse"
                                    aria-labelledby="headingLeftOne" data-bs-parent="#accordionLeft">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingLeftTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseLeftTwo"
                                        aria-expanded="false" aria-controls="collapseLeftTwo">
                                        Quels sont les frais de transfert d'argent ?
                                    </button>
                                </h6>
                                <div id="collapseLeftTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingLeftTwo" data-bs-parent="#accordionLeft">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingLeftThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseLeftThree"
                                        aria-expanded="false" aria-controls="collapseLeftThree">
                                        Quel est le moyen le plus rapide d'envoyer de l'argent à l'étranger ?
                                    </button>
                                </h6>
                                <div id="collapseLeftThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingLeftThree" data-bs-parent="#accordionLeft">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingLeftFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseLeftFour"
                                        aria-expanded="false" aria-controls="collapseLeftFour">
                                        Comment utiliser ZeLink?
                                    </button>
                                </h6>
                                <div id="collapseLeftFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingLeftFour" data-bs-parent="#accordionLeft">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingLeftFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseLeftFive"
                                        aria-expanded="false" aria-controls="collapseLeftFive">
                                        Comment ZeLink protège mon argent?
                                    </button>
                                </h6>
                                <div id="collapseLeftFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingLeftFive" data-bs-parent="#accordionLeft">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accordion" id="accordionRight">
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingRightOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRightOne"
                                        aria-expanded="false" aria-controls="collapseRightOne">
                                        Les applications de transfert d'argent sont-elles sûres ?
                                    </button>
                                </h6>
                                <div id="collapseRightOne" class="accordion-collapse collapse"
                                    aria-labelledby="headingRightOne" data-bs-parent="#accordionRight">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingRightTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRightTwo"
                                        aria-expanded="false" aria-controls="collapseRightTwo">
                                       Combien d'argent puis-je envoyer ?
                                    </button>
                                </h6>
                                <div id="collapseRightTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingRightTwo" data-bs-parent="#accordionRight">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingRightThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRightThree"
                                        aria-expanded="false" aria-controls="collapseRightThree">
                                        Quelle devise puis-je envoyer ?
                                    </button>
                                </h6>
                                <div id="collapseRightThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingRightThree" data-bs-parent="#accordionRight">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingRightFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRightFour"
                                        aria-expanded="false" aria-controls="collapseRightFour">
                                        Comment Annuler la transaction
                                    </button>
                                </h6>
                                <div id="collapseRightFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingRightFour" data-bs-parent="#accordionRight">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingRightFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRightFive"
                                        aria-expanded="false" aria-controls="collapseRightFive">
                                        Puis-je effectuer plusieurs paiements ?
                                    </button>
                                </h6>
                                <div id="collapseRightFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingRightFive" data-bs-parent="#accordionRight">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit posuere vel venenatis, eu sit massa. Volutpat massa rhoncus odio feugiat tellus elit massa sed ullamcorper a in.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQs In end -->

    

@section('js')
<script>
    function initTestimonialSlider() {
        const preloader = document.getElementById('preloader') || document.querySelector('.preloader');
        if (preloader) preloader.style.display = 'none';

        const slider = document.getElementById('customTestimonialSlider');
        if (!slider) {
            console.warn('[testimonial-slider] #customTestimonialSlider not found in DOM.');
            return;
        }

        const nextBtn = document.getElementById('customNextBtn');
        const prevBtn = document.getElementById('customPrevBtn');

        const originalSlides = Array.from(slider.querySelectorAll('.single-slide'));
        const total = originalSlides.length;
        const clonesCount = 3; // matches max visible count (desktop)

        // Prepend clones of the last N slides
        for (let i = total - clonesCount; i < total; i++) {
            const idx = (i + total) % total;
            const clone = originalSlides[idx].cloneNode(true);
            clone.classList.add('clone-slide');
            slider.insertBefore(clone, slider.firstChild);
        }

        // Append clones of the first N slides
        for (let i = 0; i < clonesCount; i++) {
            const clone = originalSlides[i].cloneNode(true);
            clone.classList.add('clone-slide');
            slider.appendChild(clone);
        }

        let slides = slider.querySelectorAll('.single-slide');
        let currentIndex = clonesCount; // start on the first "real" slide
        let autoplayTimer = null;
        let isAnimating = false;

        function getVisibleCount() {
            if (window.innerWidth <= 676) return 1;
            if (window.innerWidth <= 1199) return 2;
            return 3;
        }

        function setPosition(withTransition) {
            const visibleCount = getVisibleCount();
            slider.style.transition = withTransition ? 'transform 0.4s ease-in-out' : 'none';
            const percentage = currentIndex * (100 / visibleCount);
            slider.style.transform = `translateX(-${percentage}%)`;

            slides.forEach(s => s.classList.remove('active-center'));
            const centerOffset = (visibleCount === 3) ? 1 : 0;
            const centerSlide = slides[currentIndex + centerOffset];
            if (centerSlide) centerSlide.classList.add('active-center');
        }

        function handleTransitionEnd() {
            isAnimating = false;
            if (currentIndex >= total + clonesCount) {
                currentIndex -= total;
                setPosition(false);
            } else if (currentIndex < clonesCount) {
                currentIndex += total;
                setPosition(false);
            }
        }
        slider.addEventListener('transitionend', handleTransitionEnd);

        function goNext() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex++;
            setPosition(true);
        }

        function goPrev() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex--;
            setPosition(true);
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(goNext, 4000);
        }
        function stopAutoplay() {
            if (autoplayTimer) clearInterval(autoplayTimer);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();
                goNext();
                startAutoplay();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                goPrev();
                startAutoplay();
            });
        }

        window.addEventListener('resize', function () {
            setPosition(false);
        });

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        setPosition(false); // initial position, no animation
        startAutoplay();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTestimonialSlider);
    } else {
        initTestimonialSlider();
    }
</script>
@endsection
@endsection