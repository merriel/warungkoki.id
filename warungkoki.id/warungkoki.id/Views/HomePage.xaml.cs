using CarouselView.FormsPlugin.Abstractions;
using Rg.Plugins.Popup.Services;
using System;
using System.ComponentModel;
using System.Diagnostics;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.PlatformConfiguration.iOSSpecific;
using Xamarin.Forms.Xaml;
using Application = Xamarin.Forms.Application;

namespace warungkoki.id.Views
{
    public partial class HomePage : ContentPage
    {
        public HomePage()
        {
            InitializeComponent();
            On<Xamarin.Forms.PlatformConfiguration.iOS>().SetUseSafeArea(true);
            Xamarin.Forms.NavigationPage.SetTitleIconImageSource(this, "titlebar.jpeg");
            if (Application.Current.Properties.ContainsKey("Username") && Application.Current.Properties["Username"] != null)
            {
                username.Text = "Hello, "+ Application.Current.Properties["Username"].ToString();

            }
            BindingContext = new HomeViewModel(Navigation);
        }
        void Handle_PositionSelected(object sender, PositionSelectedEventArgs e)
        {
            var control = (CarouselViewControl)sender;
            Debug.WriteLine(control.SelectedItem);
        }
        private async void picker_Clicked(object sender, EventArgs e)
        {
            var page = new SelectTokoPage(new TokoGroupViewModel());

            await PopupNavigation.Instance.PushAsync(page);
        }
    }
}