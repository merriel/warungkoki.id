using Newtonsoft.Json;
using Rg.Plugins.Popup.Extensions;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Net.Http;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;

namespace warungkoki.id.Views
{
    public partial class CartPage : ContentPage
    {
        ObservableCollection<Cart> data = new ObservableCollection<Cart>();
        string id;
        public CartPage()
        {
            InitializeComponent();
            if (Application.Current.Properties["ID"] != null)
            {
                id = Application.Current.Properties["ID"].ToString();
                get_cart(id);

            }

        }

        private async void Button_Clicked(object sender, System.EventArgs e)
        {
            await Navigation.PushPopupAsync(new MetodePopUpPage());
        }

        public async Task get_cart(string userid)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/keranjang.php" + "?user_id=" + userid);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Cart>>(response);
                    foreach (Cart item in json)
                    {

                        data.Add(new Cart
                        {
                            id = item.id,
                            name = item.name,
                            harga_act = item.harga_act,
                            qty = item.qty,
                            img_name = "http://elcapersada.com/warungkoki/android/img_post/" + item.img_name,
                            wilayah_name = item.wilayah_name,
                            prod_name = item.prod_name,
                            img = "http://elcapersada.com/warungkoki/android/img_post/" + item.img,
                            jenis = item.jenis,
                            retailer_name = item.retailer_name,
                            weight = item.weight,
                            min_qty = item.min_qty,
                            max_qty = item.max_qty
                        }
                        );
                    }

                    listView.ItemsSource = data;
                }
                else
                {
                    System.Diagnostics.Debug.WriteLine("Cart empty");
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

    }
}