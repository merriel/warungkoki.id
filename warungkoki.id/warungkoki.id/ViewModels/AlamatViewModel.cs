using Google.Apis.Auth.OAuth2.Responses;
using Newtonsoft.Json;
using Plugin.GoogleClient;
using Plugin.GoogleClient.Shared;
using System;
using System.Collections.Generic;
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
    public class AlamatViewModel : BaseViewModel
    {
        private Alamat _address;
        public AlamatViewModel(Alamat address)
        {
            _address = address;
        }
        public string AlamatName
        {
            get
            {
                return _address.name;
            }
        }
        public string AlamatLengkap
        {
            get
            {
                return _address.alamat;
            }
        }

        public int Id
        {
            get
            {
                return _address.id;
            }
        }
        public Alamat Alamat
        {
            get => _address;
        }
    }
}
