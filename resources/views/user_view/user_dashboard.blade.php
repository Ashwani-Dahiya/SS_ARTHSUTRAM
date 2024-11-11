@extends('layouts.user_view')


@yield('content')

@section('user')
<div class="account__wrapper">
    <div class="account__content">
        <h2 class="account__content--title h3 mb-20">Your Profile</h2>
        <div class="row col-100 mb-minus-24 ">
            <div class="col-sm-12 cr-product-card" style="padding-left: 40px">
                <div class="row ">
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">Name</h5>
                        <p class="text-muted ">{{ $user->first_name }}
                            {{ $user->last_name }}
                        </p>
                    </div>

                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">Email</h5>
                        <p class="text-muted ">{{ $user->email }}</p>
                    </div>
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">Phone</h5>
                        <p class="text-muted ">{{ $user->phone }}</p>
                    </div>

                    <div class="col-sm-4 mt-2 mb-2" >
                        <h5 class="text-dark">Address</h5>
                        <p class="text-muted ">{{ $user->address }}</p>
                    </div>
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">City</h5>
                        <p class="text-muted ">{{ $user->city }}</p>
                    </div>
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">State</h5>
                        <p class="text-muted ">{{ $user->state }}</p>
                    </div>
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">Country</h5>
                        <p class="text-muted ">{{ $user->country }}</p>
                    </div>
                    <div class="col-sm-4 mt-2 mb-2">
                        <h5 class="text-dark">Post Code</h5>
                        <p class="text-muted ">{{ $user->post_code }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>

@endsection
