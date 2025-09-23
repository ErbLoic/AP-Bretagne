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
        }

        private void connecter_Click(object sender, EventArgs e)
        {
            string email=mail.Text;
            string modp=mdp.Text;
            connexion.SeConnecter(this,email, modp);
            
        }
    }
}
