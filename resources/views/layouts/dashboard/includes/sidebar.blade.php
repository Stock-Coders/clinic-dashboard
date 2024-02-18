<header class="main-nav">
    {{-- <div class="sidebar-user text-center"><a class="setting-primary" href="{{ route('users.edit', auth()->user()->id) }}"><i data-feather="settings"></i></a><img class="img-100 rounded-circle" src="{{ auth()->user()->profile->avatar ?? asset('/assets/dashboard/images/dashboard/no-avatar.png') }}" alt=""> --}}
    <div class="sidebar-user text-center"><a class="setting-primary" href="{{ route('users.edit', auth()->user()->id) }}"><i data-feather="settings"></i></a><img class="img-100 rounded-circle" src="{{ isset(auth()->user()->profile->avatar) != null ? Storage::url(auth()->user()->profile->avatar) : asset('/assets/dashboard/images/dashboard/no-avatar.png') }}" alt="">
      {{-- <div class="badge-bottom"><span class="badge badge-primary">New</span></div> --}}
        <a href="{{ route('authUserProfileView', [auth()->user()->username]) }}">
            <h6 class="mt-3 f-14 f-w-600">{{ auth()->user()->profile->name ?? auth()->user()->username }}</h6>
        </a>
      <p class="mb-0 font-roboto">{{ auth()->user()->user_role !== null ? ucfirst(auth()->user()->user_role) : "N/A" }}</p>
      {{-- <ul>
        <li><span><span class="counter">19.8</span>k</span>
          <p>Follow</p>
        </li>
        <li><span>2 year</span>
          <p>Experince</p>
        </li>
        <li><span><span class="counter">95.2</span>k</span>
          <p>Follower </p>
        </li>
      </ul> --}}
    </div>
    <nav>
      <div class="main-navbar">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="mainnav">
          <ul class="nav-menu custom-scrollbar">
            <li class="back-btn">
              <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>
            <li class="sidebar-main-title">
              <div class="text-center mt-0">
                <h6>{{ ucfirst(auth()->user()->user_type) }}s Dashboard</h6>
              </div>
            </li>
            <li class="dropdown"><a class="nav-link" href="{{ route('dashboard') }}"><i data-feather="home"></i><span>Dashboard</span></a></li>

            @if (auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
                auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                auth()->user()->email === "stockcoders99@gmail.com")

            @endif

            @if (auth()->user()->user_type === "doctor" || auth()->user()->user_type === "employee" || auth()->user()->user_type === "developer")
                {{-- Start Users --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="users"></i><span>Users</span></a>
                    <ul class="nav-submenu menu-content">
                        <li>
                            <a href="{{ route('users.UsersIndex') }}">
                                All Users
                                @if(auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                                auth()->user()->email === "stockcoders99@gmail.com")
                                    ({{ \App\Models\User::count() }})
                                @else
                                    ({{ \App\Models\User::where('user_type', '!==', 'developer')->count() }})
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('users.DoctorsIndex') }}">All Doctors ({{ \App\Models\User::ofType('doctor')->count() }})</a></li>
                        <li><a href="{{ route('users.EmployeesIndex') }}">All Employees ({{ \App\Models\User::ofType('employee')->count() }})</a></li>
                        @if(auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                            <li><a href="{{ route('users.DevelopersIndex') }}">All Developers ({{ \App\Models\User::ofType('developer')->count() }})</a></li>
                        @endif
                        @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
                        auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                            <li><a href="{{ route('users.create') }}">Create User</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Users --}}
                {{-- Start Patient --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="user"></i><span>Patients</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('patients.index') }}">All Patients ({{ \App\Models\Patient::count() }})</a></li>
                        <li><a href="{{ route('patients.lastVisitsIndex') }}"><i class="icofont icofont-ui-calendar f-20"></i> Last Visits ({{ \App\Models\LastVisit::count() }})</a></li>
                        <li><a href="{{ route('x-rays.index') }}"><i class="icofont icofont-tooth f-20"></i> X-rays ({{ \App\Models\XRay::count() }})</a></li>
                        <li><a href="{{ route('analyses.index') }}"><i class="icofont icofont-file-alt f-20"></i> Analyses ({{ \App\Models\Analysis::count() }})</a></li>
                        <li><a href="{{ route('medical-histories.index') }}"><i class="icofont icofont-history f-20"></i> Medical Histories ({{ \App\Models\MedicalHistory::count() }})</a></li>
                        <li><a href="{{ route('patients.create') }}">Create Patient</a></li>
                    </ul>
                </li>
                {{-- End Patient --}}
                {{-- Start Materials --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="plus-square"></i><span>Materials</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('materials.index') }}">All Materials ({{ \App\Models\Material::count() }})</a></li>
                        @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" || auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" || auth()->user()->email === "stockcoders99@gmail.com")
                        <li><a href="{{ route('materials.create') }}">Create Material</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Materials --}}
                {{-- Start Appointments --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="bell"></i><span>Appointments</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('appointments.index') }}">All Appointments ({{ \App\Models\Appointment::count() }})</a></li>
                        <li><a href="{{ route('appointments.create') }}">Create Appointment</a></li>
                        @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" || auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                        <li><a href="{{ route('appointments.trash') }}">All Trashed Appointment ({{ \App\Models\Appointment::onlyTrashed()->count() }})</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Appointments --}}
                {{-- Start Prescriptions --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="file-text"></i><span>Prescriptions</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('prescriptions.index') }}">All Prescriptions ({{ \App\Models\Prescription::count() }})</a></li>
                        @if(auth()->user()->user_type == "doctor"  || auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                            <li><a href="{{ route('prescriptions.create') }}">Create Prescription</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Prescriptions --}}
                {{-- Start Treatments --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="calendar"></i><span>Treatments</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('treatments.index') }}">All Treatments ({{ \App\Models\Treatment::count() }})</a></li>
                        <li><a href="{{ route('treatments.create') }}">Create Treatment</a></li>
                        <li><a href="{{ route('prescriptions-treatments.index') }}">All Treatments' Prescriptions ({{ \App\Models\PrescriptionTreatment::count() }})</a></li>
                        @if(auth()->user()->user_type == "doctor"  || auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                            <li><a href="{{ route('prescriptions-treatments.create') }}">Create Prescription for Treatment</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Treatments --}}
                {{-- Start Materials Treatments --}}
                @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
                auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                auth()->user()->email === "stockcoders99@gmail.com")
                    <li class="dropdown">
                        <a class="nav-link" href="{{ route('materials-treatments.index') }}"><i data-feather="grid"></i><span>Treatments' Materials</span></a>
                    </li>
                @endif
                {{-- End Materials Treatments --}}
                {{-- Start Representatives --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="aperture"></i><span>Representatives</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('representatives.index') }}">All Representatives ({{ \App\Models\Representative::count() }})</a></li>
                        @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
                        auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "stockcoders99@gmail.com")
                            <li><a href="{{ route('representatives.create') }}">Create Representative</a></li>
                        @endif
                    </ul>
                </li>
                {{-- End Representatives --}}
                {{-- Start Payments --}}
                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="database"></i><span>Payments</span></a>
                    <ul class="nav-submenu menu-content">
                        <li><a href="{{ route('payments.index') }}">All Payments ({{ \App\Models\Payment::count() }})</a></li>
                        <li><a href="{{ route('payments.create') }}">Create Payment</a></li>
                    </ul>
                </li>
                {{-- End Payments --}}
                
            @endif
            <li><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="headphones"></i><span>Support Ticket</span></a></li>
            @if(auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" || auth()->user()->email === "stockcoders99@gmail.com")
            <li class="dropdown"><a class="nav-link" href="{{ route('dashboard.debugging') }}"><i data-feather="cpu"></i><span>Debugging Tools</span></a></li>
            @endif
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </div>
    </nav>
  </header>
