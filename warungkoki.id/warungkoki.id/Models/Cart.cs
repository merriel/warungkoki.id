using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Cart
    {
        public int id { get; set; }
        public string name { get; set; }
        
        public int harga_act { get; set; }
        public int qty { get; set; }
        public string img_name { get; set; }
        public string wilayah_name { get; set; }
        public string prod_name { get; set; }
        public string img{ get; set; }
        public string jenis { get; set; }
        public string retailer_name { get; set; }
        public string weight { get; set; }
        public string min_qty { get; set; }
        public string max_qty { get; set; }
    }
}