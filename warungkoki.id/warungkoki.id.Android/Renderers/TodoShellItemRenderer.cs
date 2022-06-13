using Android.App;
using Android.Content;
using Android.Graphics;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using Google.Android.Material.BottomNavigation;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using warungkoki.id.Droid.Extensions;
using warungkoki.id.Services;
using Xamarin.Forms;
using Xamarin.Forms.Platform.Android;

namespace warungkoki.id.Droid.Renderers
{
    public class TodoShellItemRenderer : ShellItemRenderer
    {
        FrameLayout _shellOverlay;
        BottomNavigationView _bottomView;

        public TodoShellItemRenderer(IShellContext shellContext) : base(shellContext)
        {
        }

        public override Android.Views.View OnCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
        {
            var outerlayout = base.OnCreateView(inflater, container, savedInstanceState);
            _bottomView = outerlayout.FindViewById<BottomNavigationView>(Resource.Id.bottomtab_tabbar);
            _shellOverlay = outerlayout.FindViewById<FrameLayout>(Resource.Id.bottomtab_tabbar_container);

            if (ShellItem is TodoTabBar todoTabBar && todoTabBar.LargeTab != null)
                SetupLargeTab();

            return outerlayout;
        }

        private async void SetupLargeTab()
        {
            var todoTabBar = (TodoTabBar)ShellItem;
            var layout = new FrameLayout(Context);
            
            var imageHandler = todoTabBar.LargeTab.Icon.GetHandler();
            Bitmap bitmap = await imageHandler.LoadImageAsync(todoTabBar.LargeTab.Icon, Context);
            var image = new ImageView(Context);
            image.SetImageBitmap(bitmap);

            layout.AddView(image);

            var lp = new FrameLayout.LayoutParams(100, 100);
            _bottomView.Measure((int)MeasureSpecMode.Unspecified, (int)MeasureSpecMode.Unspecified);
            lp.BottomMargin = _bottomView.MeasuredHeight / 2;

            layout.LayoutParameters = lp;

            _shellOverlay.RemoveAllViews();
            _shellOverlay.AddView(layout);
        }
    }
}