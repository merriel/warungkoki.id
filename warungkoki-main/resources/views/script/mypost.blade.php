<script type="text/javascript">
var table
$(function() {
    table = $('.datatables').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        ajax: "{{ route('getpostdeals') }}",
        columns: [
            { data: 'name', name: 'name' },
            { 
                render: function ( data, type, row ) {
                    return '<button class="btn btn-sm btn-success viewpost" data-id="'+row.id+'" data-name="'+row.name+'" type="button">View</button> <button class="btn btn-sm btn-primary editpost" data-id="'+row.id+'" type="button">Edit</button>';
                }
            }
        ]
    });
});

var table2
$(function() {
    table2 = $('.datatables2').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        ajax: "{{ route('getpostchallanges') }}",
        columns: [
            { data: 'name', name: 'name' },
            { 
                render: function ( data, type, row ) {
                    return '<button class="btn btn-sm btn-success viewpost" data-id="'+row.id+'" data-name="'+row.name+'" type="button">View</button> <button class="btn btn-sm btn-primary editpost" data-id="'+row.id+'" type="button">Edit</button>';
                }
            }
        ]
    });
});
	
$('#dealsposts').on('click', function () {

	$("#dealspost").attr("style","display: block;");
	$("#challangepost").attr("style","display: none;");

	$("#challangeposts").attr("class","icon icon-shape bg-white rounded-circle shadow");
	$("#iconchallanges").attr("style","color: #0166b5");

	$("#dealsposts").attr("class","icon icon-shape bg-green rounded-circle shadow");
	$("#icondeals").attr("style","color: #ffffff");


});

$('#challangeposts').on('click', function () {

	$("#dealspost").attr("style","display: none;");
	$("#challangepost").attr("style","display: block;");

	$("#challangeposts").attr("class","icon icon-shape bg-green rounded-circle shadow");
	$("#iconchallanges").attr("style","color: #ffffff");

	$("#dealsposts").attr("class","icon icon-shape bg-white rounded-circle shadow");
	$("#icondeals").attr("style","color: #0166b5");

});

	

</script>