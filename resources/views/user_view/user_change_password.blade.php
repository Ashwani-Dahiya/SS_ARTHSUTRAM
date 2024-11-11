@extends('layouts.user_view')



@yield('content')

@section('user')
@if (session('error'))
<script>
    window.onload = function() {
            window.alert("{{session('error')  }}");
        };
</script>
@endif


@if (session('success'))
<script>
    window.onload = function() {
            window.alert("{{session('sucess') }}");
        };
</script>
@endif

<div class="account__wrapper">
    <div class="account__content">
        <h2 class="account__content--title h3 mb-20">Update Password</h2>
        <form action="{{ route('change.password') }}" method="POST">
            <div class="section__shipping--address__content">
                <div class="row">
                    @method('POST')
                    @csrf
                    <div style="text-align: center">
                        <small class="text-danger" id="error-message"></small>
                    </div>

                    <div class="col-lg-6 mb-12">
                        <div class="checkout__input--list ">
                            <label>
                                <input class="checkout__input--field border-radius-5"
                                    placeholder="Enter Your Current Password" type="password" name="currentPassword"
                                    required>
                            </label>
                            @if ($errors->has('currentPassword'))
                            <p class="text-danger">{{ $errors->first('currentPassword') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 mb-12">
                        <div class="checkout__input--list ">
                            <label>
                                <input class="checkout__input--field border-radius-5" placeholder="New Password*"
                                    type="password" name="password" required>
                            </label>
                            @if ($errors->has('password'))
                            <p class="text-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 mb-12">
                        <div class="checkout__input--list ">
                            <label>
                                <input class="checkout__input--field border-radius-5" placeholder="Cofirm New Password*"
                                    type="password" name="password_confirmation" required>
                            </label>
                            @if ($errors->has('password_confirmation'))
                            <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="login-buttons">
                        <button type="submit"
                            class="continue__shipping--btn primary__btn border-radius-5">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</section>


</main>
@endsection
