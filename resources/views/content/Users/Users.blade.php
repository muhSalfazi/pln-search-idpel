@extends('layouts/contentNavbarLayout')

@section('title', 'Users')


@section('page-style')
    <!-- Tambahkan Bootstrap dan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('vendor-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
@endsection

@section('page-script')
    <script>
        var baseUrl = "{{ url('/') }}/";
    </script>
    @vite('resources/assets/js/users.js')
@endsection

@section('content')
<style>
  .swal2-popup-custom {
      z-index: 2060 !important;
      /* Pastikan lebih tinggi dari modal Bootstrap */
  }
</style>
    <!-- Bordered Table -->
    <div class="card">
        <h5 class="card-header">Data Users</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <table id="usersTable" class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Edit Password -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('users.update-password') }}">
                    @csrf
                    <input type="hidden" name="user_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPasswordModalLabel">Edit Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" id="passwordField"
                                placeholder="min 8 karakter" required>
                            <span toggle="#passwordField"
                                class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor: pointer;">
                                <i class="ri-eye-off-line" id="togglePassword"></i>
                            </span>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="confirmPasswordField" required>
                            <span toggle="#confirmPasswordField"
                                class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor: pointer;">
                                <i class="ri-eye-off-line" id="toggleConfirmPassword"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password field
            const togglePassword = document.querySelector('#togglePassword');
            const passwordField = document.querySelector('#passwordField');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle the icon
                this.classList.toggle('ri-eye-line');
                this.classList.toggle('ri-eye-off-line');
            });

            // Toggle confirm password field
            const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
            const confirmPasswordField = document.querySelector('#confirmPasswordField');

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.setAttribute('type', type);

                this.classList.toggle('ri-eye-line');
                this.classList.toggle('ri-eye-off-line');
            });
        });
    </script>

@endsection
