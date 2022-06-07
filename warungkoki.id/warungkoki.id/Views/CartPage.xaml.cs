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
            

            data.Add(new Product { prod_name = "a",harga_act= 123000, alamat = "123"});

            listView.ItemsSource= data;
        }
    }
}