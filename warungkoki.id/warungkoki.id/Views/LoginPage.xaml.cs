using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class LoginPage : ContentPage
    {
        private readonly IGoogleManager _googleManager;
        User user_google = new User();
        public bool IsLogedIn { get; set; }

        public LoginPage()
        {
            _googleManager = DependencyService.Get<IGoogleManager>();
            CheckUserLoggedIn();
            InitializeComponent();
            
            this.BindingContext = new LoginViewModel();
        }
        private void CheckUserLoggedIn()
        {
            _googleManager.Login(OnLoginComplete);
        }

        private void btnLogin_Clicked(object sender, EventArgs e)
        {
            _googleManager.Login(OnLoginComplete);
        }
        private async void OnLoginComplete(User googleUser, string message)
        {
            if (googleUser != null)
            {
                user_google = googleUser;
                IsLogedIn = true;
                Application.Current.Properties["Username"] =googleUser.name;
                Application.Current.Properties["Email"] = googleUser.email;
                await Shell.Current.GoToAsync($"//{nameof(TransactionPage)}");
            }
            else
            {
                await DisplayAlert("Message", message, "Ok");
            }
        }
    }
}