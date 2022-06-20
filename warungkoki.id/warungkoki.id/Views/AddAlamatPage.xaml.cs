using Newtonsoft.Json;
using Plugin.GoogleClient;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Services;
using Xamarin.Essentials;
using Xamarin.Forms;
using Xamarin.Forms.Maps;
using Xamarin.Forms.Xaml;
using Location = Xamarin.Essentials.Location;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class AddAlamatPage : ContentPage, INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        public AddAlamatPage()
        {
            InitializeComponent();
            get_provinces();
            get_location();
        }

        IOAuth2Service auth;
       
        private async void Save_Clicked(object sender, EventArgs e)
        {
          //  judul.Text,
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
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Provinsi>>(result);
                    List_Provinsi = new ObservableCollection<Provinsi>();
                    foreach (Provinsi item in json)
                    {

                        List_Provinsi.Add(new Provinsi { id = item.id, name = item.name });
                    }
                    picker_provinsi.ItemsSource = List_Provinsi;
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
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Kota>>(result);
                    List_Kota = new ObservableCollection<Kota>();
                    foreach (Kota item in json)
                    {

                        List_Kota.Add(new Kota { id = item.id, province_id = item.province_id, name = item.name, postal_code = item.postal_code});
                    }
                    picker_kota.ItemsSource = List_Kota;
                    //get_kecamatan(Selected_Kota.id.ToString()); 
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
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Kecamatan>>(result);
                    List_Kecamatan = new ObservableCollection<Kecamatan>();
                    foreach (Kecamatan item in json)
                    {

                        List_Kecamatan.Add(new Kecamatan { id = item.id, regency_id= item.regency_id, name = item.name});
                    }
                    picker_kecamatan.ItemsSource = List_Kecamatan;
                    
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
        protected virtual void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }

        private async  void picker_provinsi_SelectedIndexChanged(object sender, EventArgs e)
        {
            var picker = (Picker)sender;
            int selectedIndex = picker.SelectedIndex;

            if (selectedIndex != -1)
            {
                var selectedItem = (Provinsi)picker.SelectedItem;

                await get_kota(selectedItem.id.ToString());   
            }
        }

        private async void picker_kota_SelectedIndexChanged(object sender, EventArgs e)
        {
            var picker = (Picker)sender;
            int selectedIndex = picker.SelectedIndex;

            if (selectedIndex != -1)
            {
                var selectedItem = (Kota)picker.SelectedItem;

                await get_kecamatan(selectedItem.id.ToString());
            }
        }

        private void picker_kecamatan_SelectedIndexChanged(object sender, EventArgs e)
        {
            var picker = (Picker)sender;
            int selectedIndex = picker.SelectedIndex;

            if (selectedIndex != -1)
            {
                var selectedItem = (Kecamatan)picker.SelectedItem;

            }
        }

        CancellationTokenSource cts;
        public async Task get_location()
        {
                try
                {
                    var request = new GeolocationRequest(GeolocationAccuracy.Medium, TimeSpan.FromSeconds(10));
                    cts = new CancellationTokenSource();
                    var location = await Geolocation.GetLocationAsync(request, cts.Token);

                    if (location != null)
                    {
                    await NavigateToLocation(location);
                    }
                }
                catch (FeatureNotSupportedException fnsEx)
                {
                    // Handle not supported on device exception
                }
                catch (FeatureNotEnabledException fneEx)
                {
                    // Handle not enabled on device exception
                }
                catch (PermissionException pEx)
                {
                    // Handle permission exception
                }
                catch (Exception ex)
                {
                    // Unable to get location
                }
            }

        protected override void OnDisappearing()
        {
            if (cts != null && !cts.IsCancellationRequested)
                cts.Cancel();
            base.OnDisappearing();
        }

        public async Task NavigateToLocation(Location loc)
        {
            var location = new Location(loc.Latitude, loc.Longitude);
            var options = new MapLaunchOptions { Name = "Me" };

            try
            {
                Position position = new Position(loc.Latitude,loc.Longitude);
                MapSpan mapSpan = new MapSpan(position, 0.01, 0.01);
                map.MoveToRegion(mapSpan);
            }
            catch (Exception ex)
            {
                // No map application available to open
            }
        }
    }
}