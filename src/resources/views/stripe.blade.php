<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment - stripebaldeui</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Stripe Checkout</h2>
        <p class="text-gray-600 mb-6">Click the button below to test your Stripe Integration.</p>

        <form action="{{ route('stripe.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                Pay $10.00 Now
            </button>
        </form>
    </div>

</body>
</html>
