using System;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class TransaksiGrouping : INotifyPropertyChanged
    {
        public string names{ get; set; }
        
        public string created_at{ get; set; }
        public double amount { get; set; }
        public string jumlah_item { get; set; }
        public string status { get; set; }
        public string type_bayar { get; set; }
        public string wilayah_name { get; set; }
        public ObservableCollection<TransaksiDetail> data_detail { get; set; }

        public event PropertyChangedEventHandler PropertyChanged;
    }
}