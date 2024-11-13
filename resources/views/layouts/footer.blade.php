<!-- Start footer section -->
<footer class="footer__section bg__black" id="footerBg">
    <div class="container-fluid">
        <div class="main__footer d-flex justify-content-around ">
            <div class="footer__widget">
                <h2 class="footer__widget--title text-black h3">Categories
                    <button class="footer__widget--button" aria-label="footer widget button">
                        <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                            width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </button>
                </h2>
                <ul class="footer__widget--menu footer__widget--inner">
                    @foreach ($categories as $categorie)
                    <li class="footer__widget--menu__list text-black"><a class="footer__widget--menu__text"
                            href="{{ route('shop.page.find.categorie', ['catName' => $categorie->url_link]) }}">{{
                            $categorie->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__widget--menu__wrapper d-flex footer__widget--width">
                <div class="footer__widget">
                    <h2 class="footer__widget--title text-black h3">My Account
                        <button class="footer__widget--button" aria-label="footer widget button">
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                                width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                    transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </button>
                    </h2>
                    <ul class="footer__widget--menu footer__widget--inner">
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('user.dashboard') }}">My
                                Account</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('cart.page') }}">Shopping Cart</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('login') }}">Login</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('register.page') }}">Register</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('checkout.page') }}">Checkout</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('contact.page') }}">Frequently</a></li>

                        {{-- <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="wishlist.html">Wishlist</a></li> --}}
                    </ul>
                </div>
                <div class="footer__widget">
                    <h2 class="footer__widget--title text-black h3">Links
                        <button class="footer__widget--button" aria-label="footer widget button">
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                                width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                    transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </button>
                    </h2>
                    <ul class="footer__widget--menu footer__widget--inner">
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('about.page') }}">About Us</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('contact.page') }}">Contact Us</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('privacy.policy.page') }}">Privacy Policy</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('terms.conditions.page') }}">Terms & Conditions</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('returns.refunds.page') }}">Returns and refunds</a></li>
                        <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="{{ route('shipping.policy.page') }}">Shipping Policy</a></li>
                        {{-- <li class="footer__widget--menu__list"><a class="footer__widget--menu__text"
                                href="compare.html">Compare</a></li> --}}

                    </ul>
                </div>
            </div>

            <div class="footer__widget">
                <h2 class="footer__widget--title text-black h3">Contact us
                    <button class="footer__widget--button" aria-label="footer widget button">
                        <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                            width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </button>
                </h2>
                <ul class="footer__widget--menu footer__widget--inner">
                    <li class="footer__widget--menu__list text-black">Address : <a class="footer__widget--menu__text"
                            href="">{{ $comp_address }}</a></li>
                    <li class="footer__widget--menu__list text-black">Email : <a class="footer__widget--menu__text"
                            href="mailto:{{ $comp_email }}">{{ $comp_email }}</a></li>
                    <li class="footer__widget--menu__list text-black">Phone : <a class="footer__widget--menu__text"
                            href="tel:{{ $comp_mobile }}">{{ $comp_mobile }}</a></li>
                    <li class="footer__widget--menu__list text-black">GST : <a class="footer__widget--menu__text">{{
                            $comp_gst }}</a></li>

                    <div class="quickview__social d-flex align-items-center mb-15 mt-4">
                        <label class="quickview__social--title">Social</label>
                        <ul class="quickview__social--wrapper mt-0 d-flex">
                            <li class="quickview__social--list">
                                <a class="quickview__social--icon" target="_blank" href="https://www.facebook.com">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524"
                                        viewBox="0 0 7.667 16.524">
                                        <path data-name="Path 237"
                                            d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z"
                                            transform="translate(-960.13 -345.407)" fill="currentColor" />
                                    </svg>
                                    <span class="visually-hidden">Facebook</span>
                                </a>
                            </li>
                            <li class="quickview__social--list">
                                <a class="quickview__social--icon" target="_blank" href="https://www.instagram.com">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492"
                                        viewBox="0 0 19.497 19.492">
                                        <path data-name="Icon awesome-instagram"
                                            d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z"
                                            transform="translate(0.004 -1.492)" fill="currentColor" />
                                    </svg>
                                    <span class="visually-hidden">Instagram</span>
                                </a>
                            </li>
                            <li class="quickview__social--list">
                                <a class="quickview__social--icon" target="_blank" href="https://www.youtube.com">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="11.582"
                                        viewBox="0 0 16.49 11.582">
                                        <path data-name="Path 321"
                                            d="M967.759,1365.592q0,1.377-.019,1.717-.076,1.114-.151,1.622a3.981,3.981,0,0,1-.245.925,1.847,1.847,0,0,1-.453.717,2.171,2.171,0,0,1-1.151.6q-3.585.265-7.641.189-2.377-.038-3.387-.085a11.337,11.337,0,0,1-1.5-.142,2.206,2.206,0,0,1-1.113-.585,2.562,2.562,0,0,1-.528-1.037,3.523,3.523,0,0,1-.141-.585c-.032-.2-.06-.5-.085-.906a38.894,38.894,0,0,1,0-4.867l.113-.925a4.382,4.382,0,0,1,.208-.906,2.069,2.069,0,0,1,.491-.755,2.409,2.409,0,0,1,1.113-.566,19.2,19.2,0,0,1,2.292-.151q1.82-.056,3.953-.056t3.952.066q1.821.067,2.311.142a2.3,2.3,0,0,1,.726.283,1.865,1.865,0,0,1,.557.49,3.425,3.425,0,0,1,.434,1.019,5.72,5.72,0,0,1,.189,1.075q0,.095.057,1C967.752,1364.1,967.759,1364.677,967.759,1365.592Zm-7.6.925q1.49-.754,2.113-1.094l-4.434-2.339v4.66Q958.609,1367.311,960.156,1366.517Z"
                                            transform="translate(-951.269 -1359.8)" fill="currentColor" />
                                    </svg>
                                    <span class="visually-hidden">Youtube</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
            <div class="footer__widget">
                <h4 class="footer__widget--title text-black">ONLINE SHOPPING MADE EASY AT {{ $comp_name }}
                    <button class="footer__widget--button" aria-label="footer widget button">
                        <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                            width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </button>
                </h4>
                <ul class="footer__widget--menu footer__widget--inner">
                    <p class="text-muted">
                        If you would like to experience the best of online shopping for men, women and kids in India,
                        you are at the right place. {{ $comp_name }} is the ultimate destination for fashion and
                        lifestyle, being host to a wide array of merchandise including clothing, accessories, jewellery,
                        personal products and more. It is time to redefine your style statement with our treasure-trove
                        of trendy items. Our online store brings you the latest in designer products straight out of
                        fashion houses. You can shop online at {{ $comp_name }} from the comfort of your home and get
                        your favourites delivered right to your doorstep.
                    </p>
                </ul>
            </div>
            <div class="footer__widget">
                <h4 class="footer__widget--title text-black">SHOP ONLINE AT {{ $comp_name }} WITH COMPLETE CONVENIENCE
                    <button class="footer__widget--button" aria-label="footer widget button">
                        <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                            width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </button>
                </h4>
                <ul class="footer__widget--menu footer__widget--inner">
                    <p class="text-muted">
                        Another reason why {{ $comp_name }} is the best of all online stores is the complete convenience that it offers. You can view your favourite brands with price options for different products in one place. A user-friendly interface will guide you through your selection process. Comprehensive size charts, product information and high-resolution images help you make the best buying decisions. You also have the freedom to choose your payment options, be it card or cash-on-delivery. The 14-day returns policy gives you more power as a buyer. Additionally, the try-and-buy option for select products takes customer-friendliness to the next level.
                    </p>
                    <p>
                        Enjoy the hassle-free experience as you shop comfortably from your home or your workplace. You can also shop for your friends, family and loved-ones and avail our gift services for special occasions.
                    </p>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer__bottom d-flex justify-content-between align-items-center">
        <p class="copyright__content text-black m-0">Copyright © 2024 <a class="copyright__content--link"
                href="{{ route('home') }}">{{ $comp_name }}</a> . All Rights Reserved.Design By
            {{ $comp_name }}</p>
        <div class="footer__payment text-right">
            <img class="display-block" src="{{ asset('assets/img/other/safe-checkout.png') }}" alt="visa-card">
        </div>
    </div>
    </div>
</footer>
<!-- End footer section -->


<!-- Scroll top bar -->
<button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
            d="M112 244l144-144 144 144M256 120v292" />
    </svg></button>

<!-- All Script JS Plugins here  -->
<script src="{{ asset('assets/js/vendor/popper.js') }}" defer="defer"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" defer="defer"></script>
<script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/glightbox.min.js') }}"></script>
<!-- Customscript js -->
<script src="{{ asset('assets/js/nscript.js') }}"></script>

</body>

</html>
