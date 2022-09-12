using Java.Lang.Reflect;
using Newtonsoft.Json;
using Plugin.GoogleClient;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Telerik.XamarinForms.Common.Data;
using warungkoki.id.Models;
using warungkoki.id.Services;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using static Android.Content.ClipData;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class DetailTransaksiPage : ContentPage
    {
        ObservableCollection<TransaksiDetail> datadetail = new ObservableCollection<TransaksiDetail>();
        public DetailTransaksiPage(TransaksiGrouping trx)
        {
            InitializeComponent();
           
            status.Text = trx.status;
            tgl_beli.Text = trx.created_at;
            wil.Text = trx.wilayah_name;
            type_bayar.Text = trx.type_bayar;
            datadetail = trx.data_detail;
            total.Text = "Rp." + trx.amount;
            listView.ItemsSource = datadetail;
            
        }
        protected override async void OnAppearing()
        {
            base.OnAppearing();
            BindingContext = this;
        }
    }
}