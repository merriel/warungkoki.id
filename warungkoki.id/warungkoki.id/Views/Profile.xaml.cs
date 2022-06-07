using Plugin.GoogleClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Services;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class Profile : ContentPage
    {
        public Profile()
        {
            InitializeComponent();
        }

        IOAuth2Service auth;
        private void Logout_Clicked(object sender, EventArgs e)
        {
            CrossGoogleClient.Current.Logout();
            Application.Current.Properties.Clear();
            Navigation.PushAsync(new LoginPage(auth));
        }

        private void Update_Clicked(object sender, EventArgs e)
        {
            
        }
    }
}