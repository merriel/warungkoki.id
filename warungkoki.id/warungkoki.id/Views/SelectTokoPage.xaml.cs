using Rg.Plugins.Popup.Pages;
using Rg.Plugins.Popup.Services;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;
using warungkoki.id.ViewModels;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace warungkoki.id.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class SelectTokoPage : PopupPage
    {
        private ObservableCollection<MenuGroup> _allGroups;
        private ObservableCollection<MenuGroup> _expandedGroups;
        public SelectTokoPage()
        {
            InitializeComponent();

            _allGroups = MenuGroup.All;
            UpdateListContent();
        }

        //private void OnMenuSelected(object sender, SelectedItemChangedEventArgs e)
        //{
        //    var item = (MasterPageList)e.SelectedItem;

        //    if (item.Title == "Settings")
        //    {

        //    }
        //    else
        //    {
        //        //string dbPath = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.Personal), "vssSQLite.db3");
        //        //SQLiteConnection db = new SQLiteConnection(dbPath);
        //        //db.DropTable<LoginSqlLiteM>();

        //        //Application.Current.MainPage.Navigation.PushAsync(new MainPage());
        //    }
        //}
        //List<MasterPageList> GetMasterPageLists()
        //{
        //    return new List<MasterPageList>
        //    {
        //        new MasterPageList() { Title = "Settings", Icon = "settings.png",isVisible=false},
        //        new MasterPageList() { Title = "Logout", Icon = "logout.png",isVisible=false},

        //    };
        //}

        private void HeaderTapped(object sender, EventArgs args)
        {
            int selectedIndex = _expandedGroups.IndexOf(
                ((MenuGroup)((Button)sender).CommandParameter));
            _allGroups[selectedIndex].Expanded = !_allGroups[selectedIndex].Expanded;
            UpdateListContent();
        }

        private void UpdateListContent()
        {
            _expandedGroups = new ObservableCollection<MenuGroup>();
            foreach (MenuGroup group in _allGroups)
            {
                //Create new FoodGroups so we do not alter original list
                MenuGroup newGroup = new MenuGroup(group.Title, group.ShortName, group.Expanded);
                //Add the count of food items for Lits Header Titles to use
                newGroup.MenuCount = group.Count;
                if (group.Expanded)
                {
                    foreach (SubMenu menu in group)
                    {
                        newGroup.Add(menu);
                    }
                }
                _expandedGroups.Add(newGroup);
            }
            navigationDrawerList.ItemsSource = _expandedGroups;
        }
    }
}