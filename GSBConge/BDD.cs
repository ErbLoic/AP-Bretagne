using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace GSBConge
{
    interface IBDD
    {
        string identifiant { get; set; }
        string mdp { get; set; }
        string serveur { get; set; }
        string table { get; set; }


    }
        public class BDD : IBDD
        {
            public string identifiant { get; set; }
            public string mdp { get; set; }
            public string serveur { get; set; }
            public string table { get; set; }

            private MySqlConnection connection;

            public BDD(string identifiant, string mdp, string serveur, string table)
            {
                this.identifiant = identifiant;
                this.mdp = mdp;
                this.serveur = serveur;
                this.table = table;
            }

            // Connexion à la base
            public void Connecter()
            {
                string connectionString = $"Server={serveur};Database={table};User Id={identifiant};Password={mdp};";
                connection = new MySqlConnection(connectionString);

                try
                {
                    connection.Open();
                    MessageBox.Show("Connexion réussie !");
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Erreur de connexion : " + ex.Message);
                }
            }
        }
    }
