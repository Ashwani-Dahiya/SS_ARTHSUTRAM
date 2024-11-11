@extends('layouts.user_view')


@yield('content')

@section('user')
    <div class="account__wrapper">
        <div class="account__content">
            <h2 class="account__content--title h3 mb-20">Update Profile</h2>
            <form action="{{ route('profile.update.data') }}" method="POST">
                @csrf
                @method('POST')
                <div class="section__shipping--address__content">
                    <div class="row">
                        @method('POST')
                        @csrf
                        <div style="text-align: center">
                            <small class="text-danger" id="error-message"></small>
                        </div>

                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list ">
                                <label class="labels">First Name</label>
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Name" type="text"
                                        name="first_name" required value="{{ $record->first_name }}">
                                </label>
                                @if ($errors->has('first_name'))
                                    <p class="text-danger">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list ">
                                <label class="labels">Surname</label>
                                <label>
                                    <input class="checkout__input--field border-radius-5" type="text"
                                        value="{{ $record->last_name }}" placeholder="Surname" name="last_name">
                                </label>
                                @if ($errors->has('first_name'))
                                    <p class="text-danger">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list ">
                                <label class="labels">Mobile Number</label>
                                <label>
                                    <input class="checkout__input--field border-radius-5" type="text"
                                    placeholder="Enter phone number"
                                    value="{{ $record->phone }}" name="phone" required>
                                </label>
                                @if ($errors->has('phone'))
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list ">
                                <label class="labels">Mobile Number</label>
                                <label>
                                    <input class="checkout__input--field border-radius-5" type="text"
                                    placeholder="Enter email id"
                                    value="{{ $record->email }}" name="email" required>
                                </label>
                                @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 mb-12"><label class="labels">Address Line </label><input type="text"
                                class="checkout__input--field border-radius-5" placeholder="Enter address line"
                                value="{{ $record->address }}" name="address" required>
                        </div>
                        <div class="col-lg-6 mb-12"><label class="labels">Country</label>
                            <select name="country" id=""
                                class="checkout__input--field border-radius-5">
                                <option selected>{{ $record->country }}</option>
                                <option value="India" >India</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mb-12"><label class="labels">State</label>
                            <select name="state" id="" class="checkout__input--field border-radius-5">
                                <option selected>{{ $record->state }}</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if ($lastAddress && $state->id ==
                                        $lastAddress->state)
                                        selected
                                        @endif>{{ $state->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 mb-12"><label class="labels">City</label><select name="city" id=""
                                class="checkout__input--field border-radius-5">
                                <option selected>{{ $record->city }}</option>
                                @foreach ($cityNames as $cityId => $cityName)
                                    <option value="{{ $cityId }}" @if ($lastAddress &&
                                        $cityId==$lastAddress->id) selected @endif>
                                        {{ $cityName }}
                                    </option>
                                    @endforeach

                            </select>
                        </div>
                        <div class="col-lg-6 mb-12"><label class="labels">Postcode</label><input type="text"
                                class="checkout__input--field border-radius-5" name="post_code" placeholder="Enter postcode"
                                value="{{ $record->post_code }}">
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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[name="state"]').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: '/get-cities/' + stateId
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="city"]').empty();
            }
        });
    });

</script>
