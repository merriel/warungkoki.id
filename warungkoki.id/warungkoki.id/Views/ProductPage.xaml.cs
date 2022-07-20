using CarouselView.FormsPlugin.Abstractions;
using Rg.Plugins.Popup.Services;
using System;
using System.ComponentModel;
using System.Diagnostics;
using warungkoki.id.Models;
using warungkoki.id.Services;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.PlatformConfiguration.iOSSpecific;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    public partial class ProductPage : ContentPage
    {
        Product prod;
        public ProductPage(Product product)
        {
            this.prod = product;
            InitializeComponent();
            BindingContext = new ProductViewModel(prod);
            //image.SetBinding(sourceProperty)
            On<Xamarin.Forms.PlatformConfiguration.iOS>().SetUseSafeArea(true);
        }
        void Handle_PositionSelected(object sender, PositionSelectedEventArgs e)
        {
            var control = (CarouselViewControl)sender;
            Debug.WriteLine(control.SelectedItem);
        }

        private async void lovebuton_Clicked(object sender, EventArgs e)
        {
            var fav_like = (Favorit)BindingContext;
            TodoItemDatabase database = await TodoItemDatabase.Instance;
            await database.SaveItemAsync(fav_like);
            //change color love button
        }
    }
}