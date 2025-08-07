<?php

if (!function_exists('status_prestasi')) {
    /**
     * Mengembalikan span badge Bootstrap 5 untuk status yang diberikan.
     *
     * @param string $status
     * @return string
     */
    function status_prestasi(string $status): string
    {
        $status = strtolower($status); // Pastikan status dalam huruf kecil untuk konsistensi

        $badgeClass = '';
        $displayText = '';

        switch ($status) {
            case 'menunggu':
                $badgeClass = 'bg-warning text-dark'; // Kuning untuk menunggu
                $displayText = 'Menunggu';
                break;
            case 'terverifikasi':
                $badgeClass = 'bg-success'; // Hijau untuk terverifikasi
                $displayText = 'Terverifikasi';
                break;
            case 'ditolak':
                $badgeClass = 'bg-danger'; // Merah untuk ditolak
                $displayText = 'Ditolak';
                break;
            default:
                $badgeClass = 'bg-secondary'; // Abu-abu untuk status tidak dikenal
                $displayText = ucfirst($status); // Tampilkan status aslinya dengan huruf kapital di awal
                break;
        }

        return '<span class="badge ' . $badgeClass . '">' . $displayText . '</span>';
    }
}
