<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentsParent;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\Utils;

class ParentController extends Controller
{
    use Utils;

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
        if (is_null($this->user) || !$this->user->can('parents.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any parents !');
        }
        $parents = StudentsParent::all();

        return view('parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('parents.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any parents !');
        }
        $countries = $this->getCountryList();
        $religions = $this->getReligionList();

        return view('parents.create', compact('countries', 'religions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = $request->user_type;
        $user->save();

        $parent = new StudentsParent();
        $parent->user_id = $user->id;
        $parent->gender = $request->gender;
        $parent->phone = $request->phone;
        $parent->address = $request->address;
        $parent->country = $request->country;
        $parent->religion = $request->religion;
        $parent->occupation = $request->occupation;
        $parent->save();

        toastr()->success('Parent created successfully.');

        return redirect()->route('parents.index');
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
        if (is_null($this->user) || !$this->user->can('parents.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any parents!');
        }
        $parent = StudentsParent::find($id);
        $countries = $this->getCountryList();
        $religions = $this->getReligionList();

        return view('parents.edit', compact('parent', 'countries', 'religions'));
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

        $parent = StudentsParent::find($id);
        $parent->gender = $request->gender;
        $parent->phone = $request->phone;
        $parent->address = $request->address;
        $parent->country = $request->country;
        $parent->religion = $request->religion;
        $parent->occupation = $request->occupation;
        $parent->save();

        $user = User::find($parent->user_id);
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->user_type = $request->user_type;
        $user->save();

        toastr()->success('Parent updated successfully.');

        return redirect()->route('parents.index');
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
    
}