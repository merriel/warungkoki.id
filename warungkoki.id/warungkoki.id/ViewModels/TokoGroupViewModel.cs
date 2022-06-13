using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Diagnostics;
using System.Net.Http;
using System.Threading.Tasks;
using warungkoki.id.Models;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class TokoGroupViewModel : BaseViewModel
    {
        private LocationViewModel _oldHotel;
        private ObservableCollection<LocationViewModel> items;
        public ObservableCollection<LocationViewModel> Items
        {
            get => items;
            set => SetProperty(ref items, value);
        }
        private string _selected;
        public string Selected
        {
            get { return _selected; }
            set
            {
                _selected = value;
                if (_selected != null)
                {
                    OnPropertyChanged();
                }
            }
        }
        public Command LoadHotelsCommand
        {
            get;
            set;
        }
        public Command<LocationViewModel> RefreshItemsCommand
        {
            get;
            set;
        }
        public TokoGroupViewModel()
        {
            items = new ObservableCollection<LocationViewModel>();
            //Items = new ObservableCollection<LocationViewModel>();
            LoadHotelsCommand = new Command(async () => await ExecuteLoadItemsCommandAsync());
            RefreshItemsCommand = new Command<LocationViewModel>((item) => ExecuteRefreshItemsCommand(item));
        }
        public bool isExpanded = false;
        private void ExecuteRefreshItemsCommand(LocationViewModel item)
        {
            if (_oldHotel == item)
            {
                // click twice on the same item will hide it  
                item.Expanded = !item.Expanded;
            }
            else
            {
                if (_oldHotel != null)
                {
                    // hide previous selected item  
                   _oldHotel.Expanded = false;
                }
                // show selected item  
                item.Expanded = true;
            }
            _oldHotel = item;
        }

        List<Location> json = new List<Location>();
        List<Location> itemsloc = new List<Location>();
        private async Task ExecuteLoadItemsCommandAsync()
        {
            try
            {
                if(IsBusy) return;
                IsBusy = true;
                Items.Clear();
                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_location.php");
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    json = JsonConvert.DeserializeObject<List<Location>>(result);
                    
                    foreach (Location item in json)
                    {
                        //itemsloc.Add(new Location { name= item.name, Addresss=  Hotel1rooms });
                        await calldetailalamat(item.id, item.name);

                    }
                    if (itemsloc != null && itemsloc.Count > 0)
                    {
                        foreach (var location in itemsloc)
                            Items.Add(new LocationViewModel(location));
                    }
                    else
                    {
                        IsEmpty = true;
                    }
                    myHttpClient.Dispose();
                }
                else
                {
                    //await Application.Current.MainPage.DisplayAlert(null, "Data not found", "ok");
                    System.Diagnostics.Debug.WriteLine("KOSONG;");
                    System.Diagnostics.Debug.WriteLine(response);
                }
                myHttpClient.Dispose();
            }

            catch (Exception ex)
            {
                IsBusy = false;
                Debug.WriteLine(ex);
            }
            finally
            {
                IsBusy = false;
            }
        }

        private async Task calldetailalamat(int id, string locname)
        {
            try
            {
                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_area.php?"+"id="+id);
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    var jsonalamat = JsonConvert.DeserializeObject<List<Area>>(result);
                    List<Area> detilalamat = new List<Area>();

                    foreach (Area item in jsonalamat)
                    {
                        detilalamat.Add(new Area { name = item.name, id = item.id, alamat = item.alamat});
                    }
                    
                        itemsloc.Add(new Location { name = locname,Addresss= detilalamat});
                    
                    
                    myHttpClient.Dispose();
                }
                else
                {
                    //await Application.Current.MainPage.DisplayAlert(null, "Data not found", "ok");
                    System.Diagnostics.Debug.WriteLine("KOSONG;");
                    System.Diagnostics.Debug.WriteLine(response);
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
