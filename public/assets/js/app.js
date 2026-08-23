document.addEventListener('DOMContentLoaded', function () {

    // Toggle sidebar (mobile)
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('show'));
    }

    // Auto-dismiss alerts after 5s
    document.querySelectorAll('.alert').forEach(function (alertEl) {
        setTimeout(() => {
            const alert = bootstrap.Alert.getOrCreateInstance(alertEl);
            alert && alert.close();
        }, 5000);
    });

    // Inisialisasi semua tabel dengan class .table-datatable
    if (window.jQuery && jQuery.fn.DataTable) {
        jQuery('.table-datatable').DataTable({
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data',
            },
        });
    }

    // Konfirmasi hapus data via SweetAlert2 untuk semua form dengan class .form-delete
    document.querySelectorAll('.form-delete').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const itemName = form.dataset.itemName || 'data ini';

            if (window.Swal) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `${itemName} akan dihapus secara permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c0392b',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            } else if (confirm('Yakin ingin menghapus ' + itemName + '?')) {
                form.submit();
            }
        });
    });

    // Tampilkan pesan sukses SweetAlert (dipicu via data-swal-success di body)
    const flash = document.body.dataset.swalSuccess;
    if (flash && window.Swal) {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: flash, timer: 2500, showConfirmButton: false });
    }
});

/**
 * Helper: toggle field opsi jawaban pada form pertanyaan survei
 * dipakai di halaman survey_questions
 */
function toggleOpsiJawaban(selectEl, targetId) {
    const target = document.getElementById(targetId);
    if (!target) return;
    target.style.display = selectEl.value === 'pilihan_ganda' ? 'block' : 'none';
}
