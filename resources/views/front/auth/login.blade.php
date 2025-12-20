<x-front-layout title='Login'>
 <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                   
                    <form class="card login-form" method="post" action="{{ route('login.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <h3>Login Now</h3>
                                <p>You can login using your social media account or email address.</p>
                            </div>
                            <div class="social-login">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12"><a class="btn facebook-btn"
                                            href="{{ route('auth.provider.redirect','facebook') }}"><i class="lni lni-facebook-filled"></i> Facebook
                                            login</a></div>
                                    <div class="col-lg-4 col-md-4 col-12"><a class="btn twitter-btn"
                                            href="javascript:void(0)"><i class="lni lni-twitter-original"></i> Twitter
                                            login</a></div>
                                    <div class="col-lg-4 col-md-4 col-12"><a class="btn google-btn"
                                            href="{{ route('auth.provider.redirect','google') }}"><i class="lni lni-google"></i> Google login</a>
                                    </div>
                                </div>
                            </div>
                            <div class="alt-option">
                                <span>Or</span>
                            @if($errors->has(Config::get('fortify.username')))
                            <div class="alert alert-danger">{{ $errors->first(Config::get('fortify.username')) }}</div>
                            @endif

                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Email</label>
                                <input class="form-control" name="{{ Config::get('fortify.username') }}" value="{{ old( Config::get('fortify.username')) }}" type="text" id="reg-email" required>
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Password</label>
                                <input class="form-control" type="password" name="password" id="reg-pass" required>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between bottom-content">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" value="1" class="form-check-input width-auto" id="exampleCheck1">
                                    <label class="form-check-label">Remember me</label>
                                </div>
                                 @if (Route::has('password.update'))
                                <a class="lost-pass" href="{{ route('password.update') }}">Forgot password?</a>
                                @endif
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Login</button>
                            </div>
                            @if (Route::has('register'))
                                
                            <p class="outer-link">Don't have an account? <a href="{{ route('register') }}">Register here </a>
                            @endif
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>