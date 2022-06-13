using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Alamat
    {
        public int id { get; set; }
        
        public string user_id { get; set; }
        public string district_id { get; set; }
        public string judul { get; set; }
        public string alamat { get; set; }
        public string penerima { get; set; }
        public string no_hp{ get; set; }
        public bool utama{ get; set; }
        public string longitude{ get; set; }
        public string latitude{ get; set; }
        public string postal_code{ get; set; }
    }
}