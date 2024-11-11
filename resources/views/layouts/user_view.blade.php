@extends('layouts.header')
@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">My Account</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white"
                                    href="{{ route('home.page') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">My Account</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- my account section start -->
    <section class="my__account--section section--padding">
        <div class="container">
            <p class="account__welcome--text">Hello, {{ Auth::user()->username }} welcome to your dashboard!</p>
            <div class="my__account--section__inner border-radius-10 d-flex">
                <div class="account__left--sidebar">
                    <h2 class="account__content--title h3 mb-20">My Profile</h2>
                    <ul class="account__menu">
                        <li class="account__menu--list active"><a href="{{ route('user.dashboard') }}">Profile</a></li>
                        <li class="account__menu--list"><a href="{{ route('user.orders') }}">Your Orders</a></li>
                        <li class="account__menu--list"><a href="{{ route('user.update.profile') }}">Update Profile</a>
                        </li>
                        <li class="account__menu--list"><a href="{{ route('change.password.page') }}">Change
                                Password</a></li>
                        {{-- <li class="account__menu--list"><a href="{{ route('delete.account.page') }}">Delete Account</a> --}}
                        </li>
                        <li class="account__menu--list"><a href="{{ route('logout') }}">Logout</a></li>

                    </ul>
                </div>

@yield('user')
@endsection
