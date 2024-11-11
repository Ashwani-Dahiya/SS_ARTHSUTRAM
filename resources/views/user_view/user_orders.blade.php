@extends('layouts.user_view')


@yield('content')

@section('user')
<div class="account__wrapper">
    <div class="account__content">
        <h2 class="account__content--title h3 mb-20">Orders History</h2>
        <div class="account__table--area">
            @if($orders->isNotEmpty())
            <table class="account__table">
                <thead class="account__table--header">
                    <tr class="account__table--header__child">
                        <th class="account__table--header__child--items">Sr. No.</th>
                        <th class="account__table--header__child--items">Order ID</th>
                        <th class="account__table--header__child--items">Total Price</th>
                        <th class="account__table--header__child--items">Order Status</th>
                        <th class="account__table--header__child--items">Order Date</th>
                        <th class="account__table--header__child--items">Action</th>
                    </tr>
                </thead>

                <tbody class="account__table--body mobile__none">
                    @php
                    $i=0;
                    @endphp
                    @foreach ($orders as $order)
                    @php
                    $i++;
                    @endphp
                    <tr class="account__table--body__child">
                        <td class="account__table--body__child--items">
                            {{ $i }}
                        </td>
                        <td class="account__table--body__child--items">
                            {{ $order->order_num }}
                        </td>
                        <td class="cr-cart-price">
                            ₹ {{ $order->price_after_coupon }}
                        </td>
                        <td class="account__table--body__child--items">
                            {{ $order->order_status }}
                        </td>
                        <td class="account__table--body__child--items">
                            {{ optional($order->created_at)->format('g:i:s A d-m-Y ') }}
                        </td>
                        <td class="account__table--body__child--items">
                            <style>
                                .button {
                                    padding: 7px;
                                    font-size: 16px;
                                    border-radius: 2px;
                                    border: none;
                                    margin: 5px;
                                }
                            </style>
                            <div class="d-flex algin-items-center">
                                <a href="{{ route('user.view.order.details',['id'=>$order->id]) }}"
                                    class="button text-white"
                                    style="background-color: #64b496; text-decoration:none;">view
                                </a>
                                <br>
                                @if ($order->order_status != 'cancelled' && $order->order_status !=
                                'delivered')
                                <button type="button" class="button bg-danger text-white" data-bs-toggle="myModal"
                                    data-bs-target="#myModal">Cancel</button>
                                @endif
                            </div>

                        </td>
                    </tr>
                    @endforeach


                </tbody>
                @php
                $i=0;
                @endphp
                @foreach ($orders as $order)
                @php
                $i++;
                @endphp
                <tbody class="account__table--body mobile__block">

                    <tr class="account__table--body__child">
                        <td class="account__table--body__child--items">
                            <strong>Sr. No.</strong>
                            <span>{{ $i }}</span>
                        </td>
                        <td class="account__table--body__child--items">
                            <strong>Order ID</strong>
                            <span>{{ $order->order_num }}</span>
                        </td>
                        <td class="account__table--body__child--items">
                            <strong>Total Price</strong>
                            <span>₹ {{ $order->price_after_coupon }}</span>
                        </td>
                        <td class="account__table--body__child--items">
                            <strong>Order Status</strong>
                            <span>{{ $order->order_status }}</span>
                        </td>
                        <td class="account__table--body__child--items">
                            <strong>Order Date</strong>
                            <span>{{ optional($order->created_at)->format('g:i:s A d-m-Y ') }}</span>
                        </td>
                        <td class="account__table--body__child--items">
                            <strong>Action</strong>
                            <span>
                                <style>
                                    .buttonmob {
                                        padding: 5px;
                                        font-size: 14px;
                                        border-radius: 9px;
                                        border: none;
                                        margin: 3px;
                                    }
                                </style>
                                <div class="d-flex algin-items-center">
                                    <a href="{{ route('user.view.order.details',['id'=>$order->id]) }}"
                                        class="buttonmob text-white"
                                        style="background-color: #64b496; text-decoration:none;">view
                                    </a>
                                    <br>
                                    @if ($order->order_status != 'cancelled' && $order->order_status !=
                                    'delivered')
                                    <button type="button" class="buttonmob bg-danger text-white"
                                        data-bs-toggle="myModal" data-bs-target="#myModal">Cancel</button>
                                    @endif
                                </div>
                            </span>
                        </td>
                    </tr>

                </tbody>
                @endforeach
            </table>
            @else
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <h6 class="display-6">No Order Found !</h6>
                    <div class="cr-cart-update-bottom d-flex justify-content-end">
                        <a href="{{ route('home') }}" class="cr-links">Continue Shopping</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
</section>



@foreach ($orders as $order)
<!-- The Modal -->

<div class="modal fade" id="myModal{{$order->id }}" tabindex="-1" aria-labelledby="myModal{{$order->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $order->order_num }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <h5 class="text-center">Why you cancel this order ?</h5>
                </div>
                <form action="{{ route('user.cancel.order',['id'=>$order->id]) }}" method="POST">
                    @csrf
                    <div class="form-group col-md-12">
                        <label for="exampleFormControlSelect1" id="selectLabel{{$order->id}}">Select your reason</label>
                        <select class="form-control" name="reason" id="select{{$order->id}}">
                            <option selected>Select</option>
                            @foreach ($reasons as $reason )
                            <option>{{ $reason->reason }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group mt-4 mb-4">
                        <label class="form-check-label">Other </label>
                        <input class="form-check-input" type="checkbox" id="check{{$order->id}}">


                    </div>
                    <div id="textArea{{$order->id}}" style="display: none;">
                        <textarea class="form-control" name="reason"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="button bg-danger text-white">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>




<script>
    // JavaScript code to show/hide textarea based on checkbox state
    document.getElementById('check{{$order->id}}').addEventListener('change', function() {
        var selectLabel = document.getElementById('selectLabel{{$order->id}}');
        var select = document.getElementById('select{{$order->id}}');
        var textArea = document.getElementById('textArea{{$order->id}}');

        if (this.checked) {
            selectLabel.style.display = 'none';
            select.style.display = 'none';
            textArea.style.display = 'block';
        } else {
            selectLabel.style.display = 'block';
            select.style.display = 'block';
            textArea.style.display = 'none';
        }
    });

</script>


@endforeach


@endsection
