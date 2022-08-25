using Rg.Plugins.Popup.Extensions;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class KonfirmasiPopUpPage : Rg.Plugins.Popup.Pages.PopupPage
    {
        public KonfirmasiPopUpPage()
        {
            InitializeComponent();
        }

        private async void Button_Clicked(object sender, EventArgs e)
        {
            await Navigation.PopPopupAsync();
        }

        private async void TapGestureTakeAway_Tapped(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new PembayaranPage());
            await Navigation.PopPopupAsync();
        }

        private void TapGestureDelivery_Tapped(object sender, EventArgs e)
        {

        }
    }
}