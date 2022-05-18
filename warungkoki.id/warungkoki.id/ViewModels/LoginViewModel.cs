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
using warungkoki.id.Services;
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
            OAuth2Authenticator authenticator
                  = new Xamarin.Auth.OAuth2Authenticator
                  (
                      clientId:
                          new Func<string>
                             (
                                 () =>
                                 {
                                     string retval_client_id = "oops something is wrong!";

                                    // some people are sending the same AppID for google and other providers
                                    // not sure, but google (and others) might check AppID for Native/Installed apps
                                    // Android and iOS against UserAgent in request from 
                                    // CustomTabs and SFSafariViewContorller
                                    // TODO: send deliberately wrong AppID and note behaviour for the future
                                    // fitbit does not care - server side setup is quite liberal
                                    switch (Xamarin.Forms.Device.RuntimePlatform)
                                     {
                                         case "Android":
                                             retval_client_id = "601804528259-sbu5kn43c496oa0j95jfaprvp7aupb1c.apps.googleusercontent.com";
                                             break;
                                         case "iOS":
                                             retval_client_id = "601804528259-koje6aepg3gru5rlbnl6r7il7h6m95ec.apps.googleusercontent.com";
                                             break;
                                     }
                                     return retval_client_id;
                                 }
                            ).Invoke(),
                     clientSecret: null,   // null or ""
                     authorizeUrl: new Uri("http://www.whatsmyua.info/"), // new Uri("https://accounts.google.com/o/oauth2/v2/auth"),
                     //Uri("https://accounts.google.com/o/oauth2/auth"),
                     accessTokenUrl: new Uri("https://www.googleapis.com/oauth2/v4/token"),
                     redirectUrl:
                         new Func<Uri>
                             (
                                 () =>
                                 {

                                     string uri = null;

                                    // some people are sending the same AppID for google and other providers
                                    // not sure, but google (and others) might check AppID for Native/Installed apps
                                    // Android and iOS against UserAgent in request from 
                                    // CustomTabs and SFSafariViewContorller
                                    // TODO: send deliberately wrong AppID and note behaviour for the future
                                    // fitbit does not care - server side setup is quite liberal
                                    switch (Xamarin.Forms.Device.RuntimePlatform)
                                     {
                                         case "Android":
                                             uri =
                                                "com.xamarin.traditional.standard.samples.oauth.providers.android:/oauth2redirect"
                                                //"com.googleusercontent.apps.1093596514437-d3rpjj7clslhdg3uv365qpodsl5tq4fn:/oauth2redirect"
                                                ;
                                             break;
                                         case "iOS":
                                             uri =
                                                "com.xamarin.traditional.standard.samples.oauth.providers.ios:/oauth2redirect"
                                                //"com.googleusercontent.apps.1093596514437-cajdhnien8cpenof8rrdlphdrboo56jh:/oauth2redirect"
                                                ;
                                             break;
                                        
                                     }

                                     return new Uri(uri);
                                 }
                              ).Invoke(),
                      scope:
                                   //"profile"
                                   "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login"
                                   ,
                      getUsernameAsync: null,
                      isUsingNativeUI: true
                  )
                  {
                      AllowCancel = true,
                  };

            authenticator.Completed +=
                async (s, ea) =>
                {
                    StringBuilder sb = new StringBuilder();

                    if (ea.Account != null && ea.Account.Properties != null)
                    {
                        sb.Append("Token = ").AppendLine($"{ea.Account.Properties["access_token"]}");
                    }
                    else
                    {
                        sb.Append("Not authenticated ").AppendLine($"Account.Properties does not exist");
                    }

                   await Application.Current.MainPage.DisplayAlert
                            (
                                "Authentication Results",
                                sb.ToString(),
                                "OK"
                            );

                    return;
                };

            authenticator.Error +=
                async (s, ea) =>
                {
                    StringBuilder sb = new StringBuilder();
                    sb.Append("Error = ").AppendLine($"{ea.Message}");

                    await Application.Current.MainPage.DisplayAlert
                            (
                                "Authentication Error",
                                sb.ToString(),
                                "OK"
                            );
                    return;
                };

            // after initialization (creation and event subscribing) exposing local object 
            AuthenticationState.Authenticator = authenticator;

            //PresentUILoginScreen(authenticator);

            return;
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
                        App.Username = item.name;
                        Debug.WriteLine("JSON = " + result);
                        Application.Current.Properties["Username"] = item.name;
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
