'use strict';

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(function () {
  var dtUsersTable = $('#usersTable');

  if (typeof baseUrl === 'undefined') {
    console.error('baseUrl is not defined. Please define it in the Blade template.');
    return;
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  dtUsersTable.DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'users/data',
      type: 'GET',
      data: function (d) {
        d.role = 'user';  // Kirim filter role user
      },
      error: function (xhr) {
        console.log(xhr.responseText);  // Tampilkan error response di console
        alert('Error: ' + xhr.status + ' - ' + xhr.responseText);
      }
    },
    columns: [
      { data: 'DT_RowIndex', searchable: false, orderable: false },
      { data: 'username' },
      { data: 'email' },
      {
        data: 'alamat',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      },
      {
        data: 'no_telp',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      },
      {
        data: 'jabatan',
        render: function (data) {
          return data || '<span class="text-muted">-</span>';
        }
      }
    ],
    columnDefs: [
      { targets: '_all', className: 'text-center' }
    ],
    order: [[1, 'asc']]
  });
});
