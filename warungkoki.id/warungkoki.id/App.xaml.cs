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
        public static string Email;
        public App(IOAuth2Service oAuth2Service)
        {
            InitializeComponent();

            Sharpnado.Tabs.Initializer.Initialize(false, false);
            Sharpnado.Shades.Initializer.Initialize(loggerEnable: false);
            DependencyService.Register<MockDataStore>();
            MainPage = new AppShell(oAuth2Service);
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
