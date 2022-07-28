using CarouselView.FormsPlugin.Abstractions;
using FFImageLoading.Forms;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows.Input;
using warungkoki.id.Models;
using warungkoki.id.Views;
using Xamarin.Essentials;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class HomeViewModel : BaseViewModel, INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        ObservableCollection<Banner> ListBanner = new ObservableCollection<Banner>();
        public HomeViewModel(INavigation navigation)
        {
            this.Navigation = navigation;
            GetBannersAsync();

            // Select toko belum bener, get product by id toko
            GetProductsAsync("31");
            ItemTappedCommand = new Command(async () => await OnTapClicked());

            PositionSelectedCommand = new Command<PositionSelectedEventArgs>((e) =>
            {
               // Debug.WriteLine("Position " + e.NewValue + " selected.");
               // Debug.Write(this.SelectedItem);
            });

            ScrolledCommand = new Command<CarouselView.FormsPlugin.Abstractions.ScrolledEventArgs>((e) =>
            {
              //  Debug.WriteLine("Scrolled to " + e.NewValue + " percent.");
              //  Debug.WriteLine("Direction = " + e.Direction);
            });
        }

        private async Task OnTapClicked()
        {
            await Navigation.PushAsync(new ProductPage(SelectedItem));
        }

        public Command ItemTappedCommand { get; }

        ObservableCollection<Banner> banners_source;
        public ObservableCollection<Banner> BannersSource
        {
            set
            {
                banners_source = value;
                OnPropertyChanged("BannersSource");
            }
            get
            {
                return banners_source;
            }
        }

        ObservableCollection<Item> _myListSource;
        public ObservableCollection<Item> MyListSource
        {
            set
            {
                _myListSource = value;
                OnPropertyChanged("MyListSource");
            }
            get
            {
                return _myListSource;
            }
        }

        private ObservableCollection<Product> listproduct;
        public ObservableCollection<Product> ListProduct
        {
            set
            {
                listproduct = value;
                OnPropertyChanged("ListProduct");
            }
            get
            {
                return listproduct;
            }
        }

        private int last_saldo;
        public int saldo_last
        {
            set
            {
                last_saldo = value;
                OnPropertyChanged("saldo_last");
            }
            get
            {
                return last_saldo;
            }
        }

        Product _selectedItem;
        public Product SelectedItem
        {
            set
            {
                _selectedItem = value;
                OnPropertyChanged("SelectedItem");
            }
            get
            {
                return _selectedItem;
            }
        }

        public Command<PositionSelectedEventArgs> PositionSelectedCommand { protected set; get; }

        public Command<CarouselView.FormsPlugin.Abstractions.ScrolledEventArgs> ScrolledCommand { protected set; get; }

        protected virtual void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }

        public async Task GetBannersAsync()
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_banners.php");
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Banner>>(result);
                    BannersSource = new ObservableCollection<Banner>();
           
                    foreach (Banner item in json)
                    {
                        BannersSource.Add(new Banner { id = item.id, photo = "http://elcapersada.com/warungkoki/android/banners/" + item.photo, judul = item.judul});
                    }
                    myHttpClient.Dispose();
                }
                else
                {
                    //await Application.Current.MainPage.DisplayAlert(null, "Data not found", "ok");
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
        public async Task GetProductsAsync(string wilayah_id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                //Get Product by wilayah sementara nembak ID langsung, krn select toko belum bener
                //Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_listproduct.php?wilayah_id=" + wilayah_id);
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_listproduct.php?wilayah_id=31");
               
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Product>>(result);
                    System.Diagnostics.Debug.WriteLine("HASIL:");
                    System.Diagnostics.Debug.WriteLine(result);
                    ListProduct = new ObservableCollection<Product>();

                    foreach (Product item in json)
                    {
                        ListProduct.Add(new Product { id = item.id, user_id = item.user_id, wil_id = item.wil_id,
                            kategori_id= item.kategori_id, product_id = item.product_id, code_id = item.code_id,
                            img = "http://elcapersada.com/warungkoki/android/img_post/" +item.img, deliver = item.deliver,
                            po = item.po , type= item.type, jenis = item.jenis, name = item.name, dari = item.dari, 
                            sampai = item.sampai, dari_reward = item.dari_reward, sampai_reward = item.sampai_reward,
                            banyaknya = item.banyaknya, desc = item.desc, min_qty = item.min_qty, max_qty = item.max_qty,
                            judul_promo = item.judul_promo, harga_act = item.harga_act, harga_crt= item.harga_crt, active = item.active, 
                            length = item.length,width = item.width, height= item.height, weight = item.weight,
                            stock = item.stock, wilayah_name = "Barang ini tersedia dan bisa anda dapatkan di "+ item.wilayah_name, regency_name = item.regency_name,
                            prod_img = "http://elcapersada.com/warungkoki/android/img_post/" + item.prod_img, uuid = item.uuid, alamat = item.alamat});
                    }
                    myHttpClient.Dispose();
                }
                else
                {
                    //await Application.Current.MainPage.DisplayAlert(null, "Data not found", "ok");
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

        public async void get_saldo(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/saldohistorytotal.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]" || !response.Equals("NULL"))
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Saldo>>(response);
                    foreach (Saldo item in json)
                    {
                        saldo_last = int.Parse( item.sisa);

                    }
                }
                else
                {
                    saldo_last = 0;
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        public INavigation Navigation { get; set; }
    }
}