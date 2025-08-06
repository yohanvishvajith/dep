<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center dark:bg-gray-900">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">
            <!-- Logo -->
            <div class="flex justify-center">
                <x-logo />
            </div>

            <!-- Heading -->
            <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-white mt-4">
                Welcome back
            </h2>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                Please enter your details to sign in.
            </p>

            <!-- Success Message -->
            @if (session('status'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <!-- Google Login Button -->
            <div class="mt-6">
                <a href="{{ route('google.redirect') }}"
                    class="flex items-center justify-center w-full px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continue with Google
                </a>
            </div>

            <!-- Separator -->
            <div class="relative mt-6 flex items-center justify-center">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative bg-white dark:bg-gray-800 px-4 text-gray-500 dark:text-gray-400">
                    or
                </div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" placeholder="Enter your email" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" value="Password" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" placeholder="********" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember for 30 days</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                            href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="mt-6">
                    <x-button class="w-full flex justify-center">
                        Sign in
                    </x-button>
                </div>
            </form>

            <!-- Create Account -->
            <p class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    Create account
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
