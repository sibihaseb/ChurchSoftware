<!-- resources/views/payment.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-2xl p-8 max-w-lg w-full">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center mb-4">
            <i class="ri-hand-heart-line text-red-500 mr-2"></i> Make a Donation
        </h2>
        <p class="text-gray-600 mb-6">Your contribution of <strong>${{ $amount }}</strong> helps us make a
            difference. Thank you for your generosity!</p>

        <form id="payment-form" class="space-y-4">
            @csrf
            <input type="hidden" id="member-id" value="{{ $member->id }}">
            <input type="hidden" id="amount" value="{{ $amount }}">

            <label class="block text-gray-700 font-medium mb-2">Card Details:</label>
            <div id="card-element" class="border border-gray-300 rounded-lg p-2 mb-4"></div>

            <button type="button" id="submit-button"
                class="w-full bg-red-500 text-white font-semibold py-2 rounded-lg shadow hover:bg-red-600 transition">
                Donate ${{ $amount }} Now
            </button>
        </form>

        <p id="payment-message" class="text-center text-green-600 mt-4 hidden">Thank you for your generous donation!</p>
    </div>

    <script>
        const stripe = Stripe("{{ $stripeKey }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px'
                }
            }
        });
        cardElement.mount('#card-element');

        const paymentMessage = document.getElementById('payment-message');
        const submitButton = document.getElementById('submit-button');

        submitButton.addEventListener('click', async () => {
            const amount = document.getElementById('amount').value;

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                alert(error.message);
            } else {
                const memberId = document.getElementById('member-id').value;

                fetch(`/admin/members/${memberId}/pay`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod.id,
                            amount: amount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Payment failed: ' + data.error);
                        } else {
                            paymentMessage.classList.remove('hidden');
                            paymentMessage.textContent = data.message;

                            // Redirect to a new page after successful payment
                            setTimeout(() => {
                                window.location.href = '/admin/invoice';
                            }, 3000); // Delay of 2 seconds before redirecting
                        }
                    })
                    .catch(error => {
                        alert('Payment failed. Please try again.');
                        console.error(error);
                    });
            }
        });
    </script>
</body>

</html>
