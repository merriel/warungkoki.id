<hr>
<div style="font-size: 15px;padding-bottom: 10px;font-weight: bold">
  Rincian Pendaftaran Member Anda Bulan ini <b>({{ date('F Y',strtotime($blnawal)) }})</b>
</div>
<table id="customers">
  <thead>
    <tr>
      <th>Tanggal</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @php
      $Date1 = $blnawal;
      $Date2 = $blnakhir;
        
      $Variable1 = strtotime($Date1); 
      $Variable2 = strtotime($Date2); 

      $total = 0; 
      for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                      $currentDate += (86400)){ 
                                            
          $store = date('Y-m-d', $currentDate); 

          $tanggal = date('d F y', $currentDate); 

          $usermember = DB::table('user_members')
          ->join("transactions", "user_members.transaction_id", "=", "transactions.id")
          ->where('user_members.user_id', $userid)
          ->whereDate('transactions.updated_at','=', $store)
          ->count();

          $total += (int)$usermember;

    @endphp
    <tr>
      <td>{{ $tanggal }}</td>
      <td style="font-size:14px;" align="right"><b>{{ $usermember }}</b></td>
    </tr>
    @php
      }
    @endphp
    <tr>
      <th>TOTAL</th>
      <td style="font-size:14px;background-color: #feac3b;color: white;" align="right"><b>{{ number_format($total,0,',','.') }}</b></td>
    </tr>
  </tbody>
</table>