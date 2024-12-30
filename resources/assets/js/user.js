'use strict';

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(function () {
  var dtUsersTable = $('#userTable');

  if (typeof baseUrl === 'undefined') {
    var baseUrl = "{{ url('/') }}/";
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
      type: 'GET'
    },
    columns: [
      { data: 'fake_id', searchable: false, orderable: false },
      { data: 'username' },
      { data: 'email' },
      { data: 'alamat' },
      { data: 'no_telp' },
      { data: 'jabatan' }
    ],
    columnDefs: [
      {
        targets: [1, 2, 3, 4, 5],
        className: 'text-center'
      }
    ],
    order: [[1, 'asc']],
    dom: '<"row"<"col-md-6"l><"col-md-6"f>>' + 't' + '<"row"<"col-md-6"i><"col-md-6"p>>',
    lengthMenu: [10, 25, 50, 100],
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Cari User',
      info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
      paginate: {
        next: '<i class="ti ti-chevron-right ti-sm"></i>',
        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
      }
    }
  });
});
'use strict';

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(function () {
  var dtUsersTable = $('#userTable');

  if (typeof baseUrl === 'undefined') {
    var baseUrl = "{{ url('/') }}/";
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
      type: 'GET'
    },
    columns: [
      { data: 'fake_id', searchable: false, orderable: false },
      { data: 'username' },
      { data: 'email' },
      { data: 'alamat' },
      { data: 'no_telp' },
      { data: 'jabatan' }
    ],
    columnDefs: [
      {
        targets: [1, 2, 3, 4, 5],
        className: 'text-center'
      }
    ],
    order: [[1, 'asc']],
    dom: '<"row"<"col-md-6"l><"col-md-6"f>>' + 't' + '<"row"<"col-md-6"i><"col-md-6"p>>',
    lengthMenu: [10, 25, 50, 100],
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Cari User',
      info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
      paginate: {
        next: '<i class="ti ti-chevron-right ti-sm"></i>',
        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
      }
    }
  });
});
