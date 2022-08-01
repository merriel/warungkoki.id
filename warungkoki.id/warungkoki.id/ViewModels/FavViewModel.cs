using CarouselView.FormsPlugin.Abstractions;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows.Input;
using warungkoki.id.Models;
using warungkoki.id.Views;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class FavViewModel : BaseViewModel, INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        string id_user;
        public FavViewModel(INavigation navigation)
        {
            this.Navigation = navigation;
            if (Application.Current.Properties["ID"] != null)
            {
                id_user = Application.Current.Properties["ID"].ToString();
                get_favorit(id_user);

            }
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


        public Command<PositionSelectedEventArgs> PositionSelectedCommand { protected set; get; }

        public Command<CarouselView.FormsPlugin.Abstractions.ScrolledEventArgs> ScrolledCommand { protected set; get; }

        public Command ItemTappedCommand { get; }

        private async Task OnTapClicked()
        {
            await Navigation.PushAsync(new ProductPage(SelectedItem));
        }

        public INavigation Navigation { get; set; }

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

        private bool _isVisibleList;

        public bool visi_list
        {
            get => _isVisibleList;
            set
            {
                _isVisibleList = value;
                OnPropertyChanged("visi_list");
            }
        }

        private bool _isVisibleLabel;

        public bool visi_empty
        {
            get => _isVisibleLabel;
            set
            {
                _isVisibleLabel = value;
                OnPropertyChanged("visi_empty");
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
        protected virtual void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }
        public async Task get_favorit(string user_id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/favorite.php?" + "user_id=" + user_id);

                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //listView.IsVisible = true;
                    visi_list = true;
                    //emptyFav.IsVisible = false;
                    visi_empty = false;
                    var json = JsonConvert.DeserializeObject<List<Product>>(response);
                    ListProduct = new ObservableCollection<Product>();

                    foreach (Product item in json)
                    {
                        ListProduct.Add(new Product
                        {
                            id = item.id,
                            user_id = item.user_id,
                            wil_id = item.wil_id,
                            kategori_id = item.kategori_id,
                            product_id = item.product_id,
                            code_id = item.code_id,
                            img = "http://elcapersada.com/warungkoki/android/img_post/" + item.img,
                            deliver = item.deliver,
                            po = item.po,
                            type = item.type,
                            jenis = item.jenis,
                            name = item.name,
                            dari = item.dari,
                            sampai = item.sampai,
                            dari_reward = item.dari_reward,
                            sampai_reward = item.sampai_reward,
                            banyaknya = item.banyaknya,
                            desc = item.desc,
                            min_qty = item.min_qty,
                            max_qty = item.max_qty,
                            judul_promo = item.judul_promo,
                            harga_act = item.harga_act,
                            harga_crt = item.harga_crt,
                            active = item.active,
                            length = item.length,
                            width = item.width,
                            height = item.height,
                            weight = item.weight,
                            stock = item.stock,
                            wilayah_name = "Barang ini tersedia dan bisa anda dapatkan di " + item.wilayah_name,
                            regency_name = item.regency_name,
                            prod_name = item.prod_name,
                            prod_img = "http://elcapersada.com/warungkoki/android/img_post/" + item.prod_img,
                            uuid = item.uuid,
                            alamat = item.alamat
                        });
                    }
                    myHttpClient.Dispose();
                }
                else
                {
                    //listView.IsVisible = false;
                    visi_list = false;
                    //emptyFav.IsVisible = true;
                    visi_empty = true;
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
