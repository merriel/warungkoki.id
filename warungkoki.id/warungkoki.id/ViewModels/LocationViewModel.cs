using Google.Apis.Auth.OAuth2.Responses;
using MvvmHelpers;
using Newtonsoft.Json;
using Plugin.GoogleClient;
using Plugin.GoogleClient.Shared;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Diagnostics;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.Views;
using Xamarin.Auth;
using Xamarin.Forms;

namespace warungkoki.id.ViewModels
{
    public class LocationViewModel : ObservableRangeCollection<AlamatViewModel>, INotifyPropertyChanged
    {
        // It's a backup variable for storing CountryViewModel objects  
        private ObservableRangeCollection<AlamatViewModel> locationAlamat= new ObservableRangeCollection<AlamatViewModel>();
        public LocationViewModel(Location loc, bool expanded = false)
        {
            Location = loc;
            _expanded = expanded;
            foreach (Alamat address in loc.Addresss)
            {
                Add(new AlamatViewModel(address));
            }
            if (expanded) AddRange(locationAlamat);
        }
        public LocationViewModel() { }
        private bool _expanded;
        public bool Expanded
        {
            get
            {
                return _expanded;
            }
            set
            {
                if (_expanded != value)
                {
                    _expanded = value;
                    OnPropertyChanged(new PropertyChangedEventArgs("Expanded"));
                    OnPropertyChanged(new PropertyChangedEventArgs("StateIcon"));
                    if (_expanded)
                    {
                        AddRange(locationAlamat);
                    }
                    else
                    {
                        Clear();
                    }
                }
            }
        }
        public string StateIcon
        {
            get
            {
                if (Expanded)
                {
                    return "arrow_a.png";
                }
                else
                {
                    return "arrow_b.png";
                }
            }
        }
        public string Name
        {
            get
            {
                return Location.name;
            }
        }
        public Location Location
        {
            get;
            set;
        }
    }
}