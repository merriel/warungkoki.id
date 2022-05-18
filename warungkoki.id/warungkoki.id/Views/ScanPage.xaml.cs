using CarouselView.FormsPlugin.Abstractions;
using Rg.Plugins.Popup.Services;
using System;
using System.ComponentModel;
using System.Diagnostics;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.PlatformConfiguration.iOSSpecific;
using Xamarin.Forms.Xaml;
using ZXing.Net.Mobile.Forms;

namespace warungkoki.id.Views
{
    public partial class ScanPage : ContentPage
    {
        public ScanPage()
        {
            
            InitializeComponent();
            zxing.OnScanResult += (result) => Device.BeginInvokeOnMainThread(async () => {
                Debug.WriteLine("QR Code" + result.Text);

                zxing.IsScanning = false;

            });
        }
        protected override void OnAppearing()
        {
            base.OnAppearing();
            zxing.IsScanning = true;
        }
        protected override void OnDisappearing()
        {
            zxing.IsScanning = false;
            base.OnDisappearing();
        }


    }
}