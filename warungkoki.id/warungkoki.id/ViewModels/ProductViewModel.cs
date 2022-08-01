using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows.Input;
using warungkoki.id.Models;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class ProductViewModel : BaseViewModel
    {
        Product product;
        string toko_name;
        string id_user;
        public ProductViewModel(Product prod)
        {
            this.product = prod;
            toko_name = product.wilayah_name.Substring(46);
            if (Application.Current.Properties["ID"] != null)
            {
                id_user = Application.Current.Properties["ID"].ToString();
               

            }
            check_love(product.id, id_user);
            favorit_command = new Command(method1);
            _ic_source = "fav_ic.png";
        }
        public async void method1()
        {
            Xamarin.Forms.FileImageSource objFileImageSource = (Xamarin.Forms.FileImageSource)ic_source;

            if (objFileImageSource == "redheart.png")
            {
                await love_hapus(product.id, id_user); 
            } else
            {
                await love_clicked(product.id, id_user);
            }
          

        }
        string _selectedImage;
        public string SelectedImage
        {
            set
            {
                _selectedImage= product.img;
                OnPropertyChanged("SelectedItem");
            }
            get
            {
                return product.img;
            }
        }

        private ImageSource _ic_source;
        public ImageSource ic_source
        {
            set
            {
                _ic_source  = value;
                OnPropertyChanged("ic_source");
            }
            get
            {
                return _ic_source;
            }
        }

        string _name;
        public string Name
        {
            set
            {
                _name = product.prod_name;
                OnPropertyChanged("Name");
            }
            get
            {
                return product.prod_name;
            }
        }

        string toko;
        public string Toko
        {
            set
            {
                toko = toko_name;
                OnPropertyChanged("Toko");
            }
            get
            {
                return toko_name;
            }
        }

        string alamat;
        public string Alamat
        {
            set
            {
                alamat = product.alamat;
                OnPropertyChanged("Alamat");
            }
            get
            {
                return product.alamat;
            }
        }

        double harga;
        public double Harga
        {
            set
            {
                harga = product.harga_act;
                OnPropertyChanged("Harga");
            }
            get
            {
                return product.harga_act;
            }
        }
        public ICommand favorit_command { private set; get; }

        public async Task check_love(string post_id, string user_id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/favorite.php?" + "user_id=" + user_id);

                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Product>>(response);
                    foreach (Product item in json)
                    {

                        if (item.id.ToString() == post_id)
                        {
                            ic_source = "redheart.png";
                        }

                    }
                }
                else
                {

                    System.Diagnostics.Debug.WriteLine("KOSONG;");
                    System.Diagnostics.Debug.WriteLine(response);
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        public async Task love_clicked(string post_id, string user_id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/favorite_masuk.php?" + "user_id="+user_id + "&post_id=" + post_id );

                var response = await myHttpClient.GetStringAsync(uri);

                if (response.Contains("sukses") )
                {
                    await Application.Current.MainPage.DisplayAlert("Berhasil", "Produk masuk ke dalam List Favorit", "ok");
                    ic_source = "redheart.png";
                }
                else
                {
                    
                    System.Diagnostics.Debug.WriteLine("KOSONG;");
                    System.Diagnostics.Debug.WriteLine(response);
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        public async Task love_hapus(string post_id, string user_id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/favorite_keluar.php?" + "user_id=" + user_id + "&post_id=" + post_id);

                var response = await myHttpClient.GetStringAsync(uri);

                if (response.Contains("sukses"))
                {
                    await Application.Current.MainPage.DisplayAlert("Berhasil", "Produk dikeluarkan dari List Favorit", "ok");
                    ic_source = "fav_ic.png";
                }
                else
                {

                    System.Diagnostics.Debug.WriteLine("KOSONG;");
                    System.Diagnostics.Debug.WriteLine(response);
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
