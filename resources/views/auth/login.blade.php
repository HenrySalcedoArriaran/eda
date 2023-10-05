@extends('layouts.app')

{{-- @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-bold" style="font-size: 17px; font-weight: bold">{{ __('Inicio de Sesión') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" style="font-size: 16px;"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>

                                <div class="col-md-6">
                                    <input style="font-size: 16px;" id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="DNI" required autocomplete="email"
                                        autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" style="font-size: 16px;"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Clave') }}</label>

                                <div class="col-md-6">
                                    <input style="font-size: 16px;" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required placeholder="(Clave o DNI)" autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Entrar') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('¿Olvidaste tu contraseña?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@section('content')
    <section class="">
        <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
            <div class="bg-white shadow sm:rounded-lg flex justify-center items-center flex-1">
                <div class="p-3 sm:p-3">
                    <div>
                        <img src="/elp.gif" class="w-60 mx-auto" />
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-full flex-1">
                            <div class="my-4 border-b text-center">
                                <div
                                    class="leading-none px-2 inline-block text-lg text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                    Inicia sesion con tu cuenta
                                </div>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mx-auto max-w-sm p-5">

                                    <input required autofocus id="email"
                                        class="w-full px-3 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-base focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="number" name="email" value="{{ old('email') }}"
                                        placeholder="Nombre de usuario" />

                                    @error('email')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                    <input required
                                        class="w-full px-3 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-base focus:outline-none focus:border-gray-400 focus:bg-white mt-3"
                                        type="password" name="password" placeholder="Contraseña" />

                                    @error('password')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <button type="submit"
                                        class="mt-3 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-2 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M20.1633 4.09295L15.0612 2.17072C14.1429 1.86721 13.2245 1.96838 12.5102 2.47423C12.2041 2.67657 12 2.87891 11.7959 3.08125H7.91837C6.38776 3.08125 5.06122 4.39646 5.06122 5.91401V6.9257C5.06122 7.33038 5.36735 7.73506 5.87755 7.73506C6.38776 7.73506 6.69388 7.33038 6.69388 6.9257V5.91401C6.69388 5.20582 7.30612 4.69997 7.91837 4.69997H11.2857V19.3696H7.91837C7.20408 19.3696 6.69388 18.7626 6.69388 18.1555V17.1439C6.69388 16.7392 6.38776 16.3345 5.87755 16.3345C5.36735 16.3345 5.06122 16.638 5.06122 17.0427V18.0544C5.06122 19.5719 6.28572 20.8871 7.91837 20.8871H11.7959C12 21.0895 12.2041 21.393 12.4082 21.4942C12.9184 21.7977 13.4286 22 14.0408 22C14.3469 22 14.7551 21.8988 15.0612 21.7977L20.1633 19.8754C21.2857 19.4708 22 18.4591 22 17.245V6.62219C22 5.50933 21.1837 4.39646 20.1633 4.09295Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M6.38776 13.5017C6.08163 13.8052 6.08163 14.3111 6.38776 14.6146C6.4898 14.7158 6.69388 14.8169 6.89796 14.8169C7.10204 14.8169 7.30612 14.7158 7.40816 14.6146L9.44898 12.5912C9.55102 12.49 9.55102 12.3889 9.65306 12.3889C9.65306 12.2877 9.7551 12.1865 9.7551 12.0854C9.7551 11.9842 9.7551 11.883 9.65306 11.7819C9.65306 11.6807 9.55102 11.5795 9.44898 11.5795L7.40816 9.55612C7.10204 9.25261 6.59184 9.25261 6.28571 9.55612C5.97959 9.85963 5.97959 10.3655 6.28571 10.669L7 11.3772H2.81633C2.40816 11.3772 2 11.6807 2 12.1865C2 12.6924 2.30612 12.9959 2.81633 12.9959H7.10204L6.38776 13.5017Z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="ml-3">
                                            Entrar
                                        </span>
                                    </button>
                                    <span class="border-t border-neutral-300 mt-6 pt-4 block">
                                        <button type="button"
                                            class="w-full mt-2 gap-2 justify-center text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center dark:focus:ring-gray-800 dark:bg-white dark:border-gray-300 dark:text-gray-900 dark:hover:bg-gray-200 mr-2 mb-2">
                                            <img src="/microsoft-365.png" class="w-6" alt="">
                                            Microsoft 365
                                        </button>
                                    </span>
                                    <p class="mt-6 text-xs text-gray-600 text-center">
                                        I agree to abide by templatana's
                                        <a href="#" class="border-b border-gray-500 border-dotted">
                                            Terms of Service
                                        </a>
                                        and its
                                        <a href="#" class="border-b border-gray-500 border-dotted">
                                            Privacy Policy
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-indigo-100 h-full text-center hidden lg:flex">
                    <img src="/ponti-back.png" class="object-cover w-full h-full" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
