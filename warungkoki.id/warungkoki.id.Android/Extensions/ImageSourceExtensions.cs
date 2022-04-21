using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Xamarin.Forms;
using Xamarin.Forms.Platform.Android;

namespace warungkoki.id.Droid.Extensions
{
    internal static class ImageSourceExtensions
    {
        public static IImageSourceHandler GetHandler(this ImageSource imageSource)
        {
            if (imageSource is UriImageSource)
                return new ImageLoaderSourceHandler();
            else if (imageSource is FileImageSource)
                return new FileImageSourceHandler();
            else if (imageSource is StreamImageSource)
                return new StreamImagesourceHandler();
            else if (imageSource is FontImageSource)
                return new FontImageSourceHandler();

            return null;
        }
    }
}