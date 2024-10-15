<x-login-layout>
    <x-slot name="title">Forgot Password</x-slot>
    <div class="col-xl-5 col-xxl-4 col-sm-12 col-md-5">
        <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
            <div class="d-flex align-items-center w-100 h-100">
                <div class="card-body">
                    <div class="mb-5">
                        <h2 class="fw-bolder fs-7 mb-3">Forgot your password?</h2>
                        <p class="mb-0 ">   
                        Please enter the email address associated with your account and We will email you a link to reset your password.                
                        </p>
                    </div>
                    <form action="{{route('reset.email')}}" method="POST">
                        @csrf
                        @if(session('success'))
                            <div class="text-success small"><strong>{{ session('success') }}</strong></div>
                        @endif
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Your Registered Email">
                            @error('email')
                                <div class="text-danger small"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Get Password Reset Email</button>
                        </div>
                        <div class="mb-3">
                            <a href="{{route('login')}}" class="btn btn-light-primary text-primary w-100">Back to Login</a>
                        </div>
                    </form>
                    <div class="mb-3 text-center font-weight-bold">
                        <div style="font-size: 10px;">
                            <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> | <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a> | <a target="_blank" href="https://dreamersacademy.com.bd/privacy-policy.html">Privacy Policy</a>
                        </div>
                        <div style="font-size: 10px;">
                            <a target="_blank" href="https://dreamersacademy.com.bd/">Home</a> | <a target="_blank" href="https://www.facebook.com/dreamersacademy.com.bd">Facebook</a> | <a target="_blank" href="https://www.linkedin.com/company/dreamersacademyxyz/">LinkedIn</a> | <a target="_blank" href="https://www.youtube.com/channel/UCVA18H_acEpB2CedTfvPzrQ">YouTube</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-login-layout>