@extends('layouts/contentNavbarLayout')

@section('title', 'Pencarian')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('page-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('vendor-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection


@section('content')
    {{-- sweet alert --}}
    <script>
        if (typeof Swal === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"><\/script>');
        }
        // Trigger SweetAlert after loader is hidden
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{!! session('success') !!}',
                confirmButtonText: 'OK',
                showClass: {
                    popup: 'animate_animated animate_bounceInDown' // Menambahkan animasi muncul
                },
                hideClass: {
                    popup: 'animate_animated animate_fadeOutUp' // Menambahkan animasi saat ditutup
                },
                customClass: {
                    popup: 'small-swal-popup'
                },
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{!! session('error') !!}',
                confirmButtonText: 'OK',
                showClass: {
                    popup: 'animate_animated animate_fadeIn' // Animasi muncul
                },
                hideClass: {
                    popup: 'animate_animated animate_zoomOut' // Animasi saat ditutup
                },
                customClass: {
                    popup: 'small-swal-popup'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: 'Silakan isi form kembali.',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate_animated animate_fadeIn' // Animasi muncul
                        },
                        hideClass: {
                            popup: 'animate_animated animate_zoomOut' // Animasi saat ditutup
                        },
                        customClass: {
                            popup: 'small-swal-popup'
                        },
                    });
                }
            });
        @endif
    </script>
    {{-- end sweetalert --}}
    <div class="container">
        <section class="section register min-vh-80 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 d-flex flex-column ">
                        <div class="d-flex justify-content-center py-1">
                            <a href="#" class="logo d-flex align-items-center w-auto mb-3">
                                <img src="{{ asset('assets/img/logo-text.png') }}" alt=""
                                    style="width: 150px; height: auto;">
                            </a>
                        </div>
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="pt-3 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Data TO</h5>
                                    <p class="text-center small">Masukkan Idpel atau nomor meter</p>
                                </div>

                                <form class="row g-2 needs-validation" action="{{ url('/search') }}" method="POST"
                                    novalidate>
                                    @csrf
                                    <div class="col-12">
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="ri-clipboard-line"></i>
                                            </span>
                                            <input type="text" name="searchTerm"
                                                class="form-control @error('searchTerm') is-invalid @enderror"
                                                id="yourUsername" required placeholder="inputkan disini..">
                                            <div class="invalid-feedback">
                                                Masukkan IDPEL atau nomor meter.
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('searchTerm'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('searchTerm') }}
                                        </div>
                                    @endif

                                    <div class="col-12 mt-3">
                                        <button class="btn btn-primary w-100" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    </div>
@endsection
