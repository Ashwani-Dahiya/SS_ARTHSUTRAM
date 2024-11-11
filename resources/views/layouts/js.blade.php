<div class="cr-wish-notify d-none" id="wishNotification">
    <p class="wish-note">Add product in <a href="{{ route('cart.page') }}">Cart</a> Successfully!</p>
</div>
<div id="sessionStatus" data-status="{{ session('add-to-cart-success') }}"></div>
@if (session('order-placed'))
<div class="cr-wish-notify" id="orderPlacedNotification">
    <p class="wish-note">Your Order Placed <a href="{{ route('user.dashboard') }}">Successfully!</a></p>
</div>
@endif

<script>
    $(document).ready(function() {
        // $(".addToCartBtn").click(function(event) {
        //     event.preventDefault(); // Prevent the default link behavior
        //     var id = $(this).data("id"); // Get the item ID from the data attribute
        //     $.get("/cart/" + id, function(response) {
        //         console.log(response);
        //         // Handle the response here
        //         // For example, update the UI based on the response
        //         if (response.success) {
        //             // Item added successfully, update cart count badge
        //             updateCartCount();
        //             $("#wishNotification").removeClass("d-none");
        //             setTimeout(function() {
        //                 $("#wishNotification").removeClass("d-none").stop(true, true).fadeIn(0).delay(1000).fadeOut(1000);
        //             }, 1000);
        //         } else {
        //             // Item not added, handle accordingly
        //             alert("Failed to add item to cart.");
        //         }
        //     }).fail(function(xhr, status, error) {
        //         console.error(xhr.responseText);
        //         // Handle error response here
        //     });
        // });

        var status = $("#sessionStatus").data("status");
    if (status === 'success-cart') {
        // Item added successfully, update cart count badge
        updateCartCount();
        $("#wishNotification").removeClass("d-none");
        setTimeout(function() {
            $("#wishNotification").removeClass("d-none").stop(true, true).fadeIn(0).delay(1000).fadeOut(1000);
        }, 1000);
    }

        // Function to update cart count badge
        function updateCartCount() {
            $.get('{{ route('cart.count') }}', function(response) {
                if (response.success) {
                    var cartCount = response.cartCount;

                    // Update cart count badge
                    if (cartCount > 0) {
                        $("#cartBadge")
                            .text(cartCount < 10 ? cartCount : "9+")
                            .show();
                        $("#mobcartBadge")
                            .text(cartCount < 10 ? cartCount : "9+")
                            .show();
                        $("#mobcartBadge2")
                            .text(cartCount < 10 ? cartCount : "9+")
                            .show();
                    } else {
                        $("#cartBadge").hide();
                        $("#mobcartBadge").hide();
                        $("#mobcartBadge2").hide();
                    }
                } else {
                    console.error("Failed to fetch cart count");
                }
            }).fail(function(xhr, status, error) {
                console.error("Error fetching cart count:", error);
            });
        }

        // Update cart count initially on page load
        updateCartCount();

        // Handle the click event for the cart link
        $("#cartLink").click(function(event) {
            // Update cart count badge before navigating to cart page
            updateCartCount();
        });

        // Automatically hide the order placed notification after 3 seconds
        @if (session('order-placed'))
            setTimeout(function() {
                $("#orderPlacedNotification").fadeOut();
            }, 3000);
        @endif
    });
</script>
