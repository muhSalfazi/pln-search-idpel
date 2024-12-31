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
    ajax: baseUrl + 'users/data', // Memanggil route users/data
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
            return data || '<span class="text-muted">-</span>';  // Placeholder jika kosong
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
});
