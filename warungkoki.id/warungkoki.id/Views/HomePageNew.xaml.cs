using Rg.Plugins.Popup.Services;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    public partial class HomePageNew : ContentPage
    {
        public Item Item { get; set; }

        public HomePageNew()
        {
            InitializeComponent();
            BindingContext = new HomeViewModel();
            flvContainer.HeightRequest = GetGridContainerHeight(5, 2, 200);
        }

        public static double GetGridContainerHeight(double itemCount, double columnCount, int rowHeight) 
        { var rowCount = Math.Ceiling(itemCount / columnCount); return rowCount * rowHeight; }
        private async void picker_Clicked(object sender, EventArgs e)
        {
            var page = new SelectTokoPage();

            await PopupNavigation.Instance.PushAsync(page);
        }
    }
}