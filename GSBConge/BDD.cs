using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;
using BCrypt.Net;
using GSBConge.modele;

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

        public string mail { get; set; }
        public int privilege { get; set; }
        public int praticien {  get; set; }


        private MySqlConnection connection;


            public BDD(string identifiant, string mdp, string serveur, string table)
            {
                this.identifiant = identifiant;
                this.mdp = mdp;
                this.serveur = serveur;
                this.table = table;
            this.mail = "";
            this.privilege = 0;
            this.praticien = 0;
            }

            public void Connecter()
            {
                string connectionString = $"Server={serveur};Database={table};User Id={identifiant};Password={mdp};";
                connection = new MySqlConnection(connectionString);

                try
                {
                    connection.Open();

                }
                catch (Exception ex)
                {
                    MessageBox.Show("Erreur de connexion : " + ex.Message);
                }
            }

        public void SeConnecter(Connexion_form form, string identif, string mdp)
        {
                try
                {
                string requete = "SELECT * FROM connexion WHERE identifiant = @identifiant";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@identifiant", identif);

                MySqlDataReader reader = cmd.ExecuteReader();

                if (reader.Read()) 
                {
                    string hashStocke = reader["mdp"].ToString();

                    
                    if (BCrypt.Net.BCrypt.Verify(mdp, hashStocke))
                    {
                        
                        this.mail = reader["identifiant"].ToString();
                        this.privilege = Convert.ToInt32(reader["privilèges"]);
                        this.praticien = Convert.ToInt32(reader["id_praticiens"]);

                        if (this.privilege == 2)
                        {
                            User form2 = new User();
                            form2.Show();
                            form.Hide();
                        }
                        else
                        {
                            admin form3 = new admin();
                            form3.Show();
                            form.Hide();
                        }

                    }
                    else
                    {
                        MessageBox.Show("❌");
                    }
                }
                else
                {
                    MessageBox.Show("❌ ");
                }


                reader.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
        }

        
    }
}
