@extends('layouts.dashboard.master')
@section('title') Dashboard | {{ ucfirst(auth()->user()->user_type) }} @endsection
{{-- @section('title-heading_1')
<li class="breadcrumb-item">Home</li>
@endsection --}}
@section('content')
<div class="container-fluid dashboard-default-sec">
    {{-- @if (in_array($authUserEmail, $developersEmails))
        <div class="row">
            <!-- Developers -->
            <div class="col-xl-12 col-md-12 col-sm-12 box-col-3 des-xl-25 rate-sec">
                <div class="card income-card">
                    <div class="card-body text-center">
                        <div class="round-box">
                            <i data-feather="code" style="width: 32px; height: 32px;"></i>
                        </div>
                        <h5>{{ \App\Models\User::ofType('developer')->count() }}</h5>
                        <p class="fw-bold fs-6">المطورين</p>
                        <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                        <a class="btn-arrow arrow-primary" href="{{ route('users.DevelopersIndex') }}"
                        style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:1%; border-radius:5px; transition: 0.40s ease-in-out;"
                        onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                        <i data-feather="navigation"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    @if(session()->has('search_warning'))
    <div class="alert alert-warning text-center w-75 mx-auto" id="alert-warning-message">
        <p class="position-absolute top-0 end-0">
            <span class="close-btn f-30" onclick="dismissMessage('alert-warning-message');"><i class="icofont icofont-ui-close"></i></span>
        </p>
        <span class="text-dark">{{ session()->get('search_warning') }}</span>
    </div>
    @endif

    <div class="row">
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- Users --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i data-feather="users" style="width: 32px; height: 32px;"></i>
                            </div>
                            <h5>{{ \App\Models\User::count() }}</h5>
                            <p class="fw-bold fs-6">Users</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('users.UsersIndex') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Doctors --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-doctor f-38"></i>
                            </div>
                            <h5>{{ \App\Models\User::ofType('doctor')->count() }}</h5>
                            <p class="fw-bold fs-6">Doctors</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('users.DoctorsIndex') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- Employees --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-worker-group f-62"></i>
                            </div>
                            <h5>{{ \App\Models\User::ofType('employee')->count() }}</h5>
                            <p class="fw-bold fs-6">Employees</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('users.EmployeesIndex') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Patients --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-bed-patient f-42"></i>
                            </div>
                            <h5>{{ \App\Models\Patient::count() }}</h5>
                            <p class="fw-bold fs-6">Patients</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('patients.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- Appointments --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="fa fa-ticket fa-3x"></i>
                            </div>
                            <h5>{{ \App\Models\Appointment::count() }}</h5>
                            <p class="fw-bold fs-6">Appiontments</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('appointments.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Prescriptions --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-paper f-42"></i>
                            </div>
                            <h5>{{ \App\Models\Prescription::count() }}</h5>
                            <p class="fw-bold fs-6">Prescriptions</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('prescriptions.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- Last Visits --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-ui-calendar f-40"></i>
                            </div>
                            <h5>{{ \App\Models\LastVisit::count() }}</h5>
                            <p class="fw-bold fs-6">Patients Last Visits</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('patients.lastVisitsIndex') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Materials --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-injection-syringe f-42 p-1"></i>
                                <i class="icofont icofont-capsule f-32 p-1"></i>
                                <i class="icofont icofont-drug f-30 p-1"></i>
                            </div>
                            <h5>{{ \App\Models\Material::count() }}</h5>
                            <p class="fw-bold fs-6">Materials</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('materials.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- X-rays --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-tooth f-34"></i>
                            </div>
                            <h5>{{ \App\Models\XRay::count() }}</h5>
                            <p class="fw-bold fs-6">X-rays</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('x-rays.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Treatments --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-first-aid-alt f-34"></i>
                            </div>
                            <h5>{{ \App\Models\Treatment::count() }}</h5>
                            <p class="fw-bold fs-6">Treatments</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('treatments.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="row">
                {{-- Payments --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-money-bag f-38"></i>
                            </div>
                            <h5>{{ \App\Models\Payment::count() }}</h5>
                            <p class="fw-bold fs-6">Payments</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('payments.index') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- Receipts --}}
                <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <i class="icofont icofont-money-bag f-38"></i>
                            </div>
                            <h5>{{ \App\Models\Payment::count() }}</h5>
                            <p class="fw-bold fs-6">Receipts</p>
                            <span style="color:white;">⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯</span>
                            <a class="btn-arrow arrow-primary" href="{{ route('receipts.index.pdf') }}"
                            style="color:#FFFFFF; background-color:rgb(95, 95, 95); padding:4%; border-radius:5px; transition: 0.40s ease-in-out;"
                            onMouseOver="this.style.backgroundColor='#BA895D'" onMouseOut="this.style.backgroundColor='rgb(95, 95, 95)'">
                            <i data-feather="navigation"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
