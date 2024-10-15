<x-login-layout>
  <x-slot name="title">Sign In</x-slot>
    <div class="col-xl-5 col-xxl-4 col-sm-12 col-md-5">
      <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
          @if ($errors->has('payment_pending'))
              <div class="alert alert-danger">
                  {!! $errors->first('payment_pending') !!}
              </div>
          @endif
          <div class="position-relative text-center my-4">
            <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">Sign In To Your Account</p>
            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
          </div>
          <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="mb-3">
              <label for="user_name" class="form-label">Username</label>
              <input type="text" name="user_name" class="form-control" id="user_name" value="{{old('user_name')}}">
              @error('user_name')
                <div class="text-danger small"><strong>{{ $message }}</strong></div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="yourPassword" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="yourPassword">
              @error('password')
                <div class="text-danger small"><strong>{{ $message }}</strong></div>
              @enderror
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
              <div class="form-check">
                <input class="form-check-input primary" type="checkbox" id="show_password" onclick="showPassword()">
                <label class="form-check-label text-dark" for="show_password">
                  Show Password
                </label>
              </div>
              <a class="text-primary fw-medium" href="{{ route('forgot-password') }}">Forgot Password ?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
          </form>
          <div class="text-center">
            <div style="font-size: 10px;font-weight: bold;">
                <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> | <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a> | <a target="_blank" href="https://dreamersacademy.com.bd/privacy-policy.html">Privacy Policy</a>
            </div>
            <div style="font-size: 10px;font-weight: bold">
                <a target="_blank" href="https://dreamersacademy.com.bd/">Home</a> | <a target="_blank" href="https://www.facebook.com/dreamersacademy.com.bd">Facebook</a> | <a target="_blank" href="https://www.linkedin.com/company/dreamersacademyxyz/">LinkedIn</a> | <a target="_blank" href="https://www.youtube.com/channel/UCVA18H_acEpB2CedTfvPzrQ">YouTube</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  Custom Js Files -->
    <script src="{{asset('assets/js/login/login-1.0.0.js')}}"></script>
</x-login-layout>