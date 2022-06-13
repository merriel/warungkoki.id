using warungkoki.id.Models;

namespace warungkoki.id.ViewModels
{
    public class AlamatViewModel : BaseViewModel
    {
        private Area _address;
        public AlamatViewModel(Area address)
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
        public Area Alamat
        {
            get => _address;
        }
    }
}
