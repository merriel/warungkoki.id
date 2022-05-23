using System;

using Android.App;
using Android.Content;
using Android.Gms.Auth.Api;
using Android.Gms.Auth.Api.SignIn;
using Android.Gms.Common;
using Android.Gms.Common.Apis;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using warungkoki.id.Droid;
using warungkoki.id.Models;
using Xamarin.Forms;

[assembly: Dependency(typeof(GoogleManager))]
namespace warungkoki.id.Droid
{
	public class GoogleManager : Java.Lang.Object, IGoogleManager
	{
		public Action<User, string> _onLoginComplete;
		GoogleSignInClient _googleApiClient;
		public static GoogleManager Instance { get; private set; }
		Context _context;

		public GoogleManager()
		{
			_context = global::Android.App.Application.Context;
			Instance = this;
		}

		public void Login(Action<User, string> onLoginComplete)
		{
			GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DefaultSignIn)
															 .RequestEmail()
															 .Build();
			_googleApiClient = GoogleSignIn.GetClient((_context).ApplicationContext, gso);

			_onLoginComplete = onLoginComplete;

			Intent intent = _googleApiClient.SignInIntent;
			
			((MainActivity)Forms.Context).StartActivityForResult(intent, 1);


		}

		public void onStart()
		{
			GoogleSignInAccount account = GoogleSignIn.GetLastSignedInAccount(_context.ApplicationContext);
		}
		public void OnAuthCompleted(GoogleSignInResult result)
		{
			if (result.IsSuccess)
			{
				GoogleSignInAccount accountt = result.SignInAccount;
				_onLoginComplete?.Invoke(new User()
				{
					name = accountt.DisplayName,
					email = accountt.Email
					//Picture = new Uri((accountt.PhotoUrl != null ? $"{accountt.PhotoUrl}" : $"https://autisticdating.net/imgs/profile-placeholder.jpg"))
				}, string.Empty);
			}
			else
			{
				_onLoginComplete?.Invoke(null, "An error occured!" + result.ToString());
			}
		}

		public void OnConnected(Bundle connectionHint)
		{

		}

		public void OnConnectionSuspended(int cause)
		{
			_onLoginComplete?.Invoke(null, "Canceled!");
		}

		public void OnConnectionFailed(ConnectionResult result)
		{
			_onLoginComplete?.Invoke(null, result.ErrorMessage);
		}
		public void Logout()
		{
			var gsoBuilder = new GoogleSignInOptions.Builder(GoogleSignInOptions.DefaultSignIn).RequestEmail();

			GoogleSignIn.GetClient(_context, gsoBuilder.Build())?.SignOut();

			_googleApiClient.SignOut();
		}
	}
}

