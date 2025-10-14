<<<<<<< HEAD
﻿namespace GSBConge
{
    partial class Connexion_form
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            label1 = new Label();
            label2 = new Label();
            mail = new TextBox();
            mdp = new TextBox();
            connecter = new Button();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(27, 14);
            label1.Name = "label1";
            label1.Size = new Size(74, 15);
            label1.TabIndex = 0;
            label1.Text = "Adresse Mail";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Location = new Point(291, 14);
            label2.Name = "label2";
            label2.Size = new Size(77, 15);
            label2.TabIndex = 1;
            label2.Text = "Mot de passe";
            // 
            // mail
            // 
            mail.Location = new Point(19, 29);
            mail.Name = "mail";
            mail.Size = new Size(199, 23);
            mail.TabIndex = 2;
            // 
            // mdp
            // 
            mdp.Location = new Point(271, 31);
            mdp.Name = "mdp";
            mdp.PasswordChar = '*';
            mdp.Size = new Size(208, 23);
            mdp.TabIndex = 3;
            // 
            // connecter
            // 
            connecter.Location = new Point(152, 80);
            connecter.Name = "connecter";
            connecter.Size = new Size(177, 28);
            connecter.TabIndex = 4;
            connecter.Text = "Connecter";
            connecter.UseVisualStyleBackColor = true;
            connecter.Click += connecter_Click;
            // 
            // Connexion_form
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(491, 131);
            Controls.Add(connecter);
            Controls.Add(mdp);
            Controls.Add(mail);
            Controls.Add(label2);
            Controls.Add(label1);
            Name = "Connexion_form";
            Text = "Connexion";
            Load += Connexion_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label label1;
        private Label label2;
        private TextBox mail;
        private TextBox mdp;
        private Button connecter;
    }
}
=======
﻿namespace GSBConge
{
    partial class Connexion_form
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            label1 = new Label();
            label2 = new Label();
            mail = new TextBox();
            mdp = new TextBox();
            connecter = new Button();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Font = new Font("Segoe UI", 15F);
            label1.Location = new Point(12, 14);
            label1.Name = "label1";
            label1.Size = new Size(123, 28);
            label1.TabIndex = 0;
            label1.Text = "Adresse Mail";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Font = new Font("Segoe UI", 15F);
            label2.Location = new Point(542, 14);
            label2.Name = "label2";
            label2.Size = new Size(129, 28);
            label2.TabIndex = 1;
            label2.Text = "Mot de passe";
            // 
            // mail
            // 
            mail.Font = new Font("Segoe UI", 15F);
            mail.Location = new Point(12, 43);
            mail.Name = "mail";
            mail.Size = new Size(361, 34);
            mail.TabIndex = 2;
            // 
            // mdp
            // 
            mdp.Font = new Font("Segoe UI", 15F);
            mdp.Location = new Point(542, 43);
            mdp.Name = "mdp";
            mdp.PasswordChar = '*';
            mdp.Size = new Size(276, 34);
            mdp.TabIndex = 3;
            // 
            // connecter
            // 
            connecter.Location = new Point(217, 124);
            connecter.Name = "connecter";
            connecter.Size = new Size(399, 50);
            connecter.TabIndex = 4;
            connecter.Text = "Connecter";
            connecter.UseVisualStyleBackColor = true;
            connecter.Click += connecter_Click;
            // 
            // Connexion_form
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.GradientActiveCaption;
            ClientSize = new Size(872, 204);
            Controls.Add(connecter);
            Controls.Add(mdp);
            Controls.Add(mail);
            Controls.Add(label2);
            Controls.Add(label1);
            Name = "Connexion_form";
            Text = "Connexion";
            Load += Connexion_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label label1;
        private Label label2;
        private TextBox mail;
        private TextBox mdp;
        private Button connecter;
    }
}
>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a
