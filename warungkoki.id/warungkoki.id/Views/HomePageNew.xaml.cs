using Plugin.GoogleClient;
using Rg.Plugins.Popup.Services;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using warungkoki.id.Models;
using warungkoki.id.Services;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    public partial class HomePageNew : ContentPage
    {
        public Item Item { get; set; }

        IOAuth2Service auth;

        public HomePageNew()
        {
            InitializeComponent();
            BindingContext = new HomeViewModel(Navigation);
            if (Application.Current.Properties.ContainsKey("Username") && Application.Current.Properties["Username"] != null)
            {

                userr.Text = "Hello, " + Application.Current.Properties["Username"].ToString();
            }
           
            //flvContainer.HeightRequest = GetGridContainerHeight(5, 2, 200);
        }

        public static double GetGridContainerHeight(double itemCount, double columnCount, int rowHeight) 
        { var rowCount = Math.Ceiling(itemCount / columnCount); return rowCount * rowHeight; }
        private async void picker_Clicked(object sender, EventArgs e)
        {
            var page = new SelectTokoPage(new TokoGroupViewModel());

            await PopupNavigation.Instance.PushAsync(page);
        }

        private void Logout_Clicked(object sender, EventArgs e)
        {
            CrossGoogleClient.Current.Logout();
            Application.Current.Properties.Clear();
            Navigation.PushAsync(new LoginPage(auth));
        }
    }
}