namespace GSBConge
{
    public partial class Connexion_form : Form
    {
        public Connexion_form()
        {
            InitializeComponent();
        }

        BDD connexion;

        private void Connexion_Load(object sender, EventArgs e)
        {
            connexion = new BDD("AP", "APSIO2", "172.23.48.2", "gsb");
            connexion.Connecter();
            StyliserBouton(this.connecter);
        }

        private void connecter_Click(object sender, EventArgs e)
        {
            string email=mail.Text;
            string modp=mdp.Text;
            connexion.SeConnecter(this,email, modp);
            
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
            btn.Font = new Font("Segoe UI", 14, FontStyle.Bold);
        }

    }
}
