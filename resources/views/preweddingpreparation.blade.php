@extends('layouts.userapp')

@section('content')
<div class="max-w-6xl mx-auto py-10">

    {{-- TITLE --}}
    <h1 class="text-3xl font-bold text-rose-900">Pra-Nikah Checklist</h1>
    <p class="text-gray-600 mt-1 mb-8">Lengkapkan persediaan sebelum hari bahagia ✨</p>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="p-4 mb-6 bg-green-100 text-green-800 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- PROGRESS --}}
    <div class="mb-8">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>Progress</span>
            <span>{{ $progress ?? 0 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-pink-500 h-3 rounded-full transition-all"
                 style="width: {{ $progress ?? 0 }}%"></div>
        </div>
    </div>

    {{-- STEPPER --}}
    <div class="bg-white rounded-2xl shadow border p-6">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                🔥 <h2 class="font-semibold text-lg text-gray-800">Getting Started</h2>
            </div>
            <span class="text-sm text-gray-500">{{ $progress ?? 0 }}% completed</span>
        </div>

        {{-- TOP STEPS --}}
        <div class="relative mb-10">
            <div class="h-1 bg-gray-200 rounded-full"></div>

            <div class="flex justify-between mt-[-12px]">
                @foreach ($prerequisites as $index => $item)
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm
                            {{ $item->isCompleted()
                                ? 'bg-green-500 text-white'
                                : ($item->is_active
                                    ? 'border-4 border-pink-500 bg-white'
                                    : 'bg-gray-300') }}">
                            {{ $item->isCompleted() ? '✓' : $index + 1 }}
                        </div>
                        <span class="text-xs mt-2 text-gray-600 text-center w-24">
                            {{ $item->step->name }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- STEP CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($prerequisites as $item)
                <div class="rounded-xl border p-5 transition
                    {{ $item->isCompleted() ? 'border-green-300 bg-green-50' : '' }}
                    {{ $item->is_active ? 'border-pink-500 shadow-lg scale-[1.02]' : '' }}
                    {{ $item->is_locked ? 'opacity-50' : 'hover:shadow-md' }}">

                    <h3 class="font-semibold text-gray-800 mb-1">
                        Step {{ $item->step->step_order }} — {{ $item->step->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-4">
                        {{ $item->step->description }}
                    </p>

                    @if ($item->isCompleted())
                        <span class="text-green-600 font-semibold text-sm">Completed</span>

                    @elseif ($item->is_active)
                        <div class="space-y-3">

                            {{-- Uploaded document info --}}
                            @if ($item->documents->count())
                                @php $doc = $item->documents->last(); @endphp

                                <div
                                    class="flex items-center gap-2 text-sm text-gray-700 bg-gray-50 px-3 py-2 rounded-lg border"
                                    title="{{ $doc->original_name }}"
                                >
                                    📎
                                    <span class="truncate max-w-[200px]">
                                        {{ $doc->original_name }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex gap-2">
                                {{-- Mark completed --}}
                                <button
                                    onclick="markCompleted({{ $item->id }})"
                                    class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg text-sm">
                                    Mark Completed
                                </button>

                                {{-- Upload / Change Document --}}
                                @if ($item->requiresDocument())
                                    <button
                                        onclick="openUpload({{ $item->id }})"
                                        class="px-4 py-2 border border-pink-500 text-pink-600 rounded-lg text-sm">
                                        {{ $item->documents->count() ? 'Change Document' : 'Upload' }}
                                    </button>
                                @endif
                            </div>

                        </div>



                    @else
                        <span class="text-gray-400 text-sm">Locked</span>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- UPLOAD MODAL --}}
<div id="uploadModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Upload Dokumen</h3>

        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="document" required class="w-full border rounded-lg p-2 mb-4">
            <button class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg">
                Upload
            </button>
        </form>

        <button onclick="closeUpload()" class="mt-4 text-sm text-gray-500">Cancel</button>
    </div>
</div>

<script>
/**
 * CSRF token injected directly from Blade
 */
const CSRF_TOKEN = "{{ csrf_token() }}";

/**
 * Open upload modal
 */
function openUpload(id) {
    const modal = document.getElementById('uploadModal');
    const form  = document.getElementById('uploadForm');

    // store prerequisite id
    form.dataset.id = id;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

/**
 * Close upload modal
 */
function closeUpload() {
    const modal = document.getElementById('uploadModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/**
 * Mark step as completed (AJAX, no refresh)
 */
function markCompleted(id) {
    fetch(`/preweddingpreparation/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: 'completed'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // simple & safe for now
        } else {
            alert(data.message || 'Failed to update step');
        }
    })
    .catch(() => alert('Network error'));
}

/**
 * Handle upload submit (AJAX)
 */
document.getElementById('uploadForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const id = this.dataset.id;
    const formData = new FormData(this);

    fetch(`/preweddingpreparation/${id}/upload`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeUpload();
            location.reload(); // can be replaced with DOM update later
        } else {
            alert(data.message || 'Upload failed');
        }
    })
    .catch(() => alert('Network error'));
});
</script>

@endsection
