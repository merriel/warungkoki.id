using System;
using System.Collections.Generic;
using warungkoki.id.ViewModels;
using warungkoki.id.Views;
using Xamarin.Forms;

namespace warungkoki.id
{
    public partial class AppShell : Xamarin.Forms.Shell
    {
        public AppShell()
        {
            InitializeComponent();
           
                Navigation.PushAsync(new LoginPage());
            
        
        }

    }
}
