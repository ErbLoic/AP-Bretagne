using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GSBConge.modele
{
    public interface IPracticien
    {
        int id { get; set; }
        string nom { get; set; }
        string prenom { get; set; }
        int id_ville { get; set; }
        decimal solde_conge { get; set; }
    }
    public class Practicien : IPracticien
    {
        public int id { get; set; }
        public string nom { get; set; }
        public string prenom { get; set; }
        public int id_ville { get; set; }
        public decimal solde_conge { get; set; }

        public Practicien(int id, string nom, string prenom,  int id_ville, decimal solde_conge)
        {
            this.id = id;
            this.nom = nom;
            this.prenom = prenom;
            this.id_ville = id_ville;
            this.solde_conge = solde_conge;
        }

        public override string ToString() => $"{prenom} {nom} (ID: {id})";


    }
}
