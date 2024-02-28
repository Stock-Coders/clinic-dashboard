<div class="page-main-header">
    <div class="main-header-right row m-0">
      <div class="main-header-left">
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="light-logo img-fluid" width="160" src="{{asset('/assets/dashboard/images/custom-images/logos/light_codex_full_logo.png')}}" alt=""></a></div>
        <div class="dark-logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" width="160" src="{{asset('/assets/dashboard/images/custom-images/logos/dark_codex_full_logo.png')}}" alt=""></a></div>
        @auth
        <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
        @endauth
      </div>
      @auth
      <div class="left-menu-header col">
        <ul>
          <li>
            <form action="{{ route('dashboard.search') }}" class="form-inline search-form">
              <div class="search-bg"><i class="fa fa-search"></i>
                <input class="form-control-plaintext" name="search_query" placeholder="Search for specific users, patients, representatives or materials?" size="500">
              </div>
            </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
          </li>
        </ul>
      </div>
      @endauth
      <div class="nav-right col pull-right right-menu p-0">
        <ul class="nav-menus">
          <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
          {{-- <li class="onhover-dropdown">
            <div class="bookmark-box"><i data-feather="star"></i></div>
            <div class="bookmark-dropdown onhover-show-div">
              <div class="form-group mb-0">
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                  <input class="form-control" type="text" placeholder="Search for bookmark...">
                </div>
              </div>
              <ul class="m-t-5">
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="inbox"></i>Email<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="message-square"></i>Chat<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="command"></i>Feather Icon<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="airplay"></i>Widgets<span class="pull-right"><i data-feather="star">   </i></span></li>
              </ul>
            </div>
          </li> --}}
          @auth
          <li class="onhover-dropdown">
            <div class="notification-box">
                <i data-feather="bell"></i>
                @php
                    $newAppointments = \App\Models\Appointment::where('created_at', '>=', now()->subHours(24))
                                        ->where('doctor_id', auth()->user()->id) // Exclude appointments created by the current user
                                        ->where('create_user_id', '!=', auth()->user()->id)
                                        ->exists();

                    $newPayments = \App\Models\Payment::where('created_at', '>=', now()->subHours(24))
                                    ->where('create_user_id', '!=', auth()->user()->id) // Exclude payments created by the current user
                                    ->exists();
                @endphp
                @if(auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
                auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                auth()->user()->email === "codexsoftwareservices01@gmail.com")
                    @if($newAppointments || $newPayments)
                    <span class="dot-animated"></span>
                    @endif
                @endif
            </div>
            <ul class="notification-dropdown onhover-show-div">
              <li>
                @php
                    $appointments = \App\Models\Appointment::where('created_at', '>=', now()->subHours(24))
                                    ->where('doctor_id', auth()->user()->id) // Exclude appointments created by the current user
                                    ->where('create_user_id', '!=', auth()->user()->id)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(4)
                                    ->get();
                    $payments = \App\Models\Payment::where('created_at', '>=', now()->subHours(24))
                                    ->where('create_user_id', '!=', auth()->user()->id) // Exclude payments created by the current user
                                    ->orderBy('created_at', 'desc')
                                    ->limit(4)
                                    ->get();
                     // Combine appointments and payments queries using union()
                    // $appointmentsAndPayments = $appointments->union($payments)->get();
                @endphp
                <p class="f-w-700 mb-0">You have <span class="text-danger fw-bold">{{ $appointments->count() + $payments->count() }}</span> Notifications<span class="pull-right badge badge-primary badge-pill">{{ $appointments->count() + $payments->count() }}</span></p>
              </li>
              <li class="noti-primary">
                <div class="media">
                    {{-- @if($newAppointments)
                        <span class="notification-bg bg-light-secondary">
                            <i data-feather="activity"></i>
                        </span>
                    @elseif($newPayments)
                        <span class="notification-bg bg-light-success">
                            <i data-feather="activity"></i>
                        </span>
                    @endif --}}
                  <div class="media-body">
                    {{-- <p>
                        <a href="{{ route('appointments.index') }}">Appointments (Patients)</a>
                    </p> --}}
                    <span>
                        {{-- @if($newAppointments) --}}
                            <ul>
                                @foreach($appointments as $appointment)
                                    <li>
                                        <div class="d-flex">
                                            @if($newAppointments)
                                                <div>
                                                    <span class="notification-bg bg-light-secondary">
                                                        <i data-feather="activity"></i>
                                                    </span>
                                                </div>
                                            @elseif($newPayments)
                                                <div>
                                                    <span class="notification-bg bg-light-success">
                                                        <i data-feather="money"></i>
                                                    </span>
                                                </div>
                                            @endif
                                            @if($newAppointments)
                                                <div>
                                                    <a href="{{ route('appointments.show', $appointment->id) }}" class="text-decoration-underline">
                                                        {{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name ?? '-' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        {{-- @endif --}}
                    </span>
                  </div>
                </div>
              </li>
              {{-- <li class="noti-secondary">
                <div class="media"><span class="notification-bg bg-light-secondary"><i data-feather="check-circle"> </i></span>
                  <div class="media-body">
                    <p>Order Complete</p><span>1 hour ago</span>
                  </div>
                </div>
              </li>
              <li class="noti-success">
                <div class="media"><span class="notification-bg bg-light-success"><i data-feather="file-text"> </i></span>
                  <div class="media-body">
                    <p>Tickets Generated</p><span>3 hour ago</span>
                  </div>
                </div>
              </li>
              <li class="noti-danger">
                <div class="media"><span class="notification-bg bg-light-danger"><i data-feather="user-check"> </i></span>
                  <div class="media-body">
                    <p>Delivery Complete</p><span>6 hour ago</span>
                  </div>
                </div>
              </li> --}}
            </ul>
          </li>
          @endauth
          <li>
            <div class="mode"><i class="fa fa-moon-o"></i></div>
          </li>
          {{-- <li class="onhover-dropdown"><i data-feather="message-square"></i>
            <ul class="chat-dropdown onhover-show-div">
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{asset('/assets/dashboard/images/user/4.jpg')}}" alt="">
                  <div class="media-body"><span>Ain Chavez</span>
                    <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">32 mins ago</p>
                </div>
              </li>
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{asset('/assets/dashboard/images/user/1.jpg')}}" alt="">
                  <div class="media-body"><span>Erica Hughes</span>
                    <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">58 mins ago</p>
                </div>
              </li>
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{asset('/assets/dashboard/images/user/2.jpg')}}" alt="">
                  <div class="media-body"><span>Kori Thomas</span>
                    <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">1 hr ago</p>
                </div>
              </li>
              <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">See All     </a></li>
            </ul>
          </li> --}}
          @auth
            <li class="onhover-dropdown p-0">
                <a class="dropdown-item btn btn-primary-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">
                    <i data-feather="log-out"></i>
                    Log Out
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </a>
            </li>
          @endauth
          @guest
            <li class="onhover-dropdown p-0">
                <a class="dropdown-item btn btn-primary-light" href="{{ route('dashboard.login') }}">
                    <i data-feather="log-in"></i>
                    Log In
                </a>
            </li>
          @endguest
        </ul>
      </div>
      <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
  </div>
