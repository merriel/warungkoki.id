using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class TransaksiPage : ContentPage
    {
        ObservableCollection<Transaksi> data = new ObservableCollection<Transaksi>();
        ObservableCollection<TransaksiGrouping> datagroup = new ObservableCollection<TransaksiGrouping>();
        ObservableCollection<TransaksiDetail> datadetail = new ObservableCollection<TransaksiDetail>();
        string id;
        public TransaksiPage()
        {
            InitializeComponent();
            if (Application.Current.Properties["ID"] != null)
            {
                id = Application.Current.Properties["ID"].ToString();
                get_transaksi(id);
            }
           
        }
        string namesgroup;
        double amountsgroup;
        public async Task get_transaksi(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/transaksi_user.php" + "?user_id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);
                if ( !response.Contains("NULL"))
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Transaksi>>(result);
                    
                    foreach (Transaksi item in json)
                    {
                        data.Add(new Transaksi
                        {
                            id = item.id, uuid = item.uuid, delivery_code = item.delivery_code,
                            user_id = item.user_id, petugas_id = item.petugas_id, wilayah_id = item.wilayah_id,
                            retailer_id = item.retailer_id, cash = item.cash, type = item.type, status = item.status,
                            ket = item.ket, plan = item.plan, alamat_id = item.alamat_id, ready = item.ready,
                            pembelian_at = item.pembelian_at, created_at = item.created_at, updated_at = item.updated_at,
                            type_bayar = item.type_bayar , undian_name = item.undian_name
                        });
                        await get_detail(item.id, item.type_bayar, item.created_at, item.status);
                        datagroup.Add( new TransaksiGrouping {names = namesgroup, created_at = item.created_at, amount = amountsgroup,
                                        jumlah_item = datadetail.Count().ToString(), status = item.status, type_bayar = item.type_bayar});
                        namesgroup = "";
                        amountsgroup = 0;
                        datadetail = new ObservableCollection<TransaksiDetail>();
                    }

                    listView.IsVisible = true;
                    emptyTransaksi.IsVisible = false;
                    listView.ItemsSource = datagroup;
                    

                }
                else {
                    listView.IsVisible = false;
                    emptyTransaksi.IsVisible = true;
                }
               
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

       
        public async Task get_detail(string id, string type, string created, string status)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/transaksi_user_detail.php" + "?transaction_id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                System.Diagnostics.Debug.WriteLine("BLABLABLA= " + response);
                if (response!="NULL")
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<TransaksiDetail>>(result);
                   
                    foreach (TransaksiDetail item in json)
                    {
                        datadetail.Add(new TransaksiDetail
                        {
                            name = item.name,
                            product_name = item.product_name,
                            created_at = item.created_at,
                            amount= item.amount,
                            wilayah_name= item.wilayah_name
                        });
                        namesgroup = item.product_name +" "+ item.name + ", ";
                        if (item.amount != null)
                        {
                            amountsgroup = +double.Parse(item.amount);
                        }else
                        {
                            amountsgroup = 0+amountsgroup;
                        }
                        
                    }
                    System.Diagnostics.Debug.WriteLine("LALALA = " +namesgroup + amountsgroup.ToString());
                    
                }
              
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        private async void listView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            TransaksiGrouping selectedtransaksi = e.SelectedItem as TransaksiGrouping;
            await Navigation.PushAsync(new DetailTransaksiPage(selectedtransaksi));
        }
    }
}