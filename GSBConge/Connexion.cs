namespace GSBConge
{
    public partial class Connexion : Form
    {
        public Connexion()
        {
            InitializeComponent();
        }

        private void Connexion_Load(object sender, EventArgs e)
        {
            BDD connexion = new BDD("AP","APSIO2","172.23.48.2","gsb");
            connexion.Connecter();
        }
    }
}
