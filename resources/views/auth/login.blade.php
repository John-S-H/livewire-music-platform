<x-guest-layout>





    <div class="w-full flex flex-wrap">

        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <x-authentication-card>
                <x-slot name="logo">
                    <x-authentication-card-logo />
                </x-slot>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ml-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>

{{--            <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">--}}
{{--                <a href="#" class="bg-black text-white font-bold text-xl p-4">Logo</a>--}}
{{--            </div>--}}

{{--            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">--}}
{{--                <p class="text-center text-3xl">Welcome.</p>--}}
{{--                <form class="flex flex-col pt-3 md:pt-8" onsubmit="event.preventDefault();">--}}
{{--                    <div class="flex flex-col pt-4">--}}
{{--                        <label for="email" class="text-lg">Email</label>--}}
{{--                        <input type="email" id="email" placeholder="your@email.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col pt-4">--}}
{{--                        <label for="password" class="text-lg">Password</label>--}}
{{--                        <input type="password" id="password" placeholder="Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                    </div>--}}

{{--                    <input type="submit" value="Log In" class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8">--}}
{{--                </form>--}}
{{--                <div class="text-center pt-12 pb-12">--}}
{{--                    <p>Don't have an account? <a href="register.html" class="underline font-semibold">Register here.</a></p>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>

        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="https://studyworkgrow.com.au/wp-content/uploads/2021/03/Music-Therapist-JS-1024x576.png">
        </div>
    </div>
</x-guest-layout>
