using Android.Content.Res;
using Android.Graphics.Drawables;
using Android.Text;
using SmarterHouse2;
using SmarterHouse2.Droid;
using System;
using Xamarin.Forms;
using Xamarin.Forms.Platform.Android;

[assembly: ExportRenderer(typeof(CustomEntry), target: typeof(CustomEntryRenderer))]
namespace SmarterHouse2.Droid
{
    [Obsolete]
    public class CustomEntryRenderer : EntryRenderer
    {
        protected override void OnElementChanged(ElementChangedEventArgs<Entry> e)
        {
            base.OnElementChanged(e);
            if(Control != null)
            {
                //linha
                GradientDrawable gd = new GradientDrawable();
                gd.SetColor(global::Android.Graphics.Color.Transparent);
                this.Control.SetBackgroundDrawable(gd);
                this.Control.SetRawInputType(InputTypes.TextFlagNoSuggestions);
                Control.SetHintTextColor(ColorStateList.ValueOf(global::Android.Graphics.Color.Rgb(229, 238, 199)));

                //borda
                Control.Background = Resources.GetDrawable(Resource.Drawable.RoundedEntry);
                Control.SetHeight(90);
            }
        }
    }
}