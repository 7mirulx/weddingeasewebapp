@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex justify-center items-center">
    <div class="w-full max-w-lg bg-white p-10 rounded-xl shadow-lg">

        <h1 class="text-3xl font-semibold mb-6 text-primary">Log in to your account</h1>

        @if($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded-md">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-primary/50 outline-none" />
            </div>

            <div class="flex items-center justify-between mb-5 text-sm">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded" />
                    Remember me
                </label>

                <a href="#" class="underline">Forgot password?</a>
            </div>

            <button type="submit" class="w-full px-4 py-3 rounded-md btn-primary text-lg">
                Log in
            </button>
        </form>

        <p class="mt-6 text-sm text-center">
            Don't have an account?
            <a href="{{ route('register') }}" class="underline font-medium">Register</a>
        </p>

    </div>
</div>
@endsection
