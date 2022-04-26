using Rg.Plugins.Popup.Pages;
using Rg.Plugins.Popup.Services;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Diagnostics;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class SelectTokoPage : PopupPage, INotifyPropertyChanged
    {
        public SelectTokoPage(TokoGroupViewModel viewModel)
        {
            InitializeComponent();
            //BindingContext = new SelectTokoViewModel();
            this.ViewModel = viewModel;
        }

        private TokoGroupViewModel ViewModel
        {
            get { return (TokoGroupViewModel)BindingContext; }
            set { BindingContext = value; }
        }


        protected override void OnAppearing()
        {
            try
            {
                base.OnAppearing();

                if (ViewModel.Items.Count == 0)
                {
                    ViewModel.LoadHotelsCommand.Execute(null);
                }
            }
            catch (Exception Ex)
            {
                Debug.WriteLine(Ex.Message);
            }
        }
        private async void OnItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (e.SelectedItem == null) return;
            Debug.WriteLine(e.SelectedItem.ToString());
            await PopupNavigation.Instance.PopAsync();
        }
    }
}