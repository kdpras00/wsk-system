@extends('layouts.guest')

@section('content')
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('storage/logo-wsk.png') }}" class="h-10 w-auto mb-2" alt="Logo">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-slate-900 md:text-2xl">
            Welcome Back
        </h1>
        <p class="text-sm text-slate-500">Sign in to your corporate account</p>
    </div>
    
    
    <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
        @csrf
        
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
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
        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-slate-300 rounded bg-slate-50 focus:ring-3 focus:ring-slate-300">
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-slate-500">Remember me</label>
                </div>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-slate-600 hover:underline hover:text-slate-900">Forgot password?</a>
            @endif
        </div>
        <button type="submit" class="w-full text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg">Sign in</button>
        <p class="text-sm font-light text-slate-500">
            Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-slate-600 hover:underline hover:text-slate-900">Sign up</a>
        </p>
    </form>
@endsection
