using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class TransaksiDetail : INotifyPropertyChanged
    {
        public string name{ get; set; }
        public string product_name{ get; set; }

        public string created_at{ get; set; }
        public string amount { get; set; }
        public string type_bayar { get; set; }
        public string wilayah_name { get; set; }

        public event PropertyChangedEventHandler PropertyChanged;
    }
}