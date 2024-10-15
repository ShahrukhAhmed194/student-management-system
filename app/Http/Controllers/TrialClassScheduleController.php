<?php

namespace App\Http\Controllers;

use App\Traits\validators\TrialClassScheduleValidators;
use Illuminate\Support\Facades\Auth;
use App\Traits\trialClass\TrialClassSchedules;
use App\Models\TrialClassSchedule;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class TrialClassScheduleController extends Controller
{
    use TrialClassScheduleValidators, TrialClassSchedules;

    public $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('trialclass_schedule.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any trial class schedule!');
        }

        $day_before_yesterday = Carbon::now()->subDays(2)->format('Y-m-d');
        $time_now = Carbon::now()->addHours(6)->format('H:m');

        $trial_class_schedules_query = TrialClassSchedule::with('coordinator')->where('status', 1)
            ->where('date','>=', $day_before_yesterday)
            ->orderBy('date', 'ASC');
        if(auth()->user()->email == 'admin@dreamersacademy.co.uk'){
            $trial_class_schedules_query->where('country', 'United Kingdom')->get();
        }
        $trial_class_schedules = $trial_class_schedules_query->get();
        
        return view('trial-class.schedule.index', compact('trial_class_schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('trialclass_schedule.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any trial class schedule!');
        }
        $customerSupportExecutives = User::where('user_type', User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE)->get();

        return view('trial-class.schedule.create', [
            'teachers' => User::where('user_type', User::USER_TYPE_TEACHER)->get(),
            'customerSupportExecutives' => $customerSupportExecutives,
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
        $validator = $this->validateNewSchedule($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $classes = $this->checkForExistingClasses($request);
        if($classes > 0){
            return redirect()->back()->with('class', 'This Teacher Already Has A Class')->withInput();
        }
        TrialClassSchedule::create($request->all());

        toastr()->success('Trial class schedule created successfully.');

        return redirect()->route('trial-class-schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrialClassSchedule  $trialClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(TrialClassSchedule $trialClassSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrialClassSchedule  $trialClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(TrialClassSchedule $trialClassSchedule)
    {
        if (is_null($this->user) || !$this->user->can('trialclass_schedule.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any trial class schedule!');
        }
        $customerSupportExecutives = User::where('user_type', User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE)->get();

        return view('trial-class.schedule.edit', [
            'trial_class_schedule' => $trialClassSchedule,
            'teachers' => User::where('user_type', User::USER_TYPE_TEACHER)->get(),
            'customerSupportExecutives' => $customerSupportExecutives,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrialClassSchedule  $trialClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrialClassSchedule $trialClassSchedule)
    {
        $validator = $this->validateExistingSchedule($request);
        if ($validator->fails()) {
            return redirect(url('/trial-class-schedule/'.$trialClassSchedule->id.'/edit'))
                    ->withErrors($validator)
                    ->withInput();
        }
        
        $trialClassSchedule->update($request->all());

        toastr()->success('Trial class schedule updated successfully.');

        return redirect()->route('trial-class-schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrialClassSchedule  $trialClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrialClassSchedule $trialClassSchedule)
    {
        //
    }

    public function inactiveClassSchedule($id){
        $trial_class_schedule = TrialClassSchedule::find($id);

        if(empty($trial_class_schedule)){
            return view('pages.error-404');
        }
        else{
            $trial_class_schedule->status = 0;
            $trial_class_schedule->save();

            return redirect('trial-class-schedule');
        }

    }
}
