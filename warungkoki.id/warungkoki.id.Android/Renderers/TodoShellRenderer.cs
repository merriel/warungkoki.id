using Android.App;
using Android.Content;
using Android.Content.Res;
using Android.Graphics;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using Google.Android.Material.BottomNavigation;
using warungkoki.id.Droid.Extensions;
using warungkoki.id.Droid.Renderers;
using Xamarin.Forms;
using Xamarin.Forms.Platform.Android;

[assembly: ExportRenderer(typeof(Shell), typeof(TodoShellRenderer))]
namespace warungkoki.id.Droid.Renderers
{

    public class TodoShellRenderer : ShellRenderer
    {
        public TodoShellRenderer(Context context) : base(context)
        {
        }

        protected override IShellItemRenderer CreateShellItemRenderer(ShellItem shellItem)
        {
            return new TodoShellItemRenderer(this);
        }

        protected override IShellBottomNavViewAppearanceTracker CreateBottomNavViewAppearanceTracker(ShellItem shellItem)
        {
            return new TodoAppearance();
        }

    }

    public class TodoAppearance : IShellBottomNavViewAppearanceTracker
    {
        public void Dispose()
        {
           
        }

        public void ResetAppearance(BottomNavigationView bottomView)
        {
           
        }

        public void SetAppearance(BottomNavigationView bottomView, IShellAppearanceElement appearance)
        {
            bottomView.SetBackgroundColor(Android.Graphics.Color.ParseColor("#57ba7d"));

           // bottomView.ItemIconTintList = null;
        }
    }

}