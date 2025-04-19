{{-- <footer>
  <div class="container">
      <div class="row">
          <div class="col-md-12">
             <p class="copyright">{{ __('Copyright') }} &nbsp;&copy; {{ date('Y') }} &nbsp; {{ settings('name') }} | {{ __('All Rights Reserved.') }}</p>
          </div>
      </div>
  </div>
</footer> --}}

<footer class="footer-section">
    <div class="overlay pt-120 pb-120">
        <div class="container">
            <div class="row wrapper">
                <div class="col-lg-3 col-md-6">
                    <div class="single-area">
                        <h5>COMPANY</h5>
                        <ul class="items">
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="our-team.html">Management Team</a></li>
                            <li><a href="careers.html">Careers</a></li>
                            <li><a href="reviews.html">Customer Reviews</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-area">
                        <h5>Solutions</h5>
                        <ul class="items">
                            <li><a href="index-4.html">Transfer Money Abroad</a></li>
                            <li><a href="index-5.html">Receive Money</a></li>
                            <li><a href="index-2.html">Currency Converter</a></li>
                            <li><a href="index-2.html">Rate Alerts</a></li>
                            <li><a href="index-6.html">Payment for Shopping</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="single-area">
                        <h5>Support</h5>
                        <ul class="items">
                            <li><a href="help-center.html">Help centre</a></li>
                            <li><a href="fees.html">Our fees</a></li>
                            <li><a href="faqs.html">FAQs</a></li>
                            <li><a href="login.html">Your account</a></li>
                            <li><a href="how-works.html">How it works</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-area">
                        <h5>Subscribe to our news</h5>
                        <p>Get the latest happenings and tips from Paylio</p>
                        <form action="#">
                            <div class="subscribe d-flex">
                                <input type="email" placeholder="Your Email Address">
                                <button><img src="{{ asset('public/frontend') }}/assets/img/send.png" alt="icon"></button>
                            </div>
                        </form>
                        <div class="social">
                            <ul class="d-flex">
                                <li><a href="javascript:void(0)"><img src="{{ asset('public/frontend') }}/assets/img/facebook.png" alt="icon"></a></li>
                                <li><a href="javascript:void(0)"><img src="{{ asset('public/frontend') }}/assets/img/twitter.png" alt="icon"></a></li>
                                <li><a href="javascript:void(0)"><img src="{{ asset('public/frontend') }}/assets/img/instagram.png" alt="icon"></a></li>
                                <li><a href="javascript:void(0)"><img src="{{ asset('public/frontend') }}/assets/img/linkedin.png" alt="icon"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="main-content">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-6 col-md-8 cus-order d-flex justify-content-md-start justify-content-center">
                        <div class="left-area">
                            <p class="mdr">PAYLIO © <span class="currentYear">2024</span>. ALL RIGHTS RESERVED. <span>|</span> Designed by
                                <a href="https://themeforest.net/user/pixelaxis">Pixelasis</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 d-flex justify-content-md-end justify-content-center">
                        <div class="right-area">
                            <select name="lang">
                                @foreach (getLanguagesListAtFooterFrontEnd() as $lang)
                                <option {{ session('dflt_lang') == $lang->short_name ? 'selected' : '' }} value='{{ $lang->short_name }}'>{{ $lang->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>