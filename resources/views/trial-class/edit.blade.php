@php
    use App\Models\TrialClass;
@endphp
<x-dashboard.admin-layout>
    <x-slot name='title'>Trial Class - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Update Trial Class</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Edit Trial Class</li>
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
        @php
            $tralClassStatus = $trial_class->status;
            $readOnlyMode = $disabledMode = '';
            if($tralClassStatus == 'Admitted'){
                $readOnlyMode = 'readonly';
                $disabledMode = 'disabled';
            }
        @endphp
        <div class="row">
            <div class="col-12">
          <div class="w-100 position-relative overflow-hidden mb-0">
                <div class="p-1">
                  <div class="nav nav-pills mb-3 rounded align-items-center flex-row">
                      <h5 class="card-title fw-semibold">Edit Trial Class</h5>
                      @if (Auth::guard('web')->user()->can('trialclass_schedule.add'))
                      <small class="ms-auto">
                        <a href="/trial-class" class="btn btn-primary d-flex align-items-center px-3" id="add-notes">
                          <i class="ti ti-list me-0 me-md-1 fs-4"></i>
                          <span class="d-none d-md-block font-weight-medium fs-3">Trial Class</span>
                        </a>
                      </small>
                      @endif
                  </div>
                  
                  <div class="row">
                    <div class="col-md-8">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <form class="row g-3" action="{{ route('trial-class.update', $trial_class->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row">
                                      <div class="col-md-6 mb-4">
                                          <span style="color:#e41111">*</span>
                                          <input type="hidden" id="trial_class_id" name="trial_class_id" value="{{$trial_class->trial_class_id}}">
                                          <input type="hidden" id="action_id" name="action_id" value="{{$trial_class->id}}">
                                          <input type="hidden" id="teacher_id" name="teacher_id" value="{{$trial_class->schedule->teacher_id}}">
            
                                          <label for="gurdian_name" class="form-label fw-semibold">Gurdian Name</label>
                                          <input type="text" name="gurdian_name" value="{{ $trial_class->gurdian_name }}" class="form-control" id="gurdian_name" {{ $readOnlyMode }}>
                                      </div>
                                      <div class="col-md-6 mb-4">
                                          <span style="color:#e41111">*</span>
                                          <label for="email" class="form-label fw-semibold">Email </label>
                                          <input type="email" name="email" value="{{ $trial_class->email }}" class="form-control" id="email" {{ $readOnlyMode }}>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="phone" class="form-label fw-semibold">Phone</label>
                                            <input type="text" name="phone" value="{{ $trial_class->phone }}" class="form-control" id="phone" {{ $readOnlyMode }}>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="occupation" class="form-label fw-semibold">Occupation</label>
                                            <input type="text" name="occupation" value="{{ $trial_class->occupation }}" class="form-control" id="occupation" {{ $readOnlyMode }}>
                                        </div>
                                    </div>
            
                                    <input type="hidden" id="selected_country" name="selected_country" value="{{ $trial_class->country }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="country" class="form-label fw-semibold">Country</label>
                                            <select id="country" name="country" class="form-select select2"  {{ $disabledMode }}>
                                                <option value="" selected="" disabled="">
                                                    Choose...
                                                </option>
                                                <option>
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
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="payable_amount" class="form-label fw-semibold">Payable Ammount</label>
                                            <input type="text" name="payable_amount" class="form-control" value="{{ $trial_class->payable_amount }}" id="payable_amount" {{ $readOnlyMode }}>
                                            @error('payable_amount')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="student_name" class="form-label fw-semibold">Student Name</label>
                                            <input type="text" name="student_name" value="{{ $trial_class->student_name }}" class="form-control" id="student_name"  {{ $readOnlyMode }}>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="age" class="form-label fw-semibold">Age</label>
                                            <input type="text" name="age" value="{{ $trial_class->age }}" class="form-control" id="age"  {{ $readOnlyMode }}>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="school" class="form-label fw-semibold">School </label>
                                            <input type="text" name="school" value="{{ $trial_class->school }}" class="form-control" id="school" {{ $readOnlyMode }}>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <span style="color:#e41111">*</span>
                                            <label for="gender" class="form-label fw-semibold">Gender </label>
                                            <select id="gender" name="gender" class="form-select" {{ $disabledMode }}>
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ $trial_class->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ $trial_class->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label class="form-label fw-semibold">Instructor Name : </label>
                                            <input type="text"  value="{{$trial_class->schedule->teacher->name}}" class="form-control bg-body-secondary" readonly>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label class="form-label fw-semibold">Trial Class Date  :</label>
                                            <input type="text"  value="{{$trial_class->schedule->date}}" class="form-control bg-body-secondary" readonly>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label class="form-label fw-semibold">Trial Class Time :</label>
                                            <input type="text"  value="{{date('h:i A', strtotime($trial_class->schedule->time))}}" class="form-control bg-body-secondary" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <input type="hidden" name="prev_status" value="{{$trial_class->status}}">
                                            <span style="color:#e41111">*</span>
                                            <label for="status" class="form-label fw-semibold">Status</label>
                                            <select id="status" name="status" class="form-select" onchange="getTrialClassDateSchedules()" {{ $disabledMode }} required>
                                                <option value="">Select Status</option>
                                                <option value="Registered" {{ $trial_class->status == 'Registered' ? 'selected' : '' }}>Registered</option>
                                                <option value="Attended" {{ $trial_class->status == 'Attended' ? 'selected' : '' }}>Attended</option>
                                                <option value="Refused Admission" {{ $trial_class->status == 'Refused Admission' ? 'selected' : '' }}>Refused Admission</option>
                                                <option value="Will Admit Later" {{ $trial_class->status == 'Will Admit Later' ? 'selected' : '' }}>Will Admit Later</option>
                                                <option value="Admitted" {{ $trial_class->status == 'Admitted' ? 'selected' : '' }}>Admitted</option>
                                                @if(can('trial_class_invalid'))
                                                    <option value="{{ TrialClass::STATUS_INVALID }}" @if($trial_class->status == TrialClass::STATUS_INVALID) selected @endif>{{ TrialClass::STATUS_INVALID }}</option>
                                                    <option value="{{ TrialClass::STATUS_NOT_INTERESTED }}" @if($trial_class->status == TrialClass::STATUS_NOT_INTERESTED) selected @endif>{{ TrialClass::STATUS_NOT_INTERESTED }}</option>
                                                @endif
                                                <option value="Absent" {{ $trial_class->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                                <option value="Rescheduled" {{ $trial_class->status == 'Rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                                <option value="Will Attend" {{ $trial_class->status == 'Will Attend' ? 'selected' : '' }}>Will Attend</option>
                                                <option value="Payment Pending" {{ $trial_class->status == 'Payment Pending' ? 'selected' : '' }}>Payment Pending</option>
                                                <option value="Decision Pending" {{ $trial_class->status == 'Decision Pending' ? 'selected' : '' }}>Decision Pending</option>
                                                <option value="Not Reachable" {{ $trial_class->status == 'Not Reachable' ? 'selected' : '' }}>Not Reachable</option>
                                                <option value="Wants to Reschedule" {{ $trial_class->status == 'Wants to Reschedule' ? 'selected' : '' }}>Wants to Reschedule</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label for="preferable_language" class="form-label fw-semibold">Preferable Language</label>
                                            @if ($trial_class->language == 0)
                                                <input type="text" value="English" name="preferable_language" class="form-control bg-body-secondary" id="preferable_language" readonly>
                                            @elseif ($trial_class->language == 1)
                                                <input type="text" value="Bangla" name="preferable_language" class="form-control" id="preferable_language" readonly>
                                            @endif
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <span style="color:#e41111"></span>
                                            <label for="coordinator_id" class="form-label fw-semibold">Coordinator</label>
                                            <input type="text" value="{{ (!empty($trial_class->schedule->coordinator->name) ? $trial_class->schedule->coordinator->name : '') }}" name="" class="form-control" id="" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <span style="color:#e41111">*</span>
                                            <label for="sales_user_id" class="form-label fw-semibold">Assigned Sales Person </label>
                                            <select id="sales_user_id" name="sales_user_id" class="form-select" {{ (Auth::guard('web')->user()->can('trial_class.assignedUser') != 1) ? 'disabled' : '' }}>
                                                <option value="">
                                                    Select Sale Person
                                                </option>
                                                <?php foreach($getSalesUsers as $salesUser){ ?>
                                                    <option value="{{ $salesUser->user_id }}" {{ ($salesUser->user_id == $trial_class->sales_user_id) ? 'selected' : ''}}>
                                                        {{  (!empty($salesUser->user->name) ? $salesUser->user->name : '') }}
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12" id="available_dates">
            
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label for="note" class="form-label font-weight-bold">Note </label>
                                            <textarea rows="3" cols="50" maxlength="1000" name="note" class="form-control" {{ $readOnlyMode }}></textarea>
                                        </div>
                                    </div>
                                    @if($tralClassStatus != 'Admitted')
                                        <div class="col-12">
                                            <div class=" align-items-center justify-content-end mt-4 gap-3">
                                            <a class="btn btn-light" href="{{ $param }}">Back</a>
                                            <button type="submit" class="btn btn-primary float-end submitBtn">Submit</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                            <table class="table border table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Modifier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($action_histories as $key => $action_history)
                                        @if(empty($action_history->user_id))
                                        @else
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$action_history->status}}</td>
                                            <td>{{$action_history->date}}</td>
                                            <td>{{$action_history->changedBy->name}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                            <table class="table border table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th scope="col">Note</th>
                                        <th width="33%" >Date</th>
                                        <th scope="col">Submitted By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($note_histories as $note_history)
                                        <tr>
                                            <td>{{$note_history->note}}</td>
                                            <td>{{date('d M, Y', strtotime($note_history->created_at))}}<br> {{date('h:i A', strtotime($note_history->created_at."+6hours"))}}</td>
                                            <td>{{$note_history->stenographer->name}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>

                      <div class="card">
                        <div class="px-4 py-3 border-bottom">
                            <h5 class="card-title fw-semibold mb-0 lh-sm">Call History</h5>
                        </div>
                        <div class="card-body">
                            <table class="table border table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Submitted By</th>
                                        <th scope="col">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($callHistory as $key => $history)
                                        <tr>
                                            <td>{{$history->phone}}</td>
                                            <td>{{ $history->user->name }}</td>
                                            <td>{{date('d M, Y', strtotime($history->created_at))}}<br> {{date('h:i A', strtotime($history->created_at."+6hours"))}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                      </div>

                    </div>
                  </div>
            </div>
          </div>
        </div>
        </div>
    </div>
<script src="{{ asset('assets/js/trial-class/schedule/trial-class-schedule-1.2.6.js') }}"></script>
</x-dashboard.admin-layout>