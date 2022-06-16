using Newtonsoft.Json;
using Plugin.GoogleClient;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Services;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class AddAlamatPage : ContentPage
    {
        string id;
        public AddAlamatPage()
        {
            InitializeComponent();
            get_provinces();
            
        }

        IOAuth2Service auth;
       
        private async void Save_Clicked(object sender, EventArgs e)
        {
             
        }

        private async void Back_Clicked(object sender, EventArgs e)
        {
            await Navigation.PopAsync();
        }

        private ObservableCollection<Provinsi> prov;
        public ObservableCollection<Provinsi> List_Provinsi
        {
            set
            {
                prov = value;
                OnPropertyChanged("List_Provinsi");
            }
            get
            {
                return prov;
            }
        }

        public async Task get_provinces()
        {
            try
            {
                
                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/provinces_get.php");
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Provinsi>>(response);
                    foreach (Provinsi item in json)
                    {

                        List_Provinsi.Add(new Provinsi { id = item.id, name = item.name });
                    }
                    get_kota(Selected_Provinsi.id.ToString());
                }
                else
                {
                    await Application.Current.MainPage.DisplayAlert(null, "Email not found, please register", "ok");
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        private ObservableCollection<Kota> kot;
        public ObservableCollection<Kota> List_Kota
        {
            set
            {
                kot = value;
                OnPropertyChanged("List_Kota");
            }
            get
            {
                return kot;
            }
        }

        private Provinsi provinsii;
        public Provinsi Selected_Provinsi
        {
            get { return provinsii; }
            set
            {
                provinsii = value;
                OnPropertyChanged(nameof(Selected_Provinsi));
            }
        }

        private Kota kotaa;
        public Kota Selected_Kota
        {
            get { return kotaa; }
            set
            {
                kotaa = value;
                OnPropertyChanged(nameof(Selected_Kota));
            }
        }

        private Kecamatan keca;
        public Kecamatan Selected_Kecamatan
        {
            get { return keca; }
            set
            {
                keca = value;
                OnPropertyChanged(nameof(Selected_Kecamatan));
            }
        }

        public async Task get_kota(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/regencies_get.php" +"?id="  +id );
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Kota>>(response);
                    foreach (Kota item in json)
                    {

                        List_Kota.Add(new Kota { id = item.id, province_id = item.province_id, name = item.name, postal_code = item.postal_code});
                    }
                    get_kecamatan(Selected_Kota.id.ToString()); 
                }
                else
                {
                    await Application.Current.MainPage.DisplayAlert(null, "Email not found, please register", "ok");
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        private ObservableCollection<Kecamatan> kec;
        public ObservableCollection<Kecamatan> List_Kecamatan
        {
            set
            {
                kec = value;
                OnPropertyChanged("List_Kecamatan");
            }
            get
            {
                return kec;
            }
        }

        public async Task get_kecamatan(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/districts_get.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Kecamatan>>(response);
                    foreach (Kecamatan item in json)
                    {

                        List_Kecamatan.Add(new Kecamatan { id = item.id, regency_id= item.regency_id, name = item.name});
                    }
                    
                }
                else
                {
                    await Application.Current.MainPage.DisplayAlert(null, "Email not found, please register", "ok");
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        public async Task update_profile(string id, string name, string no_hp,string email, string ktp, string pin)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/profile_update.php" + "?id=" + id +
                    "&name=" + name +"&email="+ email + "&no_hp="+no_hp + "&ktp="+ ktp+ "&token=" +pin);
                var response = await myHttpClient.GetStringAsync(uri);
                if (!response.Contains("gagal"))
                {
                    await Application.Current.MainPage.DisplayAlert("Alert", "Update success", "ok");

                    Navigation.PopAsync();
                }
                else
                {
                    await Application.Current.MainPage.DisplayAlert(null, "Email not found, please register", "ok");
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