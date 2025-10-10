using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using GSBConge.modele;

namespace GSBConge
{
    public partial class User : Form
    {
        public int idprat { get; set; }
        public BDD bdd;
        public Connexion_form form_conn;
        Practicien praticien;
        public User(int idprat, Connexion_form conn)
        {
            bdd = new BDD("AP", "APSIO2", "172.23.48.2", "gsb");
            bdd.Connecter();
            this.idprat = idprat;
            praticien = bdd.ChargerPraticienrByid(idprat);
            this.form_conn = conn;
            bdd.AfficherMessage(idprat);
            InitializeComponent();
        }

        private void User_Leave(object sender, EventArgs e)
        {
            Connexion_form connexion_Form = new Connexion_form();
            connexion_Form.Show();
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            DateTime dateDebut = dateTimePicker1.Value;
            DateTime dateFin = dateTimePicker2.Value;
            Conge conge = new Conge(0, idprat, dateDebut, dateFin, "1");
            bdd.InsérerConge(conge, label3,praticien);
            praticien = bdd.ChargerPraticienrByid(this.idprat);
            this.solde.Text = "Solde: " + Convert.ToString(this.praticien.solde_conge) + " jours";
        }

        private void User_Load(object sender, EventArgs e)
        {
            this.solde.Text ="Solde: "+Convert.ToString(this.praticien.solde_conge)+" jours";
        }

        private void button1_Click_1(object sender, EventArgs e)
        {
            this.form_conn.Show();
            this.Close();
        }
    }
}
