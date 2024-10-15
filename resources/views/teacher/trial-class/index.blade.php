<x-dashboard.teacher-layout>
    <x-slot name='title'>Trial Classes - Dreamers Academy</x-slot>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Trial Classes</h4>
                                <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trial Classes</li>
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
                <div class="col-md-12">
                    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row" role="tablist">
                        @foreach($tabs as $key => $tab)
                            <li class="nav-item @if($key == 0) first_tab @endif">
                                <a href="#custom_tab" class="
                                nav-link
                                d-flex
                                align-items-center
                                justify-content-center
                                px-3 px-md-3
                                me-0 me-md-2 text-body-color
                                @if($key == 0) active @endif
                            " data-bs-toggle="tab" role="tab"
                              data-content="{{ route($tab['route'], ['condition' => $tab['condition']]) }}">
                                    <i class="ti {{ $tab['icon'] }} fill-white me-0 me-md-1"></i>
                                    <span class="d-none d-md-block font-weight-medium">{{ $tab['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="" id="custom_tab">
                <div  class="tab-pane tab-content" role="tabpanel">

                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{asset('assets/js/teacher/trial-class/trialClass-1.0.0.js')}}"></script>
        <script src="{{asset('assets/js/ajax_tab-1.0.1.js')}}"></script>
    </x-slot>
</x-dashboard.teacher-layout>
