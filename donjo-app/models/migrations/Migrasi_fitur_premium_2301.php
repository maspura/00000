<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2022 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2022 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

use App\Models\Area;
use App\Models\Garis;
use App\Models\Lokasi;

defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_fitur_premium_2301 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Jalankan migrasi sebelumnya
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2212');
        $hasil = $hasil && $this->migrasi_2022120651($hasil);
        $hasil = $hasil && $this->migrasi_2022121251($hasil);
        $hasil = $hasil && $this->migrasi_2022122151($hasil);
        $hasil = $hasil && $this->migrasi_2022122152($hasil);
        $hasil = $hasil && $this->migrasi_2022122153($hasil);
        $hasil = $hasil && $this->migrasi_2022122154($hasil);

        return $hasil && true;
    }

    protected function migrasi_2022120651($hasil)
    {
        // Ubah Perdes menjadi Peraturan
        $this->db
            ->where([
                'id'   => 3,
                'nama' => 'Perdes',
            ])
            ->set('nama', 'Peraturan')
            ->update('ref_dokumen');

        return $hasil;
    }

    protected function migrasi_2022121251($hasil)
    {
        // Ubah panjang kolom judul 100 menjadi 200
        $fields = [
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
        ];

        return $hasil && $this->dbforge->modify_column('artikel', $fields);
    }

    protected function migrasi_2022122151($hasil)
    {
        $semua_foto = Area::pluck('foto')->toArray();

        foreach (get_filenames(LOKASI_FOTO_AREA, false, false) as $file) {
            if (in_array(str_replace(['kecil_', 'sedang_'], '', $file), $semua_foto)) {
                continue;
            }

            $hasil = $hasil && unlink(LOKASI_FOTO_AREA . $file);
        }

        return $hasil;
    }

    protected function migrasi_2022122152($hasil)
    {
        $semua_foto = Garis::pluck('foto')->toArray();

        foreach (get_filenames(LOKASI_FOTO_GARIS, false, false) as $file) {
            if (in_array(str_replace(['kecil_', 'sedang_'], '', $file), $semua_foto)) {
                continue;
            }

            $hasil = $hasil && unlink(LOKASI_FOTO_GARIS . $file);
        }

        return $hasil;
    }

    protected function migrasi_2022122153($hasil)
    {
        $hasil && $this->tambah_setting([
            'judul'      => 'Latar Login Mandiri',
            'key'        => 'latar_login_mandiri',
            'value'      => 'latar_login_mandiri.jpg',
            'keterangan' => 'Latar untuk Login Layanan Mandiri',
            'jenis'      => 'unggah',
            'kategori'   => 'latar',
        ]);

        return $hasil;
    }

    protected function migrasi_2022122154($hasil)
    {
        $semua_foto = Lokasi::pluck('foto')->toArray();

        foreach (get_filenames(LOKASI_FOTO_LOKASI, false, false) as $file) {
            if (in_array(str_replace(['kecil_', 'sedang_'], '', $file), $semua_foto)) {
                continue;
            }

            $hasil = $hasil && unlink(LOKASI_FOTO_LOKASI . $file);
        }

        return $hasil;
    }
}
