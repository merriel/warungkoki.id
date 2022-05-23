using warungkoki.id.Models;

namespace warungkoki.id.ViewModels
{
    public class AlamatViewModel : BaseViewModel
    {
        private Alamat _address;
        public AlamatViewModel(Alamat address)
        {
            _address = address;
        }
        public string AlamatName
        {
            get
            {
                return _address.name;
            }
        }
        public string AlamatLengkap
        {
            get
            {
                return _address.alamat;
            }
        }

        public int Id
        {
            get
            {
                return _address.id;
            }
        }
        public Alamat Alamat
        {
            get => _address;
        }
    }
}
