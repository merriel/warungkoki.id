using System;
using System.Collections.Generic;
using warungkoki.id.Services;
using warungkoki.id.ViewModels;
using warungkoki.id.Views;
using Xamarin.Forms;

namespace warungkoki.id
{
    public partial class AppShell : Xamarin.Forms.Shell
    {
        public AppShell(IOAuth2Service oAuth2Service)
        {
            InitializeComponent();
            if (!Application.Current.Properties.ContainsKey("Username") || Application.Current.Properties["Username"] == null)
            {
                Navigation.PushAsync(new LoginPage(oAuth2Service));
            }

        }

    }
}
