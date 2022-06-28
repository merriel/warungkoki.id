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
    public partial class FavPage : ContentPage
    {
        ObservableCollection<Alamat> data = new ObservableCollection<Alamat>();
        string id;
        public FavPage()
        {
            InitializeComponent();
            if (Application.Current.Properties["ID"] != null)
            {
                id = Application.Current.Properties["ID"].ToString();
                nama_user = Application.Current.Properties["Username"].ToString();
                get_alamat(id);
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

        public async Task get_alamat(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/alamatuser.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);
                System.Diagnostics.Debug.WriteLine(response);
                if ( !response.Contains("NULL"))
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Alamat>>(response);
                    foreach (Alamat item in json)
                    {
                        data.Add(new Alamat
                        {
                            user_id = id,
                            nohp = item.nohp,
                            judul = item.judul,
                            alamat = item.alamat
                        });

                    }
                    listView.ItemsSource = data;
                }
                else {
                    listView.IsVisible = false;
                    emptyFav.IsVisible = true;
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