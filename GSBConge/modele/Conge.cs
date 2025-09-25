using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GSBConge.modele
{
    public class Conge
    {
        public int id { get; set; }
        public int id_praticien { get; set; }
        public DateTime date_debut { get; set; }
        public DateTime date_fin { get; set; }
        public string etat { get; set; }

        public Conge(int id, int id_praticien, DateTime date_debut, DateTime date_fin, string etat)
        {
            this.id = id;
            this.id_praticien = id_praticien;
            this.date_debut = date_debut;
            this.date_fin = date_fin;
            this.etat = etat;
        }
    }
}
