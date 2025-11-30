@extends('layouts.publicapp')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center">
    <div class="w-full max-w-[650px] mx-4 bg-white p-8 md:p-12 rounded-2xl shadow-xl">

        <h1 class="text-3xl font-semibold mb-8 text-primary">Create your account</h1>

        @if($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded-md">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm mb-1 font-medium">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <div class="mb-6">
                <label class="block text-sm mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <div class="mb-6">
                <label class="block text-sm mb-1 font-medium">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <div class="mb-8">
                <label class="block text-sm mb-1 font-medium">Confirm password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <button type="submit" class="w-full px-4 py-3 rounded-md btn-primary text-lg font-semibold">
                Register
            </button>
        </form>

        <p class="mt-6 text-sm text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="underline font-medium">Log in</a>
        </p>

    </div>
</div>
@endsection
