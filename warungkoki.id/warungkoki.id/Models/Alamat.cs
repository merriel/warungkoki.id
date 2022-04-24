using System;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Alamat
    {
        public int id { get; set; }
        
        public string name { get; set; }
        public string alamat { get; set; }
        public Alamat() { }
        public Alamat(string Name, int ID, string lengkap)
        {
            name = Name;
            id = ID;
            alamat = lengkap;
        }
    }
}