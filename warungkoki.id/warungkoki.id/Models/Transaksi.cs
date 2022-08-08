using System;

namespace warungkoki.id.Models
{
    public class Transaksi
    {
        public string id { get; set; }
        public string uuid { get; set; }
        public string delivery_code { get; set; }
        public string user_id { get; set; }
        public string petugas_id { get; set; }
        public string wilayah_id { get; set; }
        public string retailer_id { get; set; }
        public string cash { get; set; }
        public string type { get; set; }
        public string status { get; set; }
        public string ket { get; set; }
        public string plan { get; set; }
        public string alamat_id { get; set; }
        public string ready { get; set; }
        public string pembelian_at{ get; set; }
        public string created_at { get; set; }
        public string updated_at { get; set; }
        public string type_bayar{ get; set; }
        public string undian_name { get; set; }

    }
}