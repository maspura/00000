<script>
var tableDT;

$(function() {
	//$("#validasi").hide();
	
	tableDT = $('#tblRekap').DataTable(
	{
		"language": {
            url: '/assets/bootstrap/js/dataTables.indonesian.lang'
        },
		"dom": '<"top"fl>t<"bottom"ip>',
		/*
		"columnDefs": [
			{
				"render": function ( data, type, row ) {
	 
					button='<a href="<?= site_url("set_hari/edit_tgl")?>?tgl='+row[2]+'"'
						+' title="Ubah Data" data-remote="false" data-toggle="modal" '
						+'data-target="#modalBox" data-title="Info" class="btn bg-orange '
						+'btn-flat btn-sm"><i class="fa fa-edit"></i></a>';
 
					return  button;

				},
				"targets": 5
			} 
		],
		*/
		"columns":[
		{orderable:false, searchable:false,defaultContent:"-"},
		{orderable:true, searchable:false,defaultContent:"-"},
		{orderable:false, searchable:false,defaultContent:"-"},
		{orderable:false, searchable:false,defaultContent:"-"},
		{orderable:false, searchable:false,defaultContent:"-"}
		],
		"order": [[ 1, "asc" ]],
		"lengthMenu": [[ 10, 25, 50, 60,5], [10, 25, 50, 60,5]],
		"processing": true,
        "serverSide": true,
        "ajax": {
			url:"<?=site_url('kehadiran_rekap/api');?>",
			type:"POST",
			data: function (d) {
				types 	 = $('#search_type').val();
				values 	 = $('#search_value').val();
				dateStart = $('#date_start').val();
				dateEnd = $('#date_end').val();
				d.type  	=types;
				d.values  	=values;
				d.dateStart =dateStart;
				d.dateEnd   =dateEnd;
				d.action ='datatables';

			}
		}
    }
	);

  
} );
</script>