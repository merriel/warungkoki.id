using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Net.Http;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;

namespace warungkoki.id.Views
{
    public partial class HistorySaldoPageNew : ContentPage
    {
        public HistorySaldoPageNew()
        {
            InitializeComponent();
            BindingContext = new ItemDetailViewModel();
            if (Application.Current.Properties["ID"] != null)
            {
                get_saldo(Application.Current.Properties["ID"].ToString());
                get_history(Application.Current.Properties["ID"].ToString());
            }
           
        }

        public async void get_saldo(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/saldohistorytotal.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                if ( !response.Equals("NULL"))
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Saldo>>(response);
                    foreach (Saldo item in json)
                    {
                        saldo_sisa.Text = "Rp. " + item.sisa;
                        
                    }
                }
                else
                {
                    saldo_sisa.Text = "Rp. 0";
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }

        ObservableCollection<Saldo> data = new ObservableCollection<Saldo>();
        public async void get_history(string id)
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/saldohistory.php" + "?id=" + id);
                var response = await myHttpClient.GetStringAsync(uri);

                if ( !response.Equals("NULL"))
                {
                    //string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Saldo>>(response);
                    foreach (Saldo item in json)
                    {
                        data.Add(new Saldo
                        {
                            id = item.id,
                            user_id = id,
                            saldotrans_id = item.saldotrans_id,
                            before = item.before,
                            sisa = item.sisa,
                            status= item.status,
                            created_at = item.created_at,
                            updated_at = item.updated_at,
                            amount = item.amount
                        }); ;

                    }

                    listView.ItemsSource = data;
                }
                else
                {
                    
                }
                myHttpClient.Dispose();
            }

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }
    }
}