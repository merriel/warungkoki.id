using System;

namespace warungkoki.id.Models
{
    public class Product
    {
        public string id { get; set; }
        public string user_id { get; set; }
        public string kategori_id { get; set; }
        public string product_id { get; set; }
        public string code_id { get; set; }
        public string img { get; set; }
        public string type { get; set; }
        public string jenis { get; set; }
        public string banyaknya { get; set; }
        public string desc { get; set; }
        public string min_qty { get; set; }
        public string judul_promo { get; set; }
        public double harga_act { get; set; }
        public string harga_crt { get; set; }
        public string active { get; set; }
        public string prod_name{ get; set; }
        public string wilayah_name { get; set; }
        public string regency_name{ get; set; }
        public string prod_img { get; set; }
        public string uuid { get; set; }
    }
}