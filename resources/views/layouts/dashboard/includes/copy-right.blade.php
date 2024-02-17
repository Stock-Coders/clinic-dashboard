@php
    // Get the current year
    $currentYear = date('Y');
    // Set your specific year (e.g., the year of establishment)
    $establishmentYear = 2023; // Replace with your desired establishment year
    // Ensure the copyright year does not exceed the current year
    $copyrightYear = ($establishmentYear > $currentYear) ? $currentYear : $establishmentYear;
@endphp
<span class="@if(Route::is('telescope')) text-warning font-weight-bold @else text-primary fw-bold @endif">{{ env('APP_NAME') }}</span>
- Copyright © {{ $copyrightYear }}-{{ $copyrightYear + 1 }}
<span class="@if(Route::is('telescope')) text-warning font-weight-bold @else text-primary fw-bold @endif">Codex Software Services &trade;</span>
(Software Company).@if(!Route::is('dashboard.login') && !Route::is('dashboard.register') && !Route::is('telescope') && !Route::is('dashboard.debugging') && !Route::is('*pdf*')) <br/> @endif All rights reserved.
