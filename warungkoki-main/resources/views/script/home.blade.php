<script type="text/javascript">


function Kategory(id){

  $('.loading').attr('style','display: block');

  setTimeout(function(){ window.location.href = 'kategori?id='+id+''; }, 1500);

// $('.kategori').attr("class", "card shadow-sm kategori");


// $('#color_'+id).attr("class", "card bg-abu shadow-sm kategori");

// $.ajax({
//   type: 'POST',
//   url: "{{ route('company.kategori') }}",
//   data: {
//       '_token': $('input[name=_token]').val(),
//       'id': id,
//   },
//   success: function(data) {

//     var content_data="";
//     var no = -1;
//     var nos = 0;

//     if (data.length == '0'){

//       content_data += "<div class='col-12 loyaltycontent contents' style='display: block;'>";
//       content_data += "<div class='alert alert-putih shadow-ss' role='alert'>";
//       content_data += "<table width='100%'>";
//       content_data += "<tr>";
//       content_data += "<td align='center'>";
//       content_data += "<img src='/assets/content/img/theme/produkempty.jpg' width='90%'>";
//       content_data += "<br>";
//       content_data += "<div style='font-size: 14px;color: black;padding-bottom: 6px;'><b>Kosong!</b></div>";
//       content_data += "<h6>Tidak ada Produk Apapun disini cari di Tab lainnya!</h6>";
//       content_data += "</td>";
//       content_data += "</tr>";
//       content_data += "</table>";
//       content_data += "</div>";
//       content_data += "</div>";

//         $('#contentproduk').html(content_data);

//     } else {

//       var kategori = data[0]['kategori_name'];

//       content_data += "<div id='category' class='col-12' style='padding-top: 10px;'>";
//       content_data += "<table width='100%'>";
//       content_data += "<tr>";
//       content_data += "<td align='left' style='font-size: 15px;'><b>KATEGORI "+kategori.toUpperCase()+"</b></td>";
//       content_data += "</tr>";
//       content_data += "</table>";
//       content_data += "</div>";

//       $.each(data, function() {

//         no++;
//         nos++;
//         var id = data[no]['id'];
//         var type = data[no]['type'];
//         var imgname = data[no]['imgname']; 
//         var name = data[no]['name'];
//         var wilayah_id = data[no]['wilayah_id'];
//         var wilayah_name = data[no]['wilayah_name'];
//         var uuid = data[no]['uuid'];
//         var regency_name = data[no]['regency_name'];
//         var harga_act = data[no]['harga_act'];
//         var prodname = data[no]['prod_name']; 

//         var number_string = harga_act.toString(),
//           sisa  = number_string.length % 3,
//           rupiah  = number_string.substr(0, sisa),
//           ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
//         if (ribuan) {
//           separator = sisa ? '.' : '';
//           rupiah += separator + ribuan.join('.');
//         }

//         if(nos%2==0){
//           var padding = 'padding-left: 7.5px;';
//         } else {
//           var padding = 'padding-right: 7.5px;';
//         }

//         if(name == null){
//           var postt = '';
//         } else {
//           var postt = ' - '+name;
//         }

//         content_data += "<div class='col-6 loyaltycontent contents' style='display: block;"+padding+"'>";
//         content_data += "<a href='/users/detail/"+id+"'>";
//         content_data += "<div class='card shadow-sm'>";
//         content_data += "<div class='type'>";
//         content_data += "<span class='badge badge-pill badge-primary'>"+type+"</span>";
//         content_data += "</div>";
//         content_data += "<img class='card-img-top' width='50px' src='/assets/img_post/"+imgname+"' alt='Card image cap'>";

//         content_data += "<div class='love2'>";
//         content_data += "<div class='circle4'><i class='ni ni-favourite-28' style='color: #fff'></i></div>";
//         content_data += "</div>";
//         content_data += "<div class='card-body' style='padding-right: 1rem;padding-left: 1rem;'>";
//         content_data += "<h5> <b>"+prodname+""+postt+"</b></h5>";

//         content_data += "<a href='/company/profile?id="+uuid+"'><span class='badge badge-pill badge-success' style='font-size: 8px;'><i class='fa fa-map-marker'></i> "+wilayah_name+"</span></a><br><div style='font-size: 8px;padding-top: 12px;'>Barang ini tersedia di daerah <b>"+regency_name+"</b></div><hr>";
//         content_data += "<h3 style='color: #fb6340;'><b>Rp. "+rupiah+"</b></h3>";
//         content_data += "</div>";
//         content_data += "</div>";
//         content_data += "</a>";
//         content_data += "</div>";

//       });

//       $('#contentproduk').html(content_data);

//     }


//   }
// });

}

</script>