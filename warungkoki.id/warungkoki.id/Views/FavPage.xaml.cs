using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class FavPage : ContentPage
    {
        ObservableCollection<Alamat> data = new ObservableCollection<Alamat>();
        FavViewModel vm;
        string id;
        public FavPage()
        {
            InitializeComponent();
            vm = new FavViewModel(Navigation);
            this.BindingContext = vm;

        }
        protected async override void OnAppearing()
        {
            base.OnAppearing();
            if (Application.Current.Properties["ID"] != null)
            {
                await vm.get_favorit(Application.Current.Properties["ID"].ToString());

            }

        }
    }
}