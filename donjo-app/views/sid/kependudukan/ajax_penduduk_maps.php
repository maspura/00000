<?php if ($this->CI->cek_hak_akses('u')): ?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Lokasi Tempat Tinggal <?= $penduduk['nama']?></h1>
			<ol class="breadcrumb">
				<li><a href="<?= site_url('beranda') ?>"><i class="fa fa-home"></i> Beranda</a></li>
				<?php if ($edit == '2') : ?>
					<li><a href="<?= site_url('penduduk') ?>"> Daftar Penduduk</a></li>
				<?php else : ?>
					<li><a href="<?= site_url("penduduk/form/{$p}/{$o}/{$id}/1") ?>"> Biodata Penduduk</a></li>
					<li><a href=#> Lokasi Tempat Tinggal</a></li>
				<?php endif; ?>
			</ol>
		</section>
		<section class="content">
		<div class="box box-info">
			<form id="validasi" action="<?= $form_action ?>" method="POST" class="form-horizontal">
				<div class="box-body">
					<div id="tampil-map">
				</div>
				<div class="box-footer">
					<div class="form-group">
						<label class="col-sm-3 control-label" for="lat">Latitude</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm lng" <?= ($edit == 0) ? 'readonly="readonly"' : 'name="lat" id="lat"' ?> value="<?= $penduduk['lat']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="lng">Longitude</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm lng" <?= ($edit == 0) ? 'readonly="readonly"' : 'name="lng" id="lng"' ?>  value="<?= $penduduk['lng']; ?>"/>
						</div>
					</div>

					<?php if ($edit == '0'): ?>
						<a href="<?= site_url('penduduk')?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
						<a href="<?= site_url("penduduk/ajax_penduduk_maps/{$p}/{$o}/{$id}/2") ?>" class="btn btn-social btn-flat btn-warning btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Ubah"><i class="fa fa-edit"></i> Ubah</a>
					<?php elseif ($edit == '1'): ?>
						<a href="<?= site_url("penduduk/form/{$p}/{$o}/{$id}/1") ?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
						<a href="#" class="btn btn-social btn-flat btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" download="OpenSID.gpx" id="exportGPX"><i class='fa fa-download'></i> Export ke GPX</a>
						<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' id="resetme"><i class='fa fa-times'></i> Reset</button>
						<?php if ($penduduk['status_dasar'] == 1 || ! isset($penduduk['status_dasar'])): ?>
							<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
						<?php endif; ?>
					<?php elseif ($edit == '2'): ?>
						<a href="<?= site_url('penduduk')?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
						<a href="#" class="btn btn-social btn-flat btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" download="OpenSID.gpx" id="exportGPX"><i class='fa fa-download'></i> Export ke GPX</a>
						<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' id="resetme"><i class='fa fa-times'></i> Reset</button>
						<?php if ($penduduk['status_dasar'] == 1 || ! isset($penduduk['status_dasar'])): ?>
							<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</form>
		</div>
		</section>
	</div>
	<script>
		window.onload = function() {
			var mode = '<?= $edit ? true : false ?>';
			//Jika posisi kantor dusun belum ada, maka posisi peta akan menampilkan peta desa
			<?php if (! empty($penduduk['lat'])):	?>
				var posisi = [<?= $penduduk['lat'] . ',' . $penduduk['lng']; ?>];
				var zoom = <?= $desa['zoom'] ?: 10; ?>;
			<?php else: ?>
				var posisi = [<?= $desa['lat'] . ',' . $desa['lng']; ?>];
				var zoom = 10;
			<?php	endif; ?>

			//Inisialisasi tampilan peta
			var peta_penduduk = L.map('tampil-map', pengaturan_peta).setView(posisi, zoom);

			//1. Menampilkan overlayLayers Peta Semua Wilayah
			var marker_desa = [];
			var marker_dusun = [];
			var marker_rw = [];
			var marker_rt = [];
			var marker_persil = []
			//WILAYAH DESA
			<?php if (! empty($desa['path'])): ?>
			set_marker_desa(marker_desa, <?=json_encode($desa)?>, "<?=ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa']?>", "<?= favico_desa()?>");
			<?php endif; ?>

			//WILAYAH DUSUN
			<?php if (! empty($dusun_gis)): ?>
				set_marker_multi(marker_dusun, '<?=addslashes(json_encode($dusun_gis))?>', '#FFFF00', '<?=ucwords($this->setting->sebutan_dusun)?>', 'dusun');
			<?php endif; ?>

			//WILAYAH RW
			<?php if (! empty($rw_gis)): ?>
				set_marker(marker_rw, '<?=addslashes(json_encode($rw_gis))?>', '#8888dd', 'RW', 'rw');
			<?php endif; ?>

			//WILAYAH RT
			<?php if (! empty($rt_gis)): ?>
				set_marker(marker_rt, '<?=addslashes(json_encode($rt_gis))?>', '#008000', 'RT', 'rt');
			<?php endif; ?>

			//2. Menampilkan overlayLayers Peta Semua Wilayah
			<?php if (! empty($wil_atas['path'])): ?>
				var overlayLayers = overlayWil(marker_desa, marker_dusun, marker_rw, marker_rt, marker_persil, "<?=ucwords($this->setting->sebutan_desa)?>", "<?=ucwords($this->setting->sebutan_dusun)?>");
			<?php else: ?>
				var overlayLayers = {};
			<?php endif; ?>

			//Menampilkan BaseLayers Peta
			var baseLayers = getBaseLayers(peta_penduduk, MAPBOX_KEY, JENIS_PETA);

			//Menampilkan dan Menambahkan Peta wilayah + Geolocation GPS + Exim GPX/KML
			L.Control.FileLayerLoad.LABEL = '<img class="icon-map" src="<?= base_url()?>assets/images/folder.svg" alt="file icon"/>';
			showCurrentPoint(posisi, peta_penduduk, mode);

			//Menambahkan zoom scale ke peta
			L.control.scale().addTo(peta_penduduk);

			L.control.layers(baseLayers, overlayLayers, {position: 'topleft', collapsed: true}).addTo(peta_penduduk);

		}; //EOF window.onload
	</script>
	<script src="<?= base_url()?>assets/js/leaflet.filelayer.js"></script>
	<script src="<?= base_url()?>assets/js/togeojson.js"></script>
<?php endif; ?>