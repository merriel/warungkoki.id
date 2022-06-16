using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Kecamatan
    {
        public int id { get; set; }
        
        public int regency_id { get; set; }

        public string name { get; set; }
    }
}