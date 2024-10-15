<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\users\ForgetPassword;
use App\Traits\validators\UserValidators;
use App\Traits\validators\PasswordResetValidator;
use App\Services\WebServices\UserServices;

class UserController extends Controller
{
    use UserValidators, PasswordResetValidator, ForgetPassword;
    
    public $user;
    protected $user_services;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });

        $this->user_services = new UserServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        if (is_null($this->user) || !$this->user->can('users.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any users!');
        }

        $users = User::where('user_type', User::USER_TYPE_SUPER_ADMIN)
            ->orWhere('user_type', User::USER_TYPE_TEACHER)
            ->orWhere('user_type', User::USER_TYPE_ADMIN)
            ->orWhere('user_type', User::USER_TYPE_COORDINATOR)
            ->orWhere('user_type', User::USER_TYPE_SALES_EXECUTIVE)
            ->orWhere('user_type', User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE)
            ->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('users.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any users!');
        }

        return view('users.create', [            
            'courses'   => Course::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return redirect('users/create')->withErrors($validator)->withInput();
        }
        $track_ids = $request->track_ids;
        
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if($track_ids[0] == null){
            $data['track_ids'] = null;
        }else{
            $data['track_ids'] = json_encode($request->track_ids);
        }

        $user = User::create($data);
        if ($request->user_type) {
            if($request->user_type != User::USER_TYPE_COORDINATOR || $request->user_type != User::USER_TYPE_SALES_EXECUTIVE || $request->user_type != User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE){
                $user->assignRole($request->user_type);
            }
        }

        toastr()->success('User created successfully.');
        return redirect()->route('user-list', ['id' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('users.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any users!');
        }
        $user = User::find($id);
        $track_ids = array();
        $trackID = $getCourseInfoByTrack = '';
        
        if(!empty($user->track_ids)){
            $track_ids = (json_decode($user->track_ids));
            $trackID = $track_ids[0];
            $trackInfo = CourseTrack::where('id', $trackID)->first();
            $getCourseInfoByTrack = Course::where('id', $trackInfo->course_id)->first();
            $tracksInfo = CourseTrack::where('course_id', $trackInfo->course_id)->get();
        }else{
            $tracksInfo = [];
        }


        return view('users.edit', [
            'user' => $user,
            'getCourseInfoByTrack' => $getCourseInfoByTrack,
            'courses'   => Course::all(),
            'tracks'    => $tracksInfo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->password) {
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            unset($request['password']);
        }

        if ($request->track_ids) {
            $request->merge(['track_ids' => json_encode($request->track_ids)]);
        }

        $user = User::find($id);
        $user->update($request->all());

        toastr()->success('User updated successfully.');
        return redirect()->route('user-list', ['id' => 1]);
    }

    public function setSocialLinks($id){

        return view('my.social', [
            'social_links' => User::find($id),
        ]);
    }

    public function updateSocialLink(Request $request, $id){
        
        $user = User::find($id);
        $user->twitter_profile = $request->twitter;
        $user->facebook_profile = $request->facebook;
        $user->instagram_profile = $request->instagram;
        $user->linkedln_profile = $request->linkedln;
        $user->save();

        return redirect('my/profile');
    }

    public function updateAbout(Request $request, $id){
        $user = User::find($id);
        $user->about = $request->about;
        $user->save();
        return redirect('my/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);

        return view('my.profile', compact('user'));
    }

    public function showForgotPassword()
    {
        return view('auth.password-reset');
    }

    public function emailPasswordResetLink(Request $request)
    {
        $validator = $this->validatePasswordResetEmail($request);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $dataSet = $this->getDataSetToEmail($request->email);

        Mail::to($request->email)->send(new \App\Mail\ResetPasswordMailer($dataSet));

        return redirect()->back()->with('success', 'Please Check Your Email For Password Reset Link');
    }

    public function showUpdatePassword(Request $request)
    {
        $token = $this->matchTokenFromTable($request->token);

        if(!empty($token)){
            return view('auth.update-password',['email' => $token->email]);
        }else{
            abort(403, 'Sorry !! You are Unauthorized to edit this user!');
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = $this->validateNewPassword($request);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $this->updatePassword($request);

        return redirect('/login');
    }

    public function activeInactiveUserList($status)
    {
        $users = $this->user_services->getUserListOnStatus($status);

        return view('users.index', compact('users'));
    }
}
