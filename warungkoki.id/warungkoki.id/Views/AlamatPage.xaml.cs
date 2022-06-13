using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class AlamatPage : ContentPage
    {
        ObservableCollection<Alamat> data = new ObservableCollection<Alamat>();
        public AlamatPage()
        {
            InitializeComponent();
            data.Add(new Alamat { user_id = "Merriel Lushena",no_hp="081320092661",
                judul = "Dago 207", alamat = "Jl. Dago 207, Coblong, Dago, Bandung"});
            listView.ItemsSource = data;
        }

        private async void Add_Clicked(object sender, EventArgs e)
        {
           
        }
    }
}