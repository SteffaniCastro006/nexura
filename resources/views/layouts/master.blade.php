<!DOCTYPE html>
<html lang="en" dir="">

@include('layouts.partials.header')

<body class="text-left ">

    <div class="app-admin-wrap layout-sidebar-large clearfix">

        @include('layouts.partials.navbar')


        <!--=============== Left side End ================-->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content">
                @yield('content')
            </div>
        </div>

        <!-- ============ Body content End ============= -->

    </div>

    @include('layouts.partials.scripts')

    @yield('scripts')
</body>

</html>