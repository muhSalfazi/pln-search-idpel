'use strict';

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(function () {
  var dtUsersTable = $('#usersTable');

  if (typeof baseUrl === 'undefined') {
    console.error('baseUrl is not defined.');
    return;
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = dtUsersTable.DataTable({
    processing: true,
    serverSide: true,
    ajax: baseUrl + 'users/data',
    columns: [{
        data: 'DT_RowIndex',
        orderable: false,
        searchable: false
      },
      {
        data: 'username'
      },
      {
        data: 'email'
      },
      {
        data: 'no_telp',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      },
      {
        data: 'alamat',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      },
      {
        data: 'jabatan',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      },
      {
        data: 'role'
      },
      {
        data: 'status',
        orderable: false
      },
      {
        data: 'aksi',
        orderable: false
      }
    ],
    columnDefs: [{
      targets: '_all',
      className: 'text-center'
    }]
  });

  // Event untuk toggle status
  $(document).on('click', '.toggle-status', function () {
    let userId = $(this).data('id');
    let button = $(this);
    let newStatus = button.hasClass('btn-success') ? 'nonaktif' : 'aktif';

    $.ajax({
      url: baseUrl + 'users/status/' + userId,
      type: 'PATCH',
      data: {
        status: newStatus
      },
      success: function (response) {
        button.toggleClass('btn-success btn-danger');
        button.text(newStatus === 'aktif' ? 'Aktif' : 'Nonaktif');
        Swal.fire({
          icon: 'success',
          title: 'Status Diperbarui!',
          text: response.message,
          timer: 1500
        });
      }
    });
  });

  // Event untuk modal edit password
  $(document).on('click', '.edit-password', function () {
    let userId = $(this).data('id');
    $('#editPasswordModal input[name="user_id"]').val(userId);
    $('#editPasswordModal').modal('show');
  });

  // Submit form untuk update password
  $('#editPasswordModal form').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = form.serialize();

    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      success: function (response) {
        // Tutup modal terlebih dahulu
        $('#editPasswordModal').modal('hide');

        // Tunggu modal selesai tertutup, lalu tampilkan alert
        $('#editPasswordModal').on('hidden.bs.modal', function () {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: response.message,
            confirmButtonText: 'OK'
          });

          // Bersihkan event agar tidak dipicu berulang kali
          $(this).off('hidden.bs.modal');
        });

        // Reset form setelah berhasil
        form.trigger('reset');

        // Refresh DataTables
        table.ajax.reload();
      },
      error: function (xhr) {
        let errorMessage = 'Terjadi kesalahan.';

        // Cek apakah ada response dari server (Validasi Laravel)
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          let errors = xhr.responseJSON.errors;
          errorMessage = Object.values(errors).map(err => err.join('<br>')).join('<br>');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }

        // Tutup modal terlebih dahulu
        $('#editPasswordModal').modal('hide');

        // Tampilkan SweetAlert setelah modal tertutup
        $('#editPasswordModal').on('hidden.bs.modal', function () {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: errorMessage,
            confirmButtonText: 'OK'
          });

          // Bersihkan event agar tidak dipicu berulang kali
          $(this).off('hidden.bs.modal');
        });
      }
    });
  });
});
