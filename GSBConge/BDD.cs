using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;
using BCrypt.Net;
using GSBConge.modele;
using System.Windows.Forms;

namespace GSBConge
{
    interface IBDD
    {
        string identifiant { get; set; }
        string mdp { get; set; }
        string serveur { get; set; }
        string table { get; set; }

        void SeConnecter(Connexion_form form, string identif, string mdp);
        List<Conge> ChargerConge();
        List<Practicien> ChargerPrati();
        Practicien ChargerPraticienrByid(int id);


        void InsérerConge(Conge conge, Label lbl, Practicien prat);
        void AcceptéCongé(Conge conge);
        void RefuséCongé(Conge conge);
        void AfficherMessage(int idp);

    }
    public class BDD : IBDD
    {
        public string identifiant { get; set; }
        public string mdp { get; set; }
        public string serveur { get; set; }
        public string table { get; set; }

        public string mail { get; set; }
        public int privilege { get; set; }
        public int praticien { get; set; }


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
                            User form2 = new User(this.praticien,form);
                            form2.Show();
                            form.Hide();
                        }
                        else
                        {
                            admin form3 = new admin(form);
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

        public List<Conge> ChargerConge()
        {

            List<Conge> listeConge = new List<Conge>();
            try
            {
                string requete = "SELECT * FROM congé where état=1";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id_praticiens", this.praticien);
                MySqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    int id = Convert.ToInt32(reader["id"]);
                    int id_praticien = Convert.ToInt32(reader["id_praticien"]);
                    DateTime date_debut = Convert.ToDateTime(reader["date_debut"]);
                    DateTime date_fin = Convert.ToDateTime(reader["date_fin"]);
                    string etat = reader["état"].ToString();

                    Conge conge = new Conge(id, id_praticien, date_debut, date_fin, etat);
                    listeConge.Add(conge);
                }
                reader.Close();

            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
            return listeConge;
        }

        public List<Practicien> ChargerPrati()
        {

            List<Practicien> listePra = new List<Practicien>();
            try
            {
                string requete = "SELECT * FROM praticien";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id_praticiens", this.praticien);
                MySqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    int id = Convert.ToInt32(reader["id"]);
                    string nom = reader["nom"].ToString();
                    string prenom = reader["prenom"].ToString();
                    int id_ville = Convert.ToInt32(reader["id_ville"]);
                    decimal solde_conge = Convert.ToDecimal(reader["Solde_congé"]);


                    Practicien prat = new Practicien(id, nom, prenom, id_ville, solde_conge);

                    listePra.Add(prat);
                }
                reader.Close();

            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
            return listePra;
        }

        public void InsérerConge(Conge conge, Label lbl, Practicien prat)
        {
            try
            {
                if(prat.solde_conge < (decimal)(conge.date_fin - conge.date_debut).TotalDays)
                {
                    lbl.Text = "Vous n'avez pas assez de jours de congé.";
                    lbl.ForeColor = System.Drawing.Color.Red;
                    lbl.Visible = true;
                    return;
                }
                string requete = "INSERT INTO congé (id_praticien, date_debut, date_fin, état) VALUES (@id_praticien, @date_debut, @date_fin, 1)";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id_praticien", conge.id_praticien);
                cmd.Parameters.AddWithValue("@date_debut", conge.date_debut);
                cmd.Parameters.AddWithValue("@date_fin", conge.date_fin);
                cmd.Parameters.AddWithValue("@état", conge.etat);
                cmd.ExecuteNonQuery();
                lbl.Text = "Demande de congé envoyée !";
                lbl.ForeColor = System.Drawing.Color.Green;
                lbl.Visible = true;
            }
            catch (Exception ex)
            {

                lbl.Text = "Erreur lors de l'envoi de la demande de congé.";
                lbl.ForeColor = System.Drawing.Color.Red;
                lbl.Visible = true;
            }
        }

        public void AcceptéCongé(Conge conge)
        {
            try
            {
                string requete = "UPDATE congé SET état = 2 WHERE id = @id";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id", conge.id);
                cmd.ExecuteNonQuery();

            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
        }

        public void RefuséCongé(Conge conge)
        {
            try
            {
                string requete = "UPDATE congé SET état = 3 WHERE id = @id";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id", conge.id);
                cmd.ExecuteNonQuery();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
        }

        public void MarquerCommeLu(int idNotification)
        {
            try
            {
                string requete = "UPDATE notification SET id_etat = 1 WHERE id_notif = @id";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id", idNotification);
                cmd.ExecuteNonQuery();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }
        }

        public void AfficherMessage(int idp)
        {
            try
            {
                string requete = "SELECT id_notif, message FROM notification WHERE id_receveur = @id AND id_etat = 2";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id", idp);

                using (MySqlDataReader reader = cmd.ExecuteReader())
                {
                    while (reader.Read())
                    {
                        string message = reader["message"].ToString();
                        int idNotification = Convert.ToInt32(reader["id_notif"]);

                        if (!string.IsNullOrEmpty(message))
                        {
                            DialogResult result = MessageBox.Show(
                                message,
                                "Message du RH",
                                MessageBoxButtons.OK,
                                MessageBoxIcon.Information
                            );

                            if (result == DialogResult.OK)
                            {
                                reader.Close();
                                MarquerCommeLu(idNotification);

                                AfficherMessage(idp);
                                break;
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
            }

        }

        public Practicien ChargerPraticienrByid(int id)
        {
            Practicien prat = null;
            try
            {
                string requete = "SELECT * FROM praticien WHERE id = @id";
                MySqlCommand cmd = new MySqlCommand(requete, connection);
                cmd.Parameters.AddWithValue("@id", id);
                MySqlDataReader reader = cmd.ExecuteReader();
                if (reader.Read())
                {
                    int id_prat = Convert.ToInt32(reader["id"]);
                    string nom = reader["nom"].ToString();
                    string prenom = reader["prenom"].ToString();
                    int id_ville = Convert.ToInt32(reader["id_ville"]);
                    decimal solde_conge = Convert.ToDecimal(reader["solde_congé"]);
                    prat = new Practicien(id_prat, nom, prenom, id_ville, solde_conge);
                }
                reader.Close();
                return prat;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Erreur : " + ex.Message);
                return prat;
            }
        }
    }
}
