using System.ComponentModel;
using warungkoki.id.ViewModels;
using Xamarin.Forms;

namespace warungkoki.id.Views
{
    public partial class TransactionPageNew : ContentPage
    {
        public TransactionPageNew()
        {
            InitializeComponent();
            BindingContext = new ItemDetailViewModel();
        }
    }
}