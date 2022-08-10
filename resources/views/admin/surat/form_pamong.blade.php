<div class="form-group">
    <label class="col-sm-3 control-label">Bertanda Tangan</label>
    <div class="col-sm-6 col-lg-4">
        <select class="form-control input-sm select2" id="atas_nama" name="pilih_atas_nama" onchange="ganti_ttd($(this).val());	">
            @foreach ($atas_nama as $key => $data)
                <option value="{{ $key }}">{{ $data }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{ SebutanDesa('Staf Pemerintah [Desa]') }}</label>
    <div class="col-sm-6 col-lg-4">
        <select class="form-control required input-sm" id="pamong" name="pamong_id">
            <option value='' selected="selected">-- {{ SebutanDesa('Pilih Staf Pemerintah [Desa]') }} --
            </option>
            @foreach ($pamong as $data)
                <option value="{{ $data->pamong_id }}" data-jabatan-id="{{ $data->jabatan_id }}" data-jabatan="{{ trim($data->jabatan->nama) }}"
                    data-nip="{{ $data->pamong_nip }}" data-niap="{{ $data->pamong_niap }}"
                    data-ttd="{{ $data->pamong_ttd }}" data-ub="{{ $data->pamong_ub }}">
                    {{ $data->pamong_nip ? 'NIP : ' . ($data->pamong_nip ?? '-') . ' | ' : setting('sebutan_nip_desa') . ' : ' . ($data->pamong_niap ?? '-') . ' | ' }}
                    {{ $data->pamong_nama . ' | ' . $data->jabatan->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#atas_nama').change();
        });

        function ganti_ttd(atas_nama) {
            if (atas_nama.includes('a.n')) {
                ub = $("#pamong option[data-ttd='1']").val();

                if (ub) {
                    $('#pamong').val(ub);
                } else {
                    $('#pamong').val('');
                }
                $('#pamong').attr('disabled', true);
            } else if (atas_nama.includes('u.b')) {
                $('#pamong').val('');
                $("#pamong option[data-jabatan-id='1']").hide();
                $("#pamong option[data-ttd='1']").hide();
                $('#pamong').attr('disabled', false);
            } else {
                $('#pamong').val($("#pamong option[data-jabatan-id='1']").val());
                $('#pamong').attr('disabled', true);
            }

            $('#pamong').change();
        }
    </script>
@endpush
