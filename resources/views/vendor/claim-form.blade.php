@extends('layouts.userapp')

@section('page-title', 'Claim Your Business')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-pink-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Important Notice --}}
        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-blue-900">Valid Claim Token Required</h3>
                    <p class="text-blue-800 text-sm">You have a valid claim token - you may now proceed with the claim process below.</p>
                </div>
            </div>
        </div>

        {{-- Vendor Preview Card --}}
        <div class="bg-white rounded-xl shadow-lg border-2 border-pink-200 overflow-hidden mb-8">
            <div class="h-48 bg-gradient-to-r from-rose-400 to-pink-400 flex items-center justify-center">
                @if($vendor->banner_url)
                    <img src="{{ asset('image/' . $vendor->banner_url) }}" alt="{{ $vendor->vendor_name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-white text-center">
                        <svg class="w-24 h-24 mx-auto opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="font-semibold">No Banner Image</p>
                    </div>
                @endif
            </div>

            <div class="p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $vendor->vendor_name }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                {{ $vendor->city }}, {{ $vendor->state }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.72.827 1.365 1.425 1.996 1.356-1.372 2.809-3.144 3.97-5.195l1.547.773a1 1 0 01-.54 1.06l-.74 4.435A1 1 0 018.153 17H6a1 1 0 01-1-1V4a1 1 0 011-1h.5V2H5a1 1 0 01-1-1z"/></svg>
                                {{ $vendor->phone }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 mb-2">Category</div>
                        <div class="inline-block bg-rose-100 text-rose-700 font-semibold px-4 py-2 rounded-full text-sm">
                            {{ $vendor->category }}
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">About This Business</h3>
                    <p class="text-gray-600">{{ $vendor->description ?: 'No description provided.' }}</p>
                </div>

                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                    <div>
                        <div class="text-sm text-gray-500">Starting Price</div>
                        <div class="text-xl font-bold text-rose-600">RM {{ number_format($vendor->starting_price, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Rating</div>
                        <div class="flex items-center gap-2">
                            @if($vendor->rating_count > 0)
                                <span class="text-xl font-bold">{{ number_format($vendor->rating_average, 1) }}/5.0</span>
                                <span class="text-sm text-gray-600">({{ $vendor->rating_count }} reviews)</span>
                            @else
                                <span class="text-gray-600">No ratings yet</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Email</div>
                        <a href="mailto:{{ $vendor->email }}" class="text-rose-600 hover:underline">{{ $vendor->email }}</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Claim Form --}}
        <div class="bg-white rounded-xl shadow-lg border-2 border-pink-200 p-8">
            <h2 class="text-2xl font-bold text-rose-700 mb-6">Claim This Business</h2>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <h3 class="font-semibold text-red-700 mb-2">Errors:</h3>
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="claimForm" method="POST" action="{{ route('vendor.claim.process') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $claimToken->token }}">

                {{-- Account Registration --}}
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
                    <h3 class="font-semibold text-blue-900 mb-2">Create Your Vendor Account</h3>
                    <p class="text-blue-800 text-sm">To claim this business, please create a new vendor account below. A confirmation email with a verification link will be sent to you.</p>
                </div>

                {{-- Register Fields --}}
                <div id="registerFields" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Business Name</label>
                        <input type="text" value="{{ $vendor->vendor_name }}" class="w-full border-2 border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-600 cursor-not-allowed" disabled readonly>
                        <input type="hidden" name="name" value="{{ $vendor->vendor_name }}">
                        <p class="text-xs text-gray-500 mt-1">Auto-filled from your business profile</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" value="{{ $vendor->email }}" class="w-full border-2 border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-600 cursor-not-allowed" disabled readonly>
                        <input type="hidden" name="email" value="{{ $vendor->email }}">
                        <p class="text-xs text-gray-500 mt-1">Auto-filled from your business profile</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" placeholder="Create a password" required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" placeholder="Confirm your password" required>
                    </div>
                </div>

                {{-- Hidden field to indicate registration method --}}
                <input type="hidden" name="login_method" value="register">

                {{-- Terms --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agree_terms" required class="w-4 h-4 text-rose-600 mt-1">
                        <span class="text-sm text-gray-700">
                            I agree to the Jom Kahwin vendor terms and conditions and confirm that I am authorized to claim this business.
                        </span>
                    </label>
                    @error('agree_terms')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Payment Section --}}
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-4">💳 Account Activation Fee</h3>
                    
                    <div class="bg-white rounded-lg p-4 mb-4 border border-blue-300">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Business Profile Activation Fee:</span>
                            <span class="text-2xl font-bold text-blue-600">RM 99.00</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">This one-time fee activates your claimed business profile on our platform.</p>
                    </div>

                    {{-- Card Payment Form --}}
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Card Holder Name</label>
                            <input type="text" id="cardHolderName" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" placeholder="John Doe" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Card Number</label>
                            <input type="text" id="cardNumber" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" placeholder="4532 1234 5678 9010" maxlength="19" oninput="formatCardNumber(this)" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                                <input type="text" id="expiryDate" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" placeholder="MM/YY" maxlength="5" oninput="formatExpiryDate(this)" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                                <input type="text" id="cvv" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" placeholder="123" maxlength="3" required>
                            </div>
                        </div>

                        <p class="text-xs text-gray-600 bg-blue-50 p-3 rounded border border-blue-200">
                            ✓ This is a test payment form. Use any valid card format for demonstration. Your card information is securely processed.
                        </p>
                    </div>

                    <input type="hidden" id="paymentToken" name="payment_token" value="">
                </div>

                {{-- Submit --}}
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('vendor.claim-landing') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                    <button type="button" id="paymentBtn" onclick="processPayment(event)" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition">
                        Process Payment & Claim Business
                    </button>
                </div>
            </form>
        </div>

        {{-- Payment Processing Modal --}}
        <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[10000] p-4">
            <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl text-center">
                <div id="paymentStatus" class="space-y-4">
                    <!-- Initial state: Processing -->
                    <div id="processingState">
                        <div class="text-4xl mb-4">⏳</div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Processing Payment</h2>
                        <p class="text-gray-600 mb-4">Please wait while we process your payment...</p>
                        <div class="flex justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        </div>
                    </div>

                    <!-- Payment Success State -->
                    <div id="successState" class="hidden">
                        <div class="text-5xl mb-4">✅</div>
                        <h2 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h2>
                        <p class="text-gray-600 mb-3">Processing your registration...</p>
                        <div class="flex justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                        </div>
                    </div>

                    <!-- Registration Complete -->
                    <div id="completeState" class="hidden">
                        <div class="text-5xl mb-4">🎉</div>
                        <h2 class="text-2xl font-bold text-green-600 mb-2">Business Claimed!</h2>
                        <div class="space-y-2 text-left bg-green-50 p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-700"><strong>✓ Payment Completed</strong> - RM 99.00</p>
                            <p class="text-sm text-gray-700"><strong>✓ Account Registered</strong></p>
                            <p class="text-sm text-gray-700"><strong>✓ Business Claimed</strong></p>
                        </div>
                        <p class="text-gray-600 mb-4">Redirecting to your dashboard...</p>
                    </div>

                    <!-- Error State -->
                    <div id="errorState" class="hidden">
                        <div class="text-5xl mb-4">❌</div>
                        <h2 class="text-2xl font-bold text-red-600 mb-2">Payment Failed</h2>
                        <p class="text-gray-600 mb-4" id="errorMessage"></p>
                        <button onclick="closePaymentModal()" class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            Try Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatCardNumber(input) {
    input.value = input.value.replace(/\s/g, '').replace(/(\d{4})/g, '$1 ').trim();
}

function formatExpiryDate(input) {
    input.value = input.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2').substring(0, 5);
}

function validateCardForm() {
    const cardHolderName = document.getElementById('cardHolderName').value.trim();
    const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
    const expiryDate = document.getElementById('expiryDate').value;
    const cvv = document.getElementById('cvv').value;

    if (!cardHolderName) {
        alert('Please enter cardholder name');
        return false;
    }

    if (cardNumber.length !== 16 || !/^\d+$/.test(cardNumber)) {
        alert('Please enter a valid 16-digit card number');
        return false;
    }

    if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
        alert('Please enter expiry date in MM/YY format');
        return false;
    }

    if (cvv.length !== 3 || !/^\d+$/.test(cvv)) {
        alert('Please enter a valid 3-digit CVV');
        return false;
    }

    return true;
}

function processPayment(event) {
    event.preventDefault();

    // Validate card details
    if (!validateCardForm()) {
        return;
    }

    // Find the closest form
    const form = event.target.closest('form') || document.querySelector('form');
    const agreeTerms = form.querySelector('input[name="agree_terms"]');

    if (!agreeTerms || !agreeTerms.checked) {
        alert('Please agree to the terms and conditions');
        return;
    }

    // Show payment modal
    document.getElementById('paymentModal').classList.remove('hidden');
    
    // Simulate payment processing (1-2 seconds)
    setTimeout(() => {
        processPaymentTransaction();
    }, 1500);
}

function processPaymentTransaction() {
    const form = document.querySelector('form');
    const formData = new FormData(form);
    
    // Add payment details
    formData.append('card_holder_name', document.getElementById('cardHolderName').value);
    formData.append('card_number', document.getElementById('cardNumber').value.replace(/\s/g, ''));
    formData.append('expiry_date', document.getElementById('expiryDate').value);
    formData.append('cvv', document.getElementById('cvv').value);
    formData.append('payment_amount', 99.00);

    // Fetch payment processing
    fetch('{{ route("vendor.claim.process-payment") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'payment_success') {
            // Show success state
            document.getElementById('processingState').classList.add('hidden');
            document.getElementById('successState').classList.remove('hidden');

            // Process registration after 2 seconds
            setTimeout(() => {
                processRegistration(data.claim_token);
            }, 2000);
        } else {
            showPaymentError(data.message || 'Payment processing failed');
        }
    })
    .catch(err => {
        showPaymentError(err.message || 'Payment processing failed');
    });
}

function processRegistration(claimToken) {
    const form = document.querySelector('form');
    const formData = new FormData(form);

    fetch('{{ route("vendor.claim.process") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        // Handle both success and error responses
        return response.json().then(data => ({
            status: response.status,
            data: data
        }));
    })
    .then(result => {
        if (result.data.status === 'success') {
            // Show complete state
            document.getElementById('successState').classList.add('hidden');
            document.getElementById('completeState').classList.remove('hidden');

            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = result.data.redirect_url;
            }, 3000);
        } else {
            showPaymentError(result.data.message || 'Registration failed');
        }
    })
    .catch(err => {
        showPaymentError(err.message || 'Registration failed');
    });
}

function showPaymentError(message) {
    document.getElementById('processingState').classList.add('hidden');
    document.getElementById('successState').classList.add('hidden');
    document.getElementById('completeState').classList.add('hidden');
    document.getElementById('errorState').classList.remove('hidden');
    document.getElementById('errorMessage').textContent = message;
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    // Reset error state
    document.getElementById('errorState').classList.add('hidden');
    document.getElementById('processingState').classList.remove('hidden');
}
</script>
@endsection
