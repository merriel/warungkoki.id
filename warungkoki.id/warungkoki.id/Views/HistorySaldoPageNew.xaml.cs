using System.ComponentModel;
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
        }
    }
}