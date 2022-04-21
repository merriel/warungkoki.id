using CarouselView.FormsPlugin.Abstractions;
using FFImageLoading.Forms;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows.Input;
using warungkoki.id.Models;
using Xamarin.Essentials;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class HomeViewModel : BaseViewModel, INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        ObservableCollection<Banner> ListBanner = new ObservableCollection<Banner>();
        public HomeViewModel()
        {

            GetBannersAsync();
            MyListSource = new ObservableCollection<Item>()
            { new Item { Text = "Item1", Description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua", imageUrl = "item1.jpeg"},
             new Item { Text = "Item2", Description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua", imageUrl = "item2.jpeg"},
            new Item { Text = "Item3", Description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua", imageUrl = "item3.jpeg"},
            new Item { Text = "Item4", Description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua", imageUrl = "item4.jpeg"},
            new Item { Text = "Item5", Description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua", imageUrl = "item5.jpeg"}
            };

            PositionSelectedCommand = new Command<PositionSelectedEventArgs>((e) =>
            {
                Debug.WriteLine("Position " + e.NewValue + " selected.");
                Debug.Write(this.SelectedItem);
            });

            ScrolledCommand = new Command<CarouselView.FormsPlugin.Abstractions.ScrolledEventArgs>((e) =>
            {
                Debug.WriteLine("Scrolled to " + e.NewValue + " percent.");
                Debug.WriteLine("Direction = " + e.Direction);
            });
        }

        ObservableCollection<Banner> banners_source;
        public ObservableCollection<Banner> BannersSource
        {
            set
            {
                banners_source = value;
                OnPropertyChanged("BannersSource");
            }
            get
            {
                return banners_source;
            }
        }

        ObservableCollection<Item> _myListSource;
        public ObservableCollection<Item> MyListSource
        {
            set
            {
                _myListSource = value;
                OnPropertyChanged("MyListSource");
            }
            get
            {
                return _myListSource;
            }
        }

        object _selectedItem;
        public object SelectedItem
        {
            set
            {
                _selectedItem = value;
                OnPropertyChanged("SelectedItem");
            }
            get
            {
                return _selectedItem;
            }
        }

        public Command<PositionSelectedEventArgs> PositionSelectedCommand { protected set; get; }

        public Command<CarouselView.FormsPlugin.Abstractions.ScrolledEventArgs> ScrolledCommand { protected set; get; }

        protected virtual void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }

        public async Task GetBannersAsync()
        {
            try
            {

                var myHttpClient = new HttpClient();
                Uri uri = new Uri("http://elcapersada.com/warungkoki/android/get_banners.php");
                var response = await myHttpClient.GetStringAsync(uri);

                if (response != "[]")
                {
                    string result = response.Substring(1);
                    var json = JsonConvert.DeserializeObject<List<Banner>>(result);
                    System.Diagnostics.Debug.WriteLine("HASIL:");
                    System.Diagnostics.Debug.WriteLine(result);
                    BannersSource = new ObservableCollection<Banner>();
           
                    foreach (Banner item in json)
                    {
                        BannersSource.Add(new Banner { id = item.id, photo = "http://elcapersada.com/warungkoki/android/banners/" + item.photo, judul = item.judul});
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

            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("CAUGHT EXCEPTION:");
                System.Diagnostics.Debug.WriteLine(e);
            }
        }
    }
}