using CarouselView.FormsPlugin.Abstractions;
using Rg.Plugins.Popup.Services;
using System;
using System.ComponentModel;
using System.Diagnostics;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.PlatformConfiguration.iOSSpecific;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    public partial class ProductPage : ContentPage
    {
        public ProductPage()
        {
            InitializeComponent();
            On<Xamarin.Forms.PlatformConfiguration.iOS>().SetUseSafeArea(true);
            Xamarin.Forms.NavigationPage.SetTitleIconImageSource(this, "titlebar.jpeg");
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