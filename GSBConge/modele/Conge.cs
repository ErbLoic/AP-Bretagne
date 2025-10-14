using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using GSBConge.modele;

namespace GSBConge.modele
{
    public interface IConge
    {
        int id { get; set; }
        int id_praticien { get; set; }
        DateTime date_debut { get; set; }
        DateTime date_fin { get; set; }
        string etat { get; set; }
        
    }
    public class Conge
    {
        public int id { get; set; }
        public int id_praticien { get; set; }
        public DateTime date_debut { get; set; }
        public DateTime date_fin { get; set; }
        public string etat { get; set; }

        public Practicien praticien { get; set; }

        public Conge(int id, int id_praticien, DateTime date_debut, DateTime date_fin, string etat)
        {
            this.id = id;
            this.id_praticien = id_praticien;
            this.date_debut = date_debut;
            this.date_fin = date_fin;
            this.etat = etat;
            this.praticien = praticien;
        }

        public void AddPraticien(Practicien prat)
        {
            this.praticien = prat;
        }
    }
}
