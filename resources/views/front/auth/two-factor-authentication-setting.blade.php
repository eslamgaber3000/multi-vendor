<x-front-layout title='2FA'>
 <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">

                    <form class="card login-form" method="post" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                                <p>You can Enable/Disable Tow Factor Authentication for here</p>
                            </div> 

                            @if ( ! $user->two_factor_secret )

                              <div class="button">
                                <button class="btn" type="submit">Enable</button>
                                 </div>
                            @else  
                                 
                           
                            <div class="text-center">
                                {!! $user->twoFactorQrCodeSvg(); !!}

                                 <h3 >Two Factor Recovery Code :</h3>
                                <p class="py-3">Take care to copy this codes to can login to Your account</p>
                                <ul>
                            @foreach ($user->recoveryCodes() as $code )
                                <li>{{$code}}</li>
                            @endforeach

                                 </ul>
                            </div>
                            <div class="button">
                                @method('delete')
                                <button class="btn" type="submit">Disable</button>
                            </div> 
                               
                            @endif
                            
                            
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-front-layout>