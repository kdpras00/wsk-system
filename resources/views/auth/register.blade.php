@extends('layouts.guest')

@section('content')
    <div class="flex flex-col items-center mb-6">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-slate-900 md:text-2xl">
            Operator Registration
        </h1>
        <p class="text-sm text-slate-500">Register as a production operator</p>
    </div>

    <form class="space-y-4 md:space-y-6" action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-slate-900">Full Name</label>
            <input type="text" name="name" id="name" class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="John Doe" required="">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-slate-900">Your Email</label>
            <input type="email" name="email" id="email" class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" placeholder="name@company.com" required="">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-slate-900">Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" required="">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="confirm-password" class="block mb-2 text-sm font-medium text-slate-900">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5" required="">
        </div>
        <button type="submit" class="w-full text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg">Create Account</button>
        <p class="text-sm font-light text-slate-500">
            Already have an account? <a href="{{ route('login') }}" class="font-medium text-slate-600 hover:underline hover:text-slate-900">Login here</a>
        </p>
    </form>
@endsection
