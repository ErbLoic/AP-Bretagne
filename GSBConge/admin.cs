using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Security.Cryptography.X509Certificates;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using GSBConge.modele;

namespace GSBConge
{
    public partial class admin : Form
    {
        public BDD bdd;
        public Connexion_form form_conn;
        public admin(Connexion_form conn)
        {
            this.form_conn = conn;
            InitializeComponent();
        }

        private void admin_Load(object sender, EventArgs e)
        {
            bdd = new BDD("AP", "APSIO2", "172.23.48.2", "gsb");
            bdd.Connecter();
            List<Conge> listeConge = bdd.ChargerConge();
            lvadmin.View = View.Details;
            lvadmin.Columns.Add("ID", 50);
            lvadmin.Columns.Add("ID Praticien", 100);
            lvadmin.Columns.Add("Date Début", 150);
            lvadmin.Columns.Add("Date Fin", 150);

            foreach (Conge con in listeConge)
            {
                if (con.etat == "1")
                {
                    var item = new ListViewItem(con.id.ToString());
                    item.SubItems.Add(con.id_praticien.ToString());
                    item.SubItems.Add(con.date_debut.ToString("yyyy-MM-dd"));
                    item.SubItems.Add(con.date_fin.ToString("yyyy-MM-dd"));
                    lvadmin.Items.Add(item);
                }
            }

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
            List<Conge> listeConge = bdd.ChargerConge();
            Conge con = listeConge[lvadmin.FocusedItem.Index];
            bdd.AcceptéCongé(con);
            lvadmin.FocusedItem.Remove();
        }
    }
}
