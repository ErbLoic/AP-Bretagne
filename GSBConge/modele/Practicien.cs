using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GSBConge.modele
{
    public class Practicien
    {
        public int id { get; set; }
        public string nom { get; set; }
        public string prenom { get; set; }
        public string adresse { get; set; }
        public float coef_noto { get; set; }
        public double salaire { get; set; }
        public string code_type { get; set; }
        public int id_ville { get; set; }
        public decimal solde_conge { get; set; }
        public decimal ancien_solde_conge { get; set; }

        public Practicien(int id, string nom, string prenom, string adresse, float coef_noto, double salaire, string code_type, int id_ville, decimal solde_conge, decimal ancien_solde_conge)
        {
            this.id = id;
            this.nom = nom;
            this.prenom = prenom;
            this.adresse = adresse;
            this.coef_noto = coef_noto;
            this.salaire = salaire;
            this.code_type = code_type;
            this.id_ville = id_ville;
            this.solde_conge = solde_conge;
            this.ancien_solde_conge = ancien_solde_conge;
        }

        public override string ToString() => $"{prenom} {nom} (ID: {id})";


    }
}
