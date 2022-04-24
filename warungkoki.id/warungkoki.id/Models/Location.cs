﻿using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace warungkoki.id.Models
{
    public class Location 
    {
        public int id { get; set; }
        public string name{ get; set; }
        public List<Alamat> Addresss
        {
            get;
            set;
        }
        public bool IsVisible
        {
            get;
            set;
        } = false;
        public Location() { }
        public Location(string Name, List<Alamat> address)
        {
            name = Name;
            Addresss = address;
        }
    }
}
