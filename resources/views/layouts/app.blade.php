<!DOCTYPE html>
<html lang="en"data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP IDN</title>



    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>" type="image/svg+xml">



    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/iconly.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.css') }}"> --}}
        @livewireStyles

</head>

<body>
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">

        <div id="main">

           @include('livewire.partials.navbar')

           @include('livewire.partials.sidebar')

            <div wire:key="{{ Route::currentRouteName() }}">
                {{ $slot }}
            </div>


        </div>
    </div>
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    {{-- <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script> --}}


    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>





    {{-- <!-- Need: Apexcharts -->
    <script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/dashboard.js') }}"></script> --}}
    @livewireScripts

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@stack('scripts')



<script>
    function initAppLogout() {
        const logoutBtn = document.getElementById("btn-logout");
        const logoutForm = document.getElementById("logout-form");

        if (logoutBtn && logoutForm) {
            // Clone to remove old listeners
            const newBtn = logoutBtn.cloneNode(true);
            logoutBtn.parentNode.replaceChild(newBtn, logoutBtn);

            newBtn.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent default link behavior
                Swal.fire({
                    title: 'Yakin mau logout?',
                    text: "Kamu akan keluar dari aplikasi.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        logoutForm.submit();
                    }
                })
            });
        }
    }

    function initMazerSidebar() {
        const burgerBtn = document.querySelector('.burger-btn');
        const sidebar = document.querySelector('#sidebar');
        const sidebarHide = document.querySelector('.sidebar-hide');

        if (burgerBtn && sidebar) {
            // Clone to remove potential duplicate listeners from app.js if it runs
            const newBurger = burgerBtn.cloneNode(true);
            burgerBtn.parentNode.replaceChild(newBurger, burgerBtn);
            
            newBurger.addEventListener('click', (e) => {
                e.preventDefault();
                sidebar.classList.toggle('active');
            });
        }

        if (sidebarHide && sidebar) {
            const newHide = sidebarHide.cloneNode(true);
            sidebarHide.parentNode.replaceChild(newHide, sidebarHide);

            newHide.addEventListener('click', (e) => {
                e.preventDefault();
                sidebar.classList.toggle('active');
            });
        }
        
        // Re-init Perfect Scrollbar if needed (optional, check if element exists)
        // const container = document.querySelector('.sidebar-wrapper');
        // if (container && typeof PerfectScrollbar !== 'undefined') {
        //     new PerfectScrollbar(container);
        // }
    }

    document.addEventListener("DOMContentLoaded", () => {
        initAppLogout();
        // Mazer app.js handles sidebar on load, so we might not need to init here, 
        // but to be safe and consistent with navigation:
        // initMazerSidebar(); 
    });

    document.addEventListener("livewire:navigated", () => {
        initAppLogout();
        initMazerSidebar();
        
        // Re-init Bootstrap Tooltips/Popovers if used
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }
    });
</script>

</body>
</html>
