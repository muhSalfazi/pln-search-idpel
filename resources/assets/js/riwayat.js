'use strict';

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(function () {
  var dtHistoryTable = $('#historyTable');

  console.log($.fn.dataTable);

  if (typeof baseUrl === 'undefined') {
    console.error('baseUrl is not defined. Please define it in the Blade template.');
    return;
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  if (dtHistoryTable.length) {
    var dtHistory = dtHistoryTable.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'riwayat/data',
        type: 'GET'
      },
      columns: [
        { data: 'fake_id', searchable: false, orderable: false },
        { data: 'no_pelanggan' },
        { data: 'tarif' },
        { data: 'daya' },
        { data: 'jenis_layanan' },
        { data: 'nomer_meter' },
        { data: 'status' }
      ],
      columnDefs: [
        {
          // Index Number
          targets: 0,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return meta.row + 1;
          }
        },
        {
          // Index Number
          targets: 1,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<span>${full.no_pelanggan}</span>`;
          }
        },
        {
          // Index Number
          targets: 2,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<span>${full.tarif}</span>`;
          }
        },
        {
          // Index Number
          targets: 3,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<span>${full.daya}</span>`;
          }
        },
        {
          // Index Number
          targets: 4,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<span>${full.jenis_layanan}</span>`;
          }
        },
        {
          // Index Number
          targets: 5,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<span>${full.nomer_meter}</span>`;
          }
        },
        {
          // Status Badge
          targets: 6,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return full.status === 'ada'
              ? '<span class="badge bg-label-success">Ada</span>'
              : '<span class="badge bg-label-warning">Tidak Ada</span>';
          }
        }
      ],
      order: [[1, 'asc']],
      dom: '<"row"<"col-md-6"l><"col-md-6"f>>' + 't' + '<"row"<"col-md-6"i><"col-md-6"p>>',
      lengthMenu: [10, 25, 50, 100],
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Cari Pelanggan',
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      }
    });
  }
});
