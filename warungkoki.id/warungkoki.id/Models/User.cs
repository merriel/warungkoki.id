using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class User : INotifyPropertyChanged
    {
        public string id { get; set; }
        public string google_id { get; set; }
        public string wilayah_id { get; set; }
        public string va { get; set; }
        public string ovo { get; set; }
        public string ktp { get; set; }
        public string name { get; set; }
        public string jenkel { get; set; }
       /// public System.DateTime tanggal_lahir { get; set; }
        public string no_hp{ get; set; }
        public string alamat { get; set; }
        private string mail;
        public string email { get => mail; set
            {
                mail = value;
                onPropertyChanged();
            }
        }
        public string password { get; set; }

        public event PropertyChangedEventHandler PropertyChanged;
        void onPropertyChanged([CallerMemberName] string propertyName = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }
    }
   
}