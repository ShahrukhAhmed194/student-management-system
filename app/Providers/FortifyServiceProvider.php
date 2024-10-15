<?php

namespace App\Providers;

use App\Actions\Fortify\{CreateNewUser, ResetUserPassword, UpdateUserPassword, UpdateUserProfileInformation};
use App\Models\{LoginInfo, User};
use App\Services\WebServices\UserServices;
use Illuminate\Support\Facades\{Hash, RateLimiter};
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    protected $student_services, $user_services;
    public function __construct()
    {
        $this->user_services = new UserServices();
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // login method
        Fortify::authenticateUsing(function (Request $request) {
            $user = $this->user_services->getAnActiveUserUsingUserName($request->user_name);
            $error_msg = NULL;

            if($user && ($user->user_type == User::USER_TYPE_PARENT || $user->user_type == USER::USER_TYPE_STUDENT)){
                $error_msg = $this->user_services->getErrorMessageIfUserIsInactiveOrHasDuePayments($user);
            }

            if($error_msg != NULL){
                throw ValidationException::withMessages([ 'payment_pending' => [$error_msg] ]);
            }

            if ($user && Hash::check($request->password, $user->password)) {
                // check if login info already inserted
                $existingLoginInfo = LoginInfo::where('user_id', $user->id)
                    ->where('login_date', now()->format('Y-m-d'))
                    ->where('login_time', now()->format('H:i:s'))
                    ->first();
                // create login info if not exists
                if (!$existingLoginInfo) {
                    LoginInfo::create([
                        'user_id' => $user->id,
                        'ip_address' => $request->ip(),
                        'browser_agent' => $request->header('User-Agent'),
                        'login_date' => now(),
                        'login_time' => now(),
                    ]);
                }
                return $user;
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
