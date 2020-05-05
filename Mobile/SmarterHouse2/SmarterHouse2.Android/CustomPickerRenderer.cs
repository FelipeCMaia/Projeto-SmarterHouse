using Android.Content.Res;
using SmarterHouse2.Droid;
using Xamarin.Forms;
using Xamarin.Forms.Platform.Android;
using System.Drawing;
using Android.Graphics.Drawables;
using Android.Text;
using SmarterHouse2;

[assembly: ExportRenderer(typeof(CustomPicker), typeof(CustomPickerRenderer))]
namespace SmarterHouse2.Droid
{
    [System.Obsolete]
    public class CustomPickerRenderer : PickerRenderer
    {
        protected override void OnElementChanged(ElementChangedEventArgs<Picker> e)
        {
            base.OnElementChanged(e);

            //LINHA
            if (Control != null)
            {
                GradientDrawable gd = new GradientDrawable();
                gd.SetColor(global::Android.Graphics.Color.Transparent);
                this.Control.SetBackgroundDrawable(gd);
                Control.SetHintTextColor(ColorStateList.ValueOf(global::Android.Graphics.Color.Rgb(229, 238, 199)));
            }

            //BORDA
            if (e.OldElement == null)
            {
                this.Control.Background = this.Resources.GetDrawable(Resource.Drawable.noBorderEditText);
            }
        }
    }
}