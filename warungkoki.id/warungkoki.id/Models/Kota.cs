using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Kota
    {
        public int id { get; set; }
        public int province_id { get; set; }
        public string name { get; set; }
        public int postal_code{ get; set; }
    }
}