'use strict';

document.addEventListener('DOMContentLoaded', function () {
  // ==============================
  // Ambil data kecamatan saat halaman dimuat
  // ==============================
  fetch('/get-kecamatan-karawang')
    .then(response => response.json())
    .then(data => {
      let kecamatanDropdown = document.getElementById('kecamatan');
      // kecamatanDropdown.innerHTML = '<option value="">Pilih Kecamatan</option>';

      // Isi Dropdown Kecamatan
      data.forEach(item => {
        kecamatanDropdown.innerHTML += `<option value="${item.nama}" data-id="${item.id}">${item.nama}</option>`;
      });

      // Pilih kecamatan dari database (jika ada)
      let selectedKecamatan = "{{ Auth::user()->kecamatan ?? '' }}";
      if (selectedKecamatan) {
        // Loop opsi dan pilih yang sesuai dengan data kecamatan
        Array.from(kecamatanDropdown.options).forEach(option => {
          if (option.value === selectedKecamatan) {
            option.selected = true;
            kecamatanDropdown.dispatchEvent(new Event('change'));
          }
        });
      }
    })
    .catch(error => {
      console.error('Gagal memuat kecamatan:', error);
    });

  // ==============================
  // Fetch kelurahan (desa) saat kecamatan dipilih
  // ==============================
  const kecamatanDropdown = document.getElementById('kecamatan');
  const kelurahanDropdown = document.getElementById('desa'); // Kelurahan (desa)

  kecamatanDropdown.addEventListener('change', function () {
    let kecamatanName = this.value;

    if (!kecamatanName) {
      kelurahanDropdown.innerHTML = '<option value="">Pilih Kelurahan</option>';
      return;
    }

    // Ambil ID kecamatan yang sesuai
    let kecamatanId = this.options[this.selectedIndex].getAttribute('data-id');

    fetch(`/get-desa?kecamatan_id=${kecamatanId}`)
      .then(response => response.json())
      .then(data => {
        kelurahanDropdown.innerHTML = '<option value="">Pilih Kelurahan</option>';
        data.forEach(item => {
          kelurahanDropdown.innerHTML += `<option value="${item.nama}" data-id="${item.id}">${item.nama}</option>`;
        });

        // Pilih kelurahan dari database (jika ada)
        let selectedKelurahan = "{{ Auth::user()->desa ?? '' }}";
        if (selectedKelurahan) {
          Array.from(kelurahanDropdown.options).forEach(option => {
            if (option.value === selectedKelurahan) {
              option.selected = true;
            }
          });
        }
      })
      .catch(error => {
        console.error('Gagal memuat kelurahan:', error);
      });
  });

  // ==============================
  // Upload dan Reset Avatar
  // ==============================
  const accountUserImage = document.getElementById('uploadedAvatar');
  const fileInput = document.querySelector('.account-file-input');
  const resetFileInput = document.querySelector('.account-image-reset');

  if (accountUserImage) {
    const defaultAvatar = accountUserImage.src;

    // Upload Gambar Baru
    fileInput.onchange = () => {
      if (fileInput.files[0]) {
        accountUserImage.src = URL.createObjectURL(fileInput.files[0]);
      }
    };

    // Reset ke Avatar Default
    resetFileInput.onclick = () => {
      fileInput.value = '';
      accountUserImage.src = defaultAvatar;
    };
  }
  // ======================================
  // SweetAlert untuk Hapus Akun
  // ======================================

});
