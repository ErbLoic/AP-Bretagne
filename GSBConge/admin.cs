using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
<<<<<<< HEAD
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
=======
using System.Security.Cryptography.X509Certificates;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using GSBConge.modele;
>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a

namespace GSBConge
{
    public partial class admin : Form
    {
<<<<<<< HEAD
        public admin()
        {
            InitializeComponent();
        }
=======
        public BDD bdd;
        public Connexion_form form_conn;
        public List<Conge> listeConge;
        public admin(Connexion_form conn)
        {
            this.form_conn = conn;
            InitializeComponent();
        }

        private void admin_Load(object sender, EventArgs e)
        {
            bdd = new BDD("AP", "APSIO2", "172.23.48.2", "gsb");
            bdd.Connecter();
            listeConge = bdd.ChargerConge();
            lvadmin.View = View.Details;
            lvadmin.Columns.Add("ID",100);
            lvadmin.Columns.Add("Nom",120);
            lvadmin.Columns.Add("Prénom",120);
            lvadmin.Columns.Add("Date Début", 110);
            lvadmin.Columns.Add("Date Fin", 110);

            foreach (Conge con in listeConge)
            {
                if (con.etat == "1")
                {
                    var item = new ListViewItem(con.id.ToString());
                    item.SubItems.Add(con.praticien.nom);
                    item.SubItems.Add(con.praticien.prenom);
                    item.SubItems.Add(con.date_debut.ToString("yyyy-MM-dd"));
                    item.SubItems.Add(con.date_fin.ToString("yyyy-MM-dd"));
                    lvadmin.Items.Add(item);
                }
            }
            StyliserBouton(this.accepte);
            StyliserBouton(this.refuse);
            StyliserBouton(this.button1);

        }

        private void admin_Leave(object sender, EventArgs e)
        {
            this.form_conn.Show();
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            this.form_conn.Show();
            this.Close();
        }

        private void accepte_Click(object sender, EventArgs e)
        {
            if (lvadmin.FocusedItem == null)
            {
                MessageBox.Show("⚠️ Veuillez sélectionner un congé avant d'accepter.");
                return;
            }

            int index = lvadmin.FocusedItem.Index;


            // ✅ Vérifie que l'index est valide
            if (index < 0 || index >= listeConge.Count)
            {
                MessageBox.Show("Erreur : l'index sélectionné est invalide.");
                return;
            }

            Conge con = listeConge[index];
            bdd.AcceptéCongé(con);
            lvadmin.FocusedItem.BackColor = Color.Green;
        }

        private void refuse_Click(object sender, EventArgs e)
        {
            if (lvadmin.FocusedItem == null)
            {
                MessageBox.Show("⚠️ Veuillez sélectionner un congé avant de refuser.");
                return;
            }

            int index = lvadmin.FocusedItem.Index;


            if (index < 0 || index >= listeConge.Count)
            {
                MessageBox.Show("Erreur : l'index sélectionné est invalide.");
                return;
            }

            Conge con = listeConge[index];
            bdd.RefuséCongé(con);
            lvadmin.FocusedItem.BackColor = Color.Red;
        }


        private void StyliserBouton(Button btn)
        {
            btn.FlatStyle = FlatStyle.Flat;
            btn.FlatAppearance.BorderSize = 0;
            btn.FlatAppearance.BorderColor = Color.FromArgb(0, 122, 204);
            btn.FlatAppearance.MouseOverBackColor = Color.FromArgb(230, 240, 255);
            btn.FlatAppearance.MouseDownBackColor = Color.FromArgb(0, 122, 204);
            btn.BackColor = Color.White;
            btn.ForeColor = Color.Black;
            btn.Font = new Font("Segoe UI", 10, FontStyle.Bold);
        }

        

>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a
    }
}
