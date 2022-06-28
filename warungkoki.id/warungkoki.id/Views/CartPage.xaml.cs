using Rg.Plugins.Popup.Extensions;
using System.Collections.ObjectModel;
using System.ComponentModel;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;

namespace warungkoki.id.Views
{
    public partial class CartPage : ContentPage
    {
        ObservableCollection<Product> data = new ObservableCollection<Product>();
        public CartPage()
        {
            InitializeComponent();
            

            data.Add(new Product { prod_name = "Topikoki Beras Harum 5 Kg",harga_act= 64000, alamat = "Lokasi : Warung Koki Shell Pelajar Pejuang - 1 (Bandung)", img= "ic_toko.png"});
            data.Add(new Product { prod_name = "a", harga_act = 123000, alamat = "123", img = "ic_toko.png" });

            listView.ItemsSource= data;
        }

        private async void Button_Clicked(object sender, System.EventArgs e)
        {
            await Navigation.PushPopupAsync(new MetodePopUpPage());
        }
    }
}