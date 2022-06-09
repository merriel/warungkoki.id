using Newtonsoft.Json;
using Plugin.GoogleClient;
using System;
using System.Collections.Generic;
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
    public partial class Profile : ContentPage
    {
        string id;
        public Profile()
        {
            InitializeComponent();
            if (Application.Current.Properties["ID"] != null)
            {
                id = Application.Current.Properties["ID"].ToString();
                get_profile(id);
            }
        }

        IOAuth2Service auth;
        private void Logout_Clicked(object sender, EventArgs e)
        {
            CrossGoogleClient.Current.Logout();
            Application.Current.Properties.Clear();
            Navigation.PushAsync(new LoginPage(auth));
        }

        private async void Update_Clicked(object sender, EventArgs e)
        {
             await update_profile(id, name.Text.ToString(), phone.Text.ToString(), email.Text.ToString(), nik.Text.ToString(), pin.Text.ToString());
            
        }

        public async Task get_profile(string id)
        {
            try
            {
                
                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/profile_get.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<User>>(response);
                    foreach (User item in json)
                    {
                        
                        App.Username = item.name;
                        Application.Current.Properties["Username"] = item.name;
                        name.Text = item.name;

                        var valid_email = item.email;
                        Application.Current.Properties["Email"] = item.email;
                        email.Text = item.email;

                        phone.Text = item.no_hp;
                        nik.Text = item.ktp;
                        
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