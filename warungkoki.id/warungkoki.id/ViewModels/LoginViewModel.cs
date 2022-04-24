using Google.Apis.Auth.OAuth2.Responses;
using Newtonsoft.Json;
using Plugin.GoogleClient;
using Plugin.GoogleClient.Shared;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Views;
using Xamarin.Auth;
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
            LoginGoogleCommand = new Command(OnLoginGoogleClicked);
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

      private async void OnLoginGoogleClicked(object obj)
        {
           await LoginGoogleAsync();


        }
        OAuth2Authenticator Auth = null;
        async Task<TokenResponse> LoginGoogleAsync()
        {
            Auth = new OAuth2Authenticator(
     "601804528259 - sbu5kn43c496oa0j95jfaprvp7aupb1c.apps.googleusercontent.com",
     string.Empty,
     "email",
     new Uri("https://accounts.google.com/o/oauth2/v2/auth"),
     new Uri("com.companyname.warungkoki.id:/oauth2redirect"),
     new Uri("https://www.googleapis.com/oauth2/v4/token"),
     isUsingNativeUI: true);


            return Token;
        }
        public static TokenResponse Token { get; set; }

        private async void OnAuthenticationCompleted(object sender, AuthenticatorCompletedEventArgs e)
        {
            if (e.IsAuthenticated)
            {
                Token = new TokenResponse()
                {
                    AccessToken = e.Account.Properties["access_token"],
                    TokenType = e.Account.Properties["token_type"],
                    Scope = e.Account.Properties["scope"],
                    ExpiresInSeconds = int.Parse(e.Account.Properties["expires_in"]),
                    RefreshToken = e.Account.Properties["refresh_token"]
                };
                await Shell.Current.GoToAsync($"//{nameof(HomePage)}");

            }
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

                        //if result insert into kehadiran table then open take picture page, else show exception / alertdialog
                        //for now return from API qrcode = null, _POST on PHP not working
                        await Shell.Current.GoToAsync($"//{nameof(TransactionPage)}");
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
