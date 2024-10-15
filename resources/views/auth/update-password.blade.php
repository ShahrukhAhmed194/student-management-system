<x-login-layout>
    <x-slot name="title">Reset Password</x-slot>
    <div class="col-xl-5 col-xxl-4 col-sm-12 col-md-5">
        <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
            <div class="d-flex align-items-center w-100 h-100">
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="fw-bolder fs-7 mb-5">   
                        Reset Account Password.                
                        </h2>
                    </div>
                    <form action="{{route('reset.password')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" id="email" class="form-control bg-light" name="email" value="{{$email}}" readonly>
                            @error('email')
                            <div class="text-danger small"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control " name="password" placeholder="New Password">
                            @error('password')
                            <div class="text-danger small"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Update Password</button>
                        </div>
                    </form>
                    <div class="mb-3 text-center font-weight-bold">
                        <div style="font-size: 10px;" >
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