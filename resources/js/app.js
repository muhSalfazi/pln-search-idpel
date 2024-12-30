import './bootstrap';
/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);

// Hapus jika sebelumnya diimport di app.js
import Swal from 'sweetalert2';
window.Swal = Swal;
