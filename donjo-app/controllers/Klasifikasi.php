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
 * Hak Cipta 2016 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
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
 * @copyright Hak Cipta 2016 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Models\KlasifikasiSurat;
use Illuminate\Support\Facades\DB;

class Klasifikasi extends Admin_Controller
{
    public function index()
    {
        $data = [
            'modul_ini'     => 'sekretariat',
            'sub_modul_ini' => 'klasifikasi-surat',
        ];

        return view('admin.klasifikasi.index', $data);
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            $enable = $this->input->get('enable');

            return datatables()->of(KlasifikasiSurat::filter($enable))
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    $aksi = '';
                    if (can('u')) {
                        $aksi .= '<a href="' . route('klasifikasi.form', $row->id) . '" class="btn btn-warning btn-sm" title="Ubah" style="margin-right:4px;"><i class="fa fa-edit"></i></a>';
                        if ($row->enabled == '1') {
                            $aksi .= '<a href="' . route('klasifikasi/lock', $row->id) . '" class="btn bg-navy btn-sm" title="Non Aktifkan" style="margin-right:4px;"><i class="fa fa-unlock">&nbsp;</i></a>';
                        } else {
                            $aksi .= '<a href="' . route('klasifikasi/unlock', $row->id) . '" class="btn bg-navy btn-sm" title="Aktifkan" style="margin-right:4px;"><i class="fa fa-lock"></i></a>';
                        }

                        if (can('h')) {
                            $aksi .= '<a href="#" data-href="' . route('klasifikasi/delete', $row->id) . '" class="btn bg-maroon btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>';
                        }
                    }

                    return $aksi;
                })
                ->addColumn('checkbox', static function ($row) {
                    $checkbox = '';
                    if (can('u')) {
                        $checkbox .= '<input type="checkbox" name="id_cb[]" value="' . $row->id . '" />';
                    }

                    return $checkbox;
                })
                ->rawColumns(['aksi', 'checkbox'])
                ->make();
        }
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');

        if ($id) {
            $data['data']        = KlasifikasiSurat::where('id', (int) $id)->first();
            $data['form_action'] = route('klasifikasi.update', $id);
        } else {
            $data['data']        = null;
            $data['form_action'] = route('klasifikasi.insert', $id);
        }

        return view('admin.klasifikasi.form', $data);
    }

    public function insert(): void
    {
        $this->redirect_hak_akses('u');
        $data = static::validated($this->request);

        try {
            KlasifikasiSurat::create($data);
            session_success();
        } catch (Exception $e) {
            log_message('error', $e);
            redirect_with('error', $e->getMessage());
        }

        redirect_with('success', 'Klasifikasi surat berhasil ditambahkan');
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');
        $data = static::validated($this->request);

        try {
            KlasifikasiSurat::where('id', (int) $id)->update($data);
            session_success();
        } catch (Exception $e) {
            log_message('error', $e);
            redirect_with('error', $e->getMessage());
        }

        redirect_with('success', 'Klasifikasi surat berhasil diperbarui');
    }

    public function delete($id = '')
    {
        $this->redirect_hak_akses('h', 'klasifikasi');
        KlasifikasiSurat::where('id', (int) $id)->delete();
        redirect_with('success', 'Klasifikasi surat berhasil dihapus');
    }

    public function delete_all()
    {
        $this->redirect_hak_akses('h', 'klasifikasi');
        KlasifikasiSurat::whereIn('id', $this->request['id_cb'])->delete();

        redirect_with('success', 'Klasifikasi surat berhasil dihapus');
    }

    public function lock($id = '')
    {
        $this->redirect_hak_akses('u');
        KlasifikasiSurat::where('id', (int) $id)->update(['enabled' => 0]);
        redirect_with('success', 'Klasifikasi surat berhasil dinonaktifkan');
    }

    public function unlock($id = '')
    {
        $this->redirect_hak_akses('u');
        KlasifikasiSurat::where('id', (int) $id)->update(['enabled' => 1]);
        redirect_with('success', 'Klasifikasi surat berhasil diaktifkan');
    }

    public function ekspor()
    {
        download_send_headers('klasifikasi_surat_' . date('Y-m-d') . '.csv');
        echo tulis_csv('klasifikasi_surat');
    }

    public function impor()
    {
        $this->redirect_hak_akses('u');
        $data['form_action'] = route('klasifikasi.proses_impor');

        return view('admin.klasifikasi.import', $data);
    }

    public function proses_impor()
    {
        $this->redirect_hak_akses('u');

        $file = $_FILES['klasifikasi']['tmp_name'];
        ini_set('auto_detect_line_endings', '1');
        if (($handle = fopen($file, 'rb')) == false) {
            session_error('Berkas tidak ada atau bermasalah');
            redirect('klasifikasi');
        }

        DB::beginTransaction();
        KlasifikasiSurat::truncate();

        $header    = fgetcsv($handle);
        $jml_kolom = count($header);

        while (($csv = fgetcsv($handle)) !== false) {
            $data = [];

            for ($c = 0; $c < $jml_kolom; $c++) {
                $data[$header[$c]] = $csv[$c];
                $data['config_id'] = identitas('id');
            }

            KlasifikasiSurat::insert($data);
        }

        DB::commit();
        fclose($handle);
        session_success();

        redirect('klasifikasi');
    }

    protected static function validated($data)
    {
        return [
            'kode'   => alfanumerik_titik($data['kode']),
            'nama'   => alfa_spasi($data['nama']),
            'uraian' => strip_tags($data['uraian']),
        ];
    }
}
