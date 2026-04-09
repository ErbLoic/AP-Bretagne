using GSBConge.modele;

namespace TestUnitaire;

[TestClass]
public class PracticienTests
{
    // --- Constructeur ---

    [TestMethod]
    public void Constructeur_InitialiseCorrectementLesProprietés()
    {
        var p = new Practicien(1, "Dupont", "Jean", 5, 25.5m);

        Assert.AreEqual(1, p.id);
        Assert.AreEqual("Dupont", p.nom);
        Assert.AreEqual("Jean", p.prenom);
        Assert.AreEqual(5, p.id_ville);
        Assert.AreEqual(25.5m, p.solde_conge);
    }

    [TestMethod]
    public void Constructeur_SoldeCongeZero_EstValide()
    {
        var p = new Practicien(2, "Martin", "Paul", 3, 0m);

        Assert.AreEqual(0m, p.solde_conge);
    }

    // --- ToString ---

    [TestMethod]
    public void ToString_RetourneFormatAttendu()
    {
        var p = new Practicien(7, "Dupont", "Jean", 1, 10m);

        Assert.AreEqual("Jean Dupont (ID: 7)", p.ToString());
    }

    [TestMethod]
    public void ToString_AvecPrenomEtNomDifferents_RetourneFormatCorrect()
    {
        var p = new Practicien(42, "Bernard", "Marie", 2, 5m);

        Assert.AreEqual("Marie Bernard (ID: 42)", p.ToString());
    }

    // --- Propriétés modifiables ---

    [TestMethod]
    public void SoldeConge_PeutEtreMisAJour()
    {
        var p = new Practicien(1, "Dupont", "Jean", 1, 20m);

        p.solde_conge = 15m;

        Assert.AreEqual(15m, p.solde_conge);
    }

    [TestMethod]
    public void Nom_PeutEtreMisAJour()
    {
        var p = new Practicien(1, "Dupont", "Jean", 1, 20m);

        p.nom = "Martin";

        Assert.AreEqual("Martin", p.nom);
    }
}

[TestClass]
public class CongeTests
{
    private Practicien _practicien = null!;

    [TestInitialize]
    public void Init()
    {
        _practicien = new Practicien(1, "Dupont", "Jean", 3, 30m);
    }

    // --- Constructeur ---

    [TestMethod]
    public void Constructeur_InitialiseCorrectementLesProprietés()
    {
        var debut = new DateTime(2025, 6, 1);
        var fin   = new DateTime(2025, 6, 10);

        var c = new Conge(1, 1, debut, fin, "1");

        Assert.AreEqual(1, c.id);
        Assert.AreEqual(1, c.id_praticien);
        Assert.AreEqual(debut, c.date_debut);
        Assert.AreEqual(fin, c.date_fin);
        Assert.AreEqual("1", c.etat);
    }

    [TestMethod]
    public void Constructeur_PraticienEstNullParDefaut()
    {
        var c = new Conge(1, 1, DateTime.Today, DateTime.Today.AddDays(5), "1");

        Assert.IsNull(c.praticien);
    }

    // --- AddPraticien ---

    [TestMethod]
    public void AddPraticien_AssocieCorrectementLePraticien()
    {
        var c = new Conge(1, 1, DateTime.Today, DateTime.Today.AddDays(3), "1");

        c.AddPraticien(_practicien);

        Assert.AreEqual(_practicien, c.praticien);
    }

    [TestMethod]
    public void AddPraticien_IdPraticienCorrespondAuPraticienAssocie()
    {
        var c = new Conge(5, 1, DateTime.Today, DateTime.Today.AddDays(2), "1");

        c.AddPraticien(_practicien);

        Assert.AreEqual(c.id_praticien, c.praticien.id);
    }

    [TestMethod]
    public void AddPraticien_PeutRemplacerUnPraticienExistant()
    {
        var c = new Conge(1, 2, DateTime.Today, DateTime.Today.AddDays(5), "1");
        var autre = new Practicien(2, "Martin", "Paul", 4, 10m);
        c.AddPraticien(_practicien);

        c.AddPraticien(autre);

        Assert.AreEqual(autre, c.praticien);
    }

    // --- Etat ---

    [TestMethod]
    public void Etat_EnAttente_EstEgalA1()
    {
        var c = new Conge(1, 1, DateTime.Today, DateTime.Today.AddDays(3), "1");

        Assert.AreEqual("1", c.etat);
    }

    [TestMethod]
    public void Etat_PeutPasserAAccepte()
    {
        var c = new Conge(1, 1, DateTime.Today, DateTime.Today.AddDays(3), "1");

        c.etat = "2";

        Assert.AreEqual("2", c.etat);
    }

    [TestMethod]
    public void Etat_PeutPasserARefuse()
    {
        var c = new Conge(1, 1, DateTime.Today, DateTime.Today.AddDays(3), "1");

        c.etat = "3";

        Assert.AreEqual("3", c.etat);
    }

    // --- Dates ---

    [TestMethod]
    public void Dates_DateFinApresDateDebut_Valide()
    {
        var debut = new DateTime(2025, 7, 1);
        var fin   = new DateTime(2025, 7, 10);

        var c = new Conge(1, 1, debut, fin, "1");

        Assert.IsTrue(c.date_fin > c.date_debut);
    }

    [TestMethod]
    public void Dates_DureeConge_EstCorrecte()
    {
        var debut = new DateTime(2025, 8, 1);
        var fin   = new DateTime(2025, 8, 6);

        var c = new Conge(1, 1, debut, fin, "1");

        int duree = (c.date_fin - c.date_debut).Days;
        Assert.AreEqual(5, duree);
    }

    [TestMethod]
    public void Dates_DateDebutEtFinIdentiques_DureeEstZero()
    {
        var date = new DateTime(2025, 9, 15);

        var c = new Conge(1, 1, date, date, "1");

        Assert.AreEqual(0, (c.date_fin - c.date_debut).Days);
    }
}
