using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Services;
using warungkoki.id.Views;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class LoginViewModel : BaseViewModel
    {
        public Command LoginCommand { get; }

        public Command LoginGoogleCommand { get; }
        public LoginViewModel()
        {
            LoginCommand = new Command(OnLoginClicked);
        }
        private string val;
        public string Value
        {
            get { return val; }
            set
            {
                val = value;
            }
        }
        private async void OnLoginClicked(object obj)
        {
            await LoginUserAsync(Value);

        }

        public async Task<string> GetEmailAsync(string tokenType, string accessToken)
        {
            var httpClient = new HttpClient();

            // Provide the OAuth token as an Authorization header
            httpClient.DefaultRequestHeaders.Authorization =
                new AuthenticationHeaderValue(tokenType, accessToken);

            // Query the API
            var json =
                await httpClient.GetStringAsync("https://www.googleapis.com/userinfo/email?alt=json");
            var email = JsonConvert.DeserializeObject<User>(json);
            return email.email;
        }


        public async Task LoginUserAsync(string email)
        {
            try
            {
                var data = new User
                {
                    email = email
                };

                var jsonString = JsonConvert.SerializeObject(data);
                var content = new StringContent(jsonString, Encoding.UTF8, "application/json");
                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/login_user.php" + "?email=" + email);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<User>>(result);
                    foreach (User item in json)
                    {
                        var valid_email = item.email;
                        App.Username = item.name;
                        Debug.WriteLine("JSON = " + result);
                        Application.Current.Properties["Username"] = item.name;
                        //if result insert into kehadiran table then open take picture page, else show exception / alertdialog
                        //for now return from API qrcode = null, _POST on PHP not working
                        await Shell.Current.GoToAsync($"//{nameof(HomePage)}");
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
    }
}
