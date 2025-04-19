<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>FinTek</title>
        <link rel="shortcut icon" href="{{ asset('icons/finance-report.ico') }}" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/template-css.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{ route('home') }}">FinTek</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        @if (auth()->user()->role === 'mahasiswa')
                        <li><a href="{{ route('auth.profile') }}" class="dropdown-item">{{ __('My Profile') }}</a></li>
                        @endif
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                @method('POST')
                                <button type="submit" class="dropdown-item">{{ __('Logout') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            @if (auth()->user()->role === 'mahasiswa')

                            <a href="{{ route('mhs.tagihan.index') }}" class="nav-link {{ request()->routeIs('mhs.tagihan.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-text" aria-hidden="true"></i></div>
                                Tagihan
                            </a>
                            <a href="{{ route('mhs.penundaan.index') }}" class="nav-link {{ request()->routeIs('mhs.penundaan.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-text" aria-hidden="true"></i></div>
                                Pengajuan Penundaan
                            </a>

                            @elseif (auth()->user()->role === 'superadmin')

                            <div class="sb-sidenav-menu-heading">Keuangan</div>

                            <a href="{{ route('admin.tagihan.index') }}" class="nav-link {{ request()->routeIs('admin.tagihan.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-line-chart" aria-hidden="true"></i></div>
                                Tagihan Mahasiswa
                            </a>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa fa-credit-card"></i></div>
                                Penundaan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{ request()->routeIs('superadmin.penundaan.index') ? 'active' : '' }} " href="{{ route('superadmin.penundaan.index') }}">Pengajuan Penundaan</a>
                                    <a class="nav-link {{ request()->routeIs('superadmin.perubahan-cicilan.index') ? 'active' : '' }} " href="{{ route('superadmin.perubahan-cicilan.index') }}">Pengajuan Perubahan</a>
                                    <a class="nav-link" href="#">Berjalan</a>
                                </nav>
                            </div>


                            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCicilan" aria-expanded="false" aria-controls="collapseCicilan">
                                <div class="sb-nav-link-icon"><i class="fa fa-credit-card"></i></div>
                                Cicilan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseCicilan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="#">Pengajuan</a>
                                    <a class="nav-link" href="#">Berjalan</a>
                                </nav>
                            </div> --}}

                            <a href="{{ route('superadmin.rkat.index') }}" class="nav-link {{ request()->routeIs('superadmin.rkat.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-line-chart" aria-hidden="true"></i></div>
                                RKAT
                            </a>

                            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRkat" aria-expanded="false" aria-controls="collapseRkat">
                                <div class="sb-nav-link-icon"><i class="fa fa-line-chart" aria-hidden="true"></i></div>
                                RKAT
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseRkat" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="#">Pengajuan</a>
                                    <a class="nav-link" href="#">Proses</a>
                                    <a class="nav-link" href="#">Berjalan</a>
                                </nav>
                            </div> --}}

                            <div class="sb-sidenav-menu-heading">Operasional</div>
                            <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-text" aria-hidden="true"></i></div>
                                Inventaris
                            </a>

                            <div class="sb-sidenav-menu-heading">Pengguna</div>

                            <a href="{{ route('superadmin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('superadmin.mahasiswa.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-circle" aria-hidden="true"></i></div>
                                Mahasiswa
                            </a>
                            <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-circle" aria-hidden="true"></i></div>
                                Dosen
                            </a>
                            <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                                User
                            </a>

                            <a href="{{ route('tahunAjaran.index') }}" class="nav-link {{ request()->routeIs('tahunAjaran.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-font-awesome" aria-hidden="true"></i></div>
                                Tahun Ajaran
                            </a>



                            @endif

                            @if (auth()->user()->role === 'admin')
                            <a href="{{ route('tahunAjaran.index') }}" class="nav-link {{ request()->routeIs('tahunAjaran.index') ? 'active' : '' }} ">
                                <div class="sb-nav-link-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                                Tahun Ajaran
                            </a>

                            @endif

                            {{-- <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a> --}}
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        {{ auth()->user()->name}}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; FinTek 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @yield('script')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        {{-- <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    </body>
</html>
