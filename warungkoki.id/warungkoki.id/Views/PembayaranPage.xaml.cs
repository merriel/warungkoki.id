using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class PembayaranPage : ContentPage
    {
        ObservableCollection<Alamat> data = new ObservableCollection<Alamat>();
        string id;
        public PembayaranPage()
        {
            InitializeComponent();
            if (Application.Current.Properties["ID"] != null)
            {
                id = Application.Current.Properties["ID"].ToString();
                nama_user = Application.Current.Properties["Username"].ToString();
            }
           
        }

        private async void Add_Clicked(object sender, EventArgs e)
        {
            Navigation.PushAsync(new AddAlamatPage());
        }

        private string user;
        public string nama_user
        {
            set
            {
                user = value;
                OnPropertyChanged("SelectedItem");
            }
            get
            {
                return user;
            }
        }

    }
}