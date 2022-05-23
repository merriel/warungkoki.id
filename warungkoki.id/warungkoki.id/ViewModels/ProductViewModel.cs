using warungkoki.id.Models;

namespace warungkoki.id.ViewModels
{
    public class ProductViewModel : BaseViewModel
    {
        Product product;
        string toko_name;
        public ProductViewModel(Product prod)
        {
            this.product = prod;
            toko_name = product.wilayah_name.Substring(46);
        }

        string _selectedImage;
        public string SelectedImage
        {
            set
            {
                _selectedImage= product.img;
                OnPropertyChanged("SelectedItem");
            }
            get
            {
                return product.img;
            }
        }

        string _name;
        public string Name
        {
            set
            {
                _name = product.prod_name;
                OnPropertyChanged("Name");
            }
            get
            {
                return product.prod_name;
            }
        }

        string toko;
        public string Toko
        {
            set
            {
                toko = toko_name;
                OnPropertyChanged("Toko");
            }
            get
            {
                return toko_name;
            }
        }

        string alamat;
        public string Alamat
        {
            set
            {
                alamat = product.alamat;
                OnPropertyChanged("Alamat");
            }
            get
            {
                return product.alamat;
            }
        }

        double harga;
        public double Harga
        {
            set
            {
                harga = product.harga_act;
                OnPropertyChanged("Harga");
            }
            get
            {
                return product.harga_act;
            }
        }
    }
}
