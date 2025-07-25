<x-front-layout title='2F challenge'>
 <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post" action="{{ route('two-factor.login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication challenge </h3>
                                <p>Enter Two Factor Authentication Confirmation code</p>
                            </div>
                          
                            
                            @if($errors->any())

                            @foreach ($errors->all() as $error )
                                  <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                          
                            @endif

                            
                            <div class="form-group input-group" id="auth-code-group">
                                <label for="reg-fn">2Factor Challenge</label>
                                <input class="form-control" name="code" type="text" id="code" >
                            </div>
                             
                             <div class="form-group input-group" id="recovery-code-group" style="display: none">
                                <label for="reg-fn">2Factor Recovery Code</label>
                                <input class="form-control" name="recovery_code" disabled type="text" id="recovery_code" >
                            </div>
                            

                            <div class="form-group input-group">
                                <label for="reg-fn"> 
                                    <input  type="checkbox" id="use-recovery" > Use Recovery Code
                                </label>
                            </div>
                            
                            <div class="button">
                                <button class="btn" type="submit">Enter</button>
                            </div>
                          
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
      
    <script>
    document.getElementById("use-recovery").addEventListener('change' , function(){

//      to make two inputs  one for recovery code other for auth code .

        // 1-first  I want to make checkbox button this checkbox when change .
        // make this in variable , check if useRcovery is true disable to code , and if 

    const useRecovery = this.checked;
    
    var code = document.getElementById('code');
    var recovery_code = document.getElementById('recovery_code');
    var auth_code_group=document.getElementById('auth-code-group');
    var recovery_code_group=document.getElementById('recovery-code-group');

   


    if (useRecovery == true) {

        code.disabled=true ;
        recovery_code.disabled=false;

        auth_code_group.style.display='none' ;
        recovery_code_group.style.display='block';
    }else{
        recovery_code.disabled=true;
        code.disabled=false ;
        auth_code_group.style.display='block' ;
        recovery_code_group.style.display='none';


    }

    
    })
    
    </script>
    @endpush

</x-front-layout>