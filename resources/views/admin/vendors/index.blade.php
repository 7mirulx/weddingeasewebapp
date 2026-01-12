@extends('layouts.admin')

@section('page-title', 'All Vendors')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Vendors Management</h2>
    <!-- <a href="{{ route('admin.vendors.create') }}" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 font-semibold">
        + Add New Vendor
    </a> -->
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Owner</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Featured</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($vendors as $vendor)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $vendor->vendor_name }}</p>
                        <p class="text-xs text-gray-500">ID: {{ $vendor->id }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $vendor->category ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.vendors.toggle-status', $vendor->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-2 py-1 text-xs font-semibold rounded {{ $vendor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($vendor->status) }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $vendor->owner_user_id ? 'Assigned' : '—' }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.vendors.toggle-featured', $vendor->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-2xl hover:opacity-70">
                                {{ $vendor->is_featured ? '⭐' : '☆' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        @if($vendor->owner_user_id)
                            <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        @else
                            @if($vendor->status === 'unclaimed')
                                <form method="POST" action="{{ route('admin.vendors.send-claim-invite', $vendor->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:underline font-semibold">Send Invite</button>
                                </form>
                            @endif
                            <button onclick="openContactModal({{ $vendor->id }}, '{{ $vendor->vendor_name }}', '{{ $vendor->email }}')" class="text-green-600 hover:underline font-semibold">Contact Business</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No vendors found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $vendors->links() }}
</div>

<!-- CONTACT VENDOR MODAL -->
<div id="contactModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4">
    <div class="bg-white w-full max-w-2xl p-8 rounded-2xl shadow-2xl border-2 border-pink-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-rose-700">Contact Vendor - Claim Business Profile</h2>
            <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 text-2xl">✖</button>
        </div>

        <form id="contactForm" onsubmit="submitContactForm(event)" class="space-y-5">
            @csrf
            <input type="hidden" id="vendorId" name="vendor_id">

            <!-- Vendor Info Display -->
            <div class="bg-gradient-to-r from-rose-50 to-pink-50 p-4 rounded-lg border border-pink-200">
                <p class="text-sm font-semibold text-gray-700">Vendor Name:</p>
                <p class="text-lg font-bold text-rose-700" id="vendorNameDisplay"></p>
            </div>

            <div class="bg-gradient-to-r from-rose-50 to-pink-50 p-4 rounded-lg border border-pink-200">
                <p class="text-sm font-semibold text-gray-700">Recipient Email:</p>
                <p class="text-lg font-bold text-rose-700" id="vendorEmailDisplay"></p>
            </div>

            <!-- Email Subject -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Subject</label>
                <input type="text" name="subject" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500" value="Claim Your Business Profile on Wedding Ease" readonly>
            </div>

            <!-- Email Content -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Content</label>
                <textarea name="email_content" id="emailContent" rows="8" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 font-mono text-sm" readonly></textarea>
            </div>

            <!-- Claim Link -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Claim Form Link (Auto-generated)</label>
                <input type="text" id="claimLinkDisplay" class="w-full border-2 border-gray-300 rounded-lg p-3 bg-gray-100" readonly>
                <input type="hidden" id="claimLink" name="claim_link">
            </div>

            <!-- Payment Section -->
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                <h3 class="text-lg font-bold text-yellow-800 mb-3">💳 Vendor Account Setup Fee</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-white rounded border border-yellow-300">
                        <span class="font-semibold text-gray-700">Account Creation & Claim Fee:</span>
                        <span class="text-2xl font-bold text-yellow-700">RM 99.00</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-yellow-300">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Payment Method:</p>
                        <p class="text-lg font-bold text-yellow-800">🏦 Bank Transfer</p>
                    </div>

                    <div class="p-3 bg-white rounded border border-yellow-300">
                        <p class="text-xs text-gray-600 italic">The vendor will receive bank transfer details in the email along with the claim link.</p>
                    </div>
                </div>

                <!-- Hidden fields for backend -->
                <input type="hidden" name="payment_amount" value="99.00">
                <input type="hidden" name="payment_method" value="bank_transfer">
                <input type="hidden" name="payment_notes" value="">
            </div>

            <!-- Additional Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes (Optional)</label>
                <textarea name="additional_notes" rows="3" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500" placeholder="Add any additional message to the vendor..."></textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t-2 border-pink-200">
                <button 
                    type="button"
                    onclick="closeContactModal()"
                    class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <button type="submit" id="submitBtn" class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-green-700 transition">
                    Send Email & Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SUCCESS/ERROR RESPONSE MODAL -->
<div id="responseModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[10000] p-4">
    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl text-center">
        <div id="responseIcon" class="text-6xl mb-4"></div>
        <h2 id="responseTitle" class="text-2xl font-bold mb-3 text-gray-800"></h2>
        <p id="responseMessage" class="text-gray-600 mb-6"></p>
        <button onclick="closeResponseModal()" class="px-6 py-2 bg-gradient-to-r from-pink-500 to-rose-600 text-white font-semibold rounded-lg hover:from-pink-600 hover:to-rose-700 transition">
            Close
        </button>
    </div>
</div>

<script>
function openContactModal(vendorId, vendorName, vendorEmail) {
    document.getElementById('vendorId').value = vendorId;
    document.getElementById('vendorNameDisplay').textContent = vendorName;
    document.getElementById('vendorEmailDisplay').textContent = vendorEmail;
    
    // Generate a claim token for this vendor
    fetch('/admin/vendors/' + vendorId + '/generate-token', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            const claimLink = `{{ config('app.url') }}/vendor/claim?token=${data.token}`;
            document.getElementById('claimLink').value = claimLink;
            document.getElementById('claimLinkDisplay').value = claimLink;
            updateEmailContent(claimLink, vendorName);
        }
    })
    .catch(err => {
        console.error('Failed to generate token:', err);
        alert('Failed to generate claim token. Please try again.');
    });
}

function updateEmailContent(claimLink, vendorName) {
    const emailContent = `Dear ${vendorName} Team,

Are you the owner of "${vendorName}"?

Our users on Wedding Ease have been rating your services! With thousands of couples looking for vendors like you, now is the perfect time to claim your business profile and take control of your presence on our platform.

By claiming your profile, you can:
✓ Manage your business information and showcase your best work
✓ Respond directly to client inquiries
✓ Generate qualified leads and increase your sales
✓ Build your reputation with verified client reviews
✓ Access analytics and client insights

🔗 Click here to claim your business profile:
${claimLink}

If you have any questions or need assistance, please don't hesitate to reach out.

Best regards,
Wedding Ease Team`;
    
    document.getElementById('emailContent').value = emailContent;
    document.getElementById('contactModal').classList.remove('hidden');
}

function closeContactModal() {
    document.getElementById('contactModal').classList.add('hidden');
    document.getElementById('contactForm').reset();
}

function submitContactForm(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('submitBtn');
    const formData = new FormData(document.getElementById('contactForm'));
    
    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="inline-flex items-center">⏳ Sending & Processing...</span>';
    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    
    fetch('/admin/vendors/contact-business', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showResponseModal('✅', 'Success!', 'Email sent and payment recorded successfully!', true);
            document.getElementById('contactForm').reset();
        } else {
            showResponseModal('❌', 'Error', data.message || 'Failed to send email', false);
        }
    })
    .catch(err => {
        showResponseModal('❌', 'Error', 'An error occurred: ' + err.message, false);
    })
    .finally(() => {
        // Reset button
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Email & Record Payment';
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    });
}

function showResponseModal(icon, title, message, isSuccess) {
    document.getElementById('responseIcon').textContent = icon;
    document.getElementById('responseTitle').textContent = title;
    document.getElementById('responseMessage').textContent = message;
    
    // Update colors based on success/error
    const titleEl = document.getElementById('responseTitle');
    if (isSuccess) {
        titleEl.classList.remove('text-red-600');
        titleEl.classList.add('text-green-600');
    } else {
        titleEl.classList.remove('text-green-600');
        titleEl.classList.add('text-red-600');
    }
    
    document.getElementById('responseModal').classList.remove('hidden');
}

function closeResponseModal() {
    document.getElementById('responseModal').classList.add('hidden');
    // If success, close contact modal and reload
    if (document.getElementById('responseTitle').classList.contains('text-green-600')) {
        closeContactModal();
        location.reload();
    }
}
</script>

@endsection
