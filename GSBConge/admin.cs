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
            StyliserListView(this.lvadmin);

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

        private void StyliserListView(ListView lv)
        {
            lv.BorderStyle = BorderStyle.None;
            lv.FullRowSelect = true;
            lv.GridLines = false;
            lv.HideSelection = false;
            lv.MultiSelect = false;
            lv.View = View.Details;
            lv.Font = new Font("Segoe UI", 10, FontStyle.Regular);
            lv.ForeColor = Color.FromArgb(40, 40, 40);
            lv.BackColor = Color.FromArgb(245, 245, 250);
            lv.HeaderStyle = ColumnHeaderStyle.Nonclickable;
            lv.OwnerDraw = true; // permet de personnaliser le rendu

            // Style des en-têtes
            lv.DrawColumnHeader += (s, e) =>
            {
                using (SolidBrush backBrush = new SolidBrush(Color.FromArgb(230, 230, 240)))
                using (Pen borderPen = new Pen(Color.FromArgb(210, 210, 220)))
                {
                    e.Graphics.FillRectangle(backBrush, e.Bounds);
                    e.Graphics.DrawLine(borderPen, e.Bounds.Left, e.Bounds.Bottom - 1, e.Bounds.Right, e.Bounds.Bottom - 1);
                    TextRenderer.DrawText(e.Graphics, e.Header.Text, lv.Font, e.Bounds, Color.FromArgb(60, 60, 70), TextFormatFlags.Left | TextFormatFlags.VerticalCenter);
                }
            };

            // Style des items
            lv.DrawItem += (s, e) => { /* vide, mais nécessaire pour DrawSubItem */ };

            // Style des sous-éléments (le texte)
            lv.DrawSubItem += (s, e) =>
            {
                bool isSelected = (e.ItemState & ListViewItemStates.Selected) != 0;
                Color backColor = isSelected ? Color.FromArgb(0, 120, 215) : lv.BackColor;
                Color textColor = isSelected ? Color.White : lv.ForeColor;

                e.Graphics.FillRectangle(new SolidBrush(backColor), e.Bounds);
                TextRenderer.DrawText(e.Graphics, e.SubItem.Text, lv.Font, e.Bounds, textColor, TextFormatFlags.Left | TextFormatFlags.VerticalCenter);
            };
        }

    }
}
