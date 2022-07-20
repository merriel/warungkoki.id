using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Saldo
    {
        public int id { get; set; }
        
        public string user_id { get; set; }
        public int saldotrans_id { get; set; }
        public string before { get; set; }
        public string sisa { get; set; }
        public string status { get; set; }
        public string created_at{ get; set; }
        public string updated_at{ get; set; }
        public string amount{ get; set; }
        public string type{ get; set; }
    }
}