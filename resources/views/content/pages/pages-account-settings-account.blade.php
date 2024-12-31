@extends('layouts/contentNavbarLayout')

@section('title', 'Account settings - Account')

@section('page-script')
    @vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        @if (session('alert'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: '{!! session('alert') !!}',
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
            })
        @endif
    </script>
    
    {{-- end sweetalert --}}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                                class="ri-group-line me-1_5"></i>Account</a></li>
                </ul>
            </div>

            <div class="card mb-6">
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" enctype="multipart/form-data"
                        action="{{ route('account-settings.update') }}">
                        @csrf

                        <div class="row g-5">
                            <!-- Avatar Section -->
                            <div class="col-md-12 d-flex align-items-start align-items-sm-center gap-6">
                                <img src="{{ asset(Auth::user()->avatar ?? 'assets/img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />

                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-sm btn-primary me-3 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="ri-upload-2-line d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" name="avatar"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <div>Allowed JPG, PNG. Max size of 800K</div>
                                </div>
                            </div>

                            <!-- Personal Information Section -->
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="firstName" name="firstName"
                                        value="{{ Auth::user()->first_name ?? 'John' }}" placeholder="First Name" autofocus
                                        required />
                                    <label for="firstName">First Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" name="lastName" id="lastName"
                                        value="{{ Auth::user()->last_name ?? 'Doe' }}" placeholder="Last Name" required />
                                    <label for="lastName">Last Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        value="{{ Auth::user()->jabatan ?? 'Developer' }}" placeholder="Jabatan" required />
                                    <label for="jabatan">Jabatan</label>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"> (+62)</span>

                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                            placeholder="08*****" value="{{ Auth::user()->no_telp }}" required />
                                        <label for="phoneNumber">Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ Auth::user()->alamat }}" placeholder="Address" required />
                                    <label for="address">Address</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="kecamatan" name="kecamatan" class="form-select" required>
                                        {{-- <option value="">Pilih Kecamatan</option> --}}
                                        <option value="{{ Auth::user()->kecamatan }}" selected>
                                            {{ Auth::user()->kecamatan ?? 'Pilih Kecamatan' }}
                                        </option>
                                    </select>
                                    <label for="kecamatan">Kecamatan</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="desa" name="desa" class="form-select" required>
                                        {{-- <option value="">Pilih Desa</option> --}}
                                        <option value="{{ Auth::user()->desa }}" selected>
                                            {{ Auth::user()->desa ?? 'Pilih Desa' }}
                                        </option>
                                    </select>
                                    <label for="desa">Desa</label>
                                </div>
                            </div>


                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                        </div>
                    </form>
                </div>

                <!-- /Account -->
            </div>
        </div>
    </div>
    <div class="card">
      <h5 class="card-header">Delete Account</h5>
      <div class="card-body">
        <form id="formAccountDeactivation" method="POST" action="{{ route('account-settings.delete-account') }}">
            @csrf
            <div class="form-check mb-6 ms-3">
                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
                <label class="form-check-label" for="accountActivation">
                    Saya mengonfirmasi penonaktifan akun saya
                </label>
            </div>
            <button type="submit" class="btn btn-danger deactivate-account" id="resetAccount" >
                Deactivate Account
            </button>
        </form>
    </div>
    
@endsection
