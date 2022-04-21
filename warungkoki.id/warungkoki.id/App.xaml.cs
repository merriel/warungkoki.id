using System;
using warungkoki.id.Services;
using warungkoki.id.Views;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id
{
    public partial class App : Application
    {
        public static string Username;
        public App()
        {
            InitializeComponent();

            Sharpnado.Tabs.Initializer.Initialize(false, false);
            Sharpnado.Shades.Initializer.Initialize(loggerEnable: false);
            DependencyService.Register<MockDataStore>();
            MainPage = new AppShell();
        }

        protected override void OnStart()
        {
        }

        protected override void OnSleep()
        {
        }

        protected override void OnResume()
        {
        }
    }
}
