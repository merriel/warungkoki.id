using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class MenuGroup : ObservableCollection<SubMenu>, INotifyPropertyChanged
    {
        private bool _expanded;
        public string Title { get; set; }
        public string Icon { get; set; }

        public string TitleWithItemCount
        {
            get { return string.Format("{0} ({1})", Title, MenuCount); }
        }

        public string ShortName { get; set; }

        public bool Expanded
        {
            get { return _expanded; }
            set
            {
                if (_expanded != value)
                {
                    _expanded = value;
                    OnPropertyChanged("Expanded");
                    OnPropertyChanged("StateIcon");
                }
            }
        }

        public string StateIcon
        {
            get { return Expanded ? "expanded_blue.png" : "collapsed_blue.png"; }
        }

        public int MenuCount { get; set; }

        public MenuGroup(string title, string shortName, bool expanded = true)
        {
            Title = title;
            ShortName = shortName;
            Expanded = expanded;
        }

        public static ObservableCollection<MenuGroup> All { private set; get; }

        static MenuGroup()
        {
            ObservableCollection<MenuGroup> Groups = new ObservableCollection<MenuGroup>{
                new MenuGroup("Settings","C"){
                    new SubMenu { Name = "pasta"},
                    new SubMenu { Name = "potato"},
                    new SubMenu { Name = "bread"},
                    new SubMenu { Name = "rice"},
                },
             new MenuGroup("Logout","L"){
                    new SubMenu { Name = "pasta"},
                    new SubMenu { Name = "potato"},
                    new SubMenu { Name = "bread"},
                    new SubMenu { Name = "rice"},
                }};
            All = Groups;
        }


        public event PropertyChangedEventHandler PropertyChanged;
        protected virtual void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }
    }
}
