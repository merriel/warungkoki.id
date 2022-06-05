using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Services;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class LoginPage : ContentPage
    {
        User user_google = new User();
        public bool IsLogedIn { get; set; }

        public LoginPage(IOAuth2Service oAuth2Service)
        {
            InitializeComponent();
            this.BindingContext = new SocialLoginPageViewModel(oAuth2Service);
            //this.BindingContext = new LoginViewModel();
        }
       
        private async void OnLoginComplete(User googleUser, string message)
        {
            if (googleUser != null)
            {
                user_google = googleUser;
                IsLogedIn = true;
                Application.Current.Properties["Username"] =googleUser.name;
                Application.Current.Properties["Email"] = googleUser.email;
                await Shell.Current.GoToAsync($"//{nameof(HomePage)}");
            }
            else
            {
                await DisplayAlert("Message", message, "Ok");
            }
        }
    }
}