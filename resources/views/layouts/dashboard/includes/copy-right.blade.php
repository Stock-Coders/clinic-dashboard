@php
    // Get the current year
    $currentYear = date('Y');

    // Set your specific year (e.g., the year of establishment)
    $establishmentYear = 2023; // Replace with your desired establishment year

    // Ensure the copyright year does not exceed the current year
    $copyrightYear = ($establishmentYear > $currentYear) ? $currentYear : $establishmentYear;
@endphp
Copyright © {{ $copyrightYear }}-{{ $copyrightYear + 1 }} <span class="text-primary fw-bold">StockCoders</span> (software company). All rights reserved.
