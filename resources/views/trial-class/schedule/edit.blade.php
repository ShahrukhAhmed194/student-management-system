<x-dashboard.admin-layout>
    <x-slot name='title'>Trial Class Schedule - Dreamers Academy</x-slot>
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            margin-top: -3px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Trial Class Schedule</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Update Trial Class Schedule</li>
                            </ol>
                          </nav>
                        </div>
                        <div class="col-3">
                          <div class="text-center mb-n5">  
                            <img src="{{ asset('assets/modernize/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card w-100 position-relative overflow-hidden mb-0">
                  <div class="card-body p-4">
                    <div class="nav nav-pills mb-3 rounded align-items-center flex-row">
                        <h5 class="card-title fw-semibold">Update Trial Class Schedule</h5>
                        @if (Auth::guard('web')->user()->can('trialclass_schedule.list'))
                        <small class="ms-auto">
                          <a href="/trial-class-schedule" class="btn btn-primary d-flex align-items-center px-3" id="add-notes">
                           <i class="ti ti-list me-0 me-md-1 fs-4"></i>
                            <span class="d-none d-md-block font-weight-medium fs-3">Trial Class Schedules</span>
                          </a>
                        </small>
                        @endif
                    </div>
                    
                    <form class="row g-3" action="{{ route('trial-class-schedule.update', $trial_class_schedule->id) }}" method="POST">
                        @csrf @method('PUT')
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="age_from" class="form-label fw-semibold"><i class="text-danger"> * </i> Age From</label>
                                <input type="number" name="age_from" value="{{$trial_class_schedule->age_from}}" class="form-control" id="age_from" >
                                @error('age_from')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="age_to" class="form-label fw-semibold"><i class="text-danger">* </i>Age To</label>
                                <input type="number" name="age_to" value="{{$trial_class_schedule->age_to}}" class="form-control" id="age_to" >
                                @error('age_to')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <input type="hidden" id="selected_country" name="selected_country" value="{{ $trial_class_schedule->country }}">
                                <label for="country" class="form-label fw-semibold"><i class="text-danger">*</i> Country</label>
                                <select id="country" name="country" title="other_data_country" class="form-control  select2" >
                                    <option value="" selected="" disabled="">
                                        Choose...
                                    </option>
                                    <option selected="">
                                        Bangladesh
                                    </option>
                                    <option>
                                        Afghanistan
                                    </option>
                                    <option>
                                        Åland Islands
                                    </option>
                                    <option>
                                        Albania
                                    </option>
                                    <option>
                                        Algeria
                                    </option>
                                    <option>
                                        American Samoa
                                    </option>
                                    <option>
                                        Andorra
                                    </option>
                                    <option>
                                        Angola
                                    </option>
                                    <option>
                                        Anguilla
                                    </option>
                                    <option>
                                        Antarctica
                                    </option>
                                    <option>
                                        Antigua and Barbuda
                                    </option>
                                    <option>
                                        Argentina
                                    </option>
                                    <option>
                                        Armenia
                                    </option>
                                    <option>
                                        Aruba
                                    </option>
                                    <option>
                                        Australia
                                    </option>
                                    <option>
                                        Austria
                                    </option>
                                    <option>
                                        Azerbaijan
                                    </option>
                                    <option>
                                        Bahamas
                                    </option>
                                    <option>
                                        Bahrain
                                    </option>
                                    <option>
                                        Barbados
                                    </option>
                                    <option>
                                        Belarus
                                    </option>
                                    <option>
                                        Belgium
                                    </option>
                                    <option>
                                        Belize
                                    </option>
                                    <option>
                                        Benin
                                    </option>
                                    <option>
                                        Bermuda
                                    </option>
                                    <option>
                                        Bhutan
                                    </option>
                                    <option>
                                        Bolivia
                                    </option>
                                    <option>
                                        Bonaire
                                    </option>
                                    <option>
                                        Bosnia and Herzegovina
                                    </option>
                                    <option>
                                        Botswana
                                    </option>
                                    <option>
                                        Bouvet Island
                                    </option>
                                    <option>
                                        Brazil
                                    </option>
                                    <option>
                                        British Indian Ocean Territory
                                    </option>
                                    <option>
                                        Brunei
                                    </option>
                                    <option>
                                        Bulgaria
                                    </option>
                                    <option>
                                        Burkina Faso
                                    </option>
                                    <option>
                                        Burundi
                                    </option>
                                    <option>
                                        Cambodia
                                    </option>
                                    <option>
                                        Cameroon
                                    </option>
                                    <option>
                                        Canada
                                    </option>
                                    <option>
                                        Cape Verde
                                    </option>
                                    <option>
                                        Cayman Islands
                                    </option>
                                    <option>
                                        Central African Republic
                                    </option>
                                    <option>
                                        Chad
                                    </option>
                                    <option>
                                        Chile
                                    </option>
                                    <option>
                                        China
                                    </option>
                                    <option>
                                        Christmas Island
                                    </option>
                                    <option>
                                        Cocos (Keeling) Islands
                                    </option>
                                    <option>
                                        Colombia
                                    </option>
                                    <option>
                                        Comoros
                                    </option>
                                    <option>
                                        Congo
                                    </option>
                                    <option>
                                        Cook Islands
                                    </option>
                                    <option>
                                        Costa Rica
                                    </option>
                                    <option>
                                        Croatia
                                    </option>
                                    <option>
                                        Cuba
                                    </option>
                                    <option>
                                        Curaçao
                                    </option>
                                    <option>
                                        Cyprus
                                    </option>
                                    <option>
                                        Czech Republic
                                    </option>
                                    <option>
                                        Denmark
                                    </option>
                                    <option>
                                        Djibouti
                                    </option>
                                    <option>
                                        Dominica
                                    </option>
                                    <option>
                                        Dominican Republic
                                    </option>
                                    <option>
                                        Ecuador
                                    </option>
                                    <option>
                                        Egypt
                                    </option>
                                    <option>
                                        El Salvador
                                    </option>
                                    <option>
                                        Equatorial Guinea
                                    </option>
                                    <option>
                                        Eritrea
                                    </option>
                                    <option>
                                        Estonia
                                    </option>
                                    <option>
                                        Ethiopia
                                    </option>
                                    <option>
                                        Falkland Islands (Malvinas)
                                    </option>
                                    <option>
                                        Faroe Islands
                                    </option>
                                    <option>
                                        Fiji
                                    </option>
                                    <option>
                                        Finland
                                    </option>
                                    <option>
                                        France
                                    </option>
                                    <option>
                                        French Guiana
                                    </option>
                                    <option>
                                        French Polynesia
                                    </option>
                                    <option>
                                        French Southern Territories
                                    </option>
                                    <option>
                                        Gabon
                                    </option>
                                    <option>
                                        Gambia
                                    </option>
                                    <option>
                                        Georgia
                                    </option>
                                    <option>
                                        Germany
                                    </option>
                                    <option>
                                        Ghana
                                    </option>
                                    <option>
                                        Gibraltar
                                    </option>
                                    <option>
                                        Greece
                                    </option>
                                    <option>
                                        Greenland
                                    </option>
                                    <option>
                                        Grenada
                                    </option>
                                    <option>
                                        Guadeloupe
                                    </option>
                                    <option>
                                        Guam
                                    </option>
                                    <option>
                                        Guatemala
                                    </option>
                                    <option>
                                        Guernsey
                                    </option>
                                    <option>
                                        Guinea
                                    </option>
                                    <option>
                                        Guinea-Bissau
                                    </option>
                                    <option>
                                        Guyana
                                    </option>
                                    <option>
                                        Haiti
                                    </option>
                                    <option>
                                        Honduras
                                    </option>
                                    <option>
                                        Hong Kong
                                    </option>
                                    <option>
                                        Hungary
                                    </option>
                                    <option>
                                        Iceland
                                    </option>
                                    <option>
                                        India
                                    </option>
                                    <option>
                                        Indonesia
                                    </option>
                                    <option>
                                        Iran
                                    </option>
                                    <option>
                                        Iraq
                                    </option>
                                    <option>
                                        Ireland
                                    </option>
                                    <option>
                                        Isle of Man
                                    </option>
                                    <option>
                                        Italy
                                    </option>
                                    <option>
                                        Ivory Coast
                                    </option>
                                    <option>
                                        Jamaica
                                    </option>
                                    <option>
                                        Japan
                                    </option>
                                    <option>
                                        Jersey
                                    </option>
                                    <option>
                                        Jordan
                                    </option>
                                    <option>
                                        Kazakhstan
                                    </option>
                                    <option>
                                        Kenya
                                    </option>
                                    <option>
                                        Kiribati
                                    </option>
                                    <option>
                                        Kuwait
                                    </option>
                                    <option>
                                        Kyrgyzstan
                                    </option>
                                    <option>
                                        Laos
                                    </option>
                                    <option>
                                        Latvia
                                    </option>
                                    <option>
                                        Lebanon
                                    </option>
                                    <option>
                                        Lesotho
                                    </option>
                                    <option>
                                        Liberia
                                    </option>
                                    <option>
                                        Libya
                                    </option>
                                    <option>
                                        Liechtenstein
                                    </option>
                                    <option>
                                        Lithuania
                                    </option>
                                    <option>
                                        Luxembourg
                                    </option>
                                    <option>
                                        Macao
                                    </option>
                                    <option>
                                        Macedonia
                                    </option>
                                    <option>
                                        Madagascar
                                    </option>
                                    <option>
                                        Malawi
                                    </option>
                                    <option>
                                        Malaysia
                                    </option>
                                    <option>
                                        Maldives
                                    </option>
                                    <option>
                                        Mali
                                    </option>
                                    <option>
                                        Malta
                                    </option>
                                    <option>
                                        Marshall Islands
                                    </option>
                                    <option>
                                        Martinique
                                    </option>
                                    <option>
                                        Mauritania
                                    </option>
                                    <option>
                                        Mauritius
                                    </option>
                                    <option>
                                        Mayotte
                                    </option>
                                    <option>
                                        Mexico
                                    </option>
                                    <option>
                                        Micronesia
                                    </option>
                                    <option>
                                        Moldova
                                    </option>
                                    <option>
                                        Monaco
                                    </option>
                                    <option>
                                        Mongolia
                                    </option>
                                    <option>
                                        Montenegro
                                    </option>
                                    <option>
                                        Montserrat
                                    </option>
                                    <option>
                                        Morocco
                                    </option>
                                    <option>
                                        Mozambique
                                    </option>
                                    <option>
                                        Myanmar
                                    </option>
                                    <option>
                                        Namibia
                                    </option>
                                    <option>
                                        Nauru
                                    </option>
                                    <option>
                                        Nepal
                                    </option>
                                    <option>
                                        Netherlands
                                    </option>
                                    <option>
                                        New Caledonia
                                    </option>
                                    <option>
                                        New Zealand
                                    </option>
                                    <option>
                                        Nicaragua
                                    </option>
                                    <option>
                                        Niger
                                    </option>
                                    <option>
                                        Nigeria
                                    </option>
                                    <option>
                                        Niue
                                    </option>
                                    <option>
                                        Norfolk Island
                                    </option>
                                    <option>
                                        North Korea
                                    </option>
                                    <option>
                                        Northern Mariana Islands
                                    </option>
                                    <option>
                                        Norway
                                    </option>
                                    <option>
                                        Oman
                                    </option>
                                    <option>
                                        Pakistan
                                    </option>
                                    <option>
                                        Palau
                                    </option>
                                    <option>
                                        Palestine
                                    </option>
                                    <option>
                                        Panama
                                    </option>
                                    <option>
                                        Papua New Guinea
                                    </option>
                                    <option>
                                        Paraguay
                                    </option>
                                    <option>
                                        Peru
                                    </option>
                                    <option>
                                        Philippines
                                    </option>
                                    <option>
                                        Pitcairn
                                    </option>
                                    <option>
                                        Poland
                                    </option>
                                    <option>
                                        Portugal
                                    </option>
                                    <option>
                                        Puerto Rico
                                    </option>
                                    <option>
                                        Qatar
                                    </option>
                                    <option>
                                        Réunion
                                    </option>
                                    <option>
                                        Romania
                                    </option>
                                    <option>
                                        Russian Federation
                                    </option>
                                    <option>
                                        Rwanda
                                    </option>
                                    <option>
                                        Saint Barthélemy
                                    </option>
                                    <option>
                                        Saint Helena, Ascension and Tristan da Cunha
                                    </option>
                                    <option>
                                        Saint Kitts and Nevis
                                    </option>
                                    <option>
                                        Saint Lucia
                                    </option>
                                    <option>
                                        Saint Martin (French part)
                                    </option>
                                    <option>
                                        Saint Pierre and Miquelon
                                    </option>
                                    <option>
                                        Saint Vincent and the Grenadines
                                    </option>
                                    <option>
                                        Samoa
                                    </option>
                                    <option>
                                        San Marino
                                    </option>
                                    <option>
                                        Sao Tome and Principe
                                    </option>
                                    <option>
                                        Saudi Arabia
                                    </option>
                                    <option>
                                        Senegal
                                    </option>
                                    <option>
                                        Serbia
                                    </option>
                                    <option>
                                        Seychelles
                                    </option>
                                    <option>
                                        Sierra Leone
                                    </option>
                                    <option>
                                        Singapore
                                    </option>
                                    <option>
                                        Sint Maarten (Dutch part)
                                    </option>
                                    <option>
                                        Slovakia
                                    </option>
                                    <option>
                                        Slovenia
                                    </option>
                                    <option>
                                        Solomon Islands
                                    </option>
                                    <option>
                                        Somalia
                                    </option>
                                    <option>
                                        South Africa
                                    </option>
                                    <option>
                                        South Georgia and the South Sandwich Islands
                                    </option>
                                    <option>
                                        South Korea
                                    </option>
                                    <option>
                                        South Sudan
                                    </option>
                                    <option>
                                        Spain
                                    </option>
                                    <option>
                                        Sri Lanka
                                    </option>
                                    <option>
                                        Sudan
                                    </option>
                                    <option>
                                        Suriname
                                    </option>
                                    <option>
                                        Svalbard and Jan Mayen
                                    </option>
                                    <option>
                                        Swaziland
                                    </option>
                                    <option>
                                        Sweden
                                    </option>
                                    <option>
                                        Switzerland
                                    </option>
                                    <option>
                                        Syrian Arab Republic
                                    </option>
                                    <option>
                                        Taiwan
                                    </option>
                                    <option>
                                        Tajikistan
                                    </option>
                                    <option>
                                        Tanzania
                                    </option>
                                    <option>
                                        Thailand
                                    </option>
                                    <option>
                                        Timor-Leste
                                    </option>
                                    <option>
                                        Togo
                                    </option>
                                    <option>
                                        Tokelau
                                    </option>
                                    <option>
                                        Tonga
                                    </option>
                                    <option>
                                        Trinidad and Tobago
                                    </option>
                                    <option>
                                        Tunisia
                                    </option>
                                    <option>
                                        Turkey
                                    </option>
                                    <option>
                                        Turkmenistan
                                    </option>
                                    <option>
                                        Turks and Caicos Islands
                                    </option>
                                    <option>
                                        Tuvalu
                                    </option>
                                    <option>
                                        Uganda
                                    </option>
                                    <option>
                                        Ukraine
                                    </option>
                                    <option>
                                        United Arab Emirates
                                    </option>
                                    <option>
                                        United Kingdom
                                    </option>
                                    <option>
                                        United States
                                    </option>
                                    <option>
                                        United States Minor Outlying Islands
                                    </option>
                                    <option>
                                        Uruguay
                                    </option>
                                    <option>
                                        Uzbekistan
                                    </option>
                                    <option>
                                        Vanuatu
                                    </option>
                                    <option>
                                        Vatican City
                                    </option>
                                    <option>
                                        Venezuela
                                    </option>
                                    <option>
                                        Viet Nam
                                    </option>
                                    <option>
                                        Virgin Islands, British
                                    </option>
                                    <option>
                                        Virgin Islands, U.S.
                                    </option>
                                    <option>
                                        Wallis and Futuna
                                    </option>
                                    <option>
                                        Western Sahara
                                    </option>
                                    <option>
                                        Yemen
                                    </option>
                                    <option>
                                        Zambia
                                    </option>
                                    <option>
                                        Zimbabwe
                                    </option>
                                </select>
                                @error('country')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="date" class="form-label fw-semibold"><i class="text-danger">*</i> Date</label>
                            <input type="date" name="date" value="{{$trial_class_schedule->date}}" class="form-control" id="date" >
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="time" class="form-label fw-semibold">Time</label>
                            <input type="time" name="time" value="{{date('H:i', strtotime($trial_class_schedule->time))}}" class="form-control" id="time" >
                            @error('time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="teacher_id" class="form-label fw-semibold"><i class="text-danger">* </i>Teacher</label>
                              <select id="teacher_id" name="teacher_id" class="form-select select2" required>
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{$trial_class_schedule->teacher_id == $teacher->id ? 'selected' : ''}}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="coordinator_id" class="form-label fw-semibold">Coordinator</label>
                              <select id="coordinator_id" name="coordinator_id" class="form-select select2">
                                  <option value="">Select Coordinator</option>
                                  @foreach($customerSupportExecutives as $customerSupportExecutive)
                                  <option value="{{ $customerSupportExecutive->id }}" @if($customerSupportExecutive->id == $trial_class_schedule->coordinator_id) selected @endif>{{ $customerSupportExecutive->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="available_seats" class="form-label fw-semibold">Available Seats</label>
                                <input type="number" name="available_seats" value="{{ $trial_class_schedule->available_seats }}" class="form-control" id="available_seats" >
                                @error('available_seats')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                        </div>
                    </div>
                        <div class="col-12">
                          <div class=" align-items-center justify-content-end mt-4 gap-3">
                            <a class="btn btn-light" href="/trial-class-schedule">Back</a>
                            <button class="btn btn-danger float-end"><a href="/inactive-schedule/{{$trial_class_schedule->id}}" class="link-light">Inactive</a></button>
                            <button type="submit" class="btn btn-primary float-end me-2">Update</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
<script src="{{asset('assets/js/trial-class/edit-page-1.0.0.js')}}"></script>
</x-dashboard.admin-layout>