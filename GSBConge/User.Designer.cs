namespace GSBConge
{
    partial class User
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
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
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            dateTimePicker1 = new DateTimePicker();
            dateTimePicker2 = new DateTimePicker();
            label1 = new Label();
            label2 = new Label();
            btnValidC = new Button();
            label3 = new Label();
            button1 = new Button();
            solde = new Label();
            SuspendLayout();
            // 
            // dateTimePicker1
            // 
            dateTimePicker1.Location = new Point(58, 37);
            dateTimePicker1.Name = "dateTimePicker1";
            dateTimePicker1.Size = new Size(197, 23);
            dateTimePicker1.TabIndex = 0;
            // 
            // dateTimePicker2
            // 
            dateTimePicker2.Location = new Point(382, 37);
            dateTimePicker2.Name = "dateTimePicker2";
            dateTimePicker2.Size = new Size(197, 23);
            dateTimePicker2.TabIndex = 1;
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(58, 19);
            label1.Name = "label1";
            label1.Size = new Size(65, 15);
            label1.TabIndex = 2;
            label1.Text = "Date début";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Location = new Point(382, 19);
            label2.Name = "label2";
            label2.Size = new Size(48, 15);
            label2.TabIndex = 3;
            label2.Text = "Date fin";
            // 
            // btnValidC
            // 
            btnValidC.Location = new Point(250, 101);
            btnValidC.Name = "btnValidC";
            btnValidC.Size = new Size(124, 27);
            btnValidC.TabIndex = 4;
            btnValidC.Text = "Valider";
            btnValidC.UseVisualStyleBackColor = true;
            btnValidC.Click += button1_Click;
            // 
            // label3
            // 
            label3.AutoSize = true;
            label3.Location = new Point(254, 141);
            label3.Name = "label3";
            label3.Size = new Size(38, 15);
            label3.TabIndex = 5;
            label3.Text = "label3";
            label3.Visible = false;
            // 
            // button1
            // 
            button1.Location = new Point(69, 187);
            button1.Name = "button1";
            button1.Size = new Size(140, 22);
            button1.TabIndex = 6;
            button1.Text = "Quitter";
            button1.UseVisualStyleBackColor = true;
            button1.Click += button1_Click_1;
            // 
            // solde
            // 
            solde.AutoSize = true;
            solde.Location = new Point(487, 191);
            solde.Name = "solde";
            solde.Size = new Size(38, 15);
            solde.TabIndex = 7;
            solde.Text = "label4";
            // 
            // User
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(659, 269);
            Controls.Add(solde);
            Controls.Add(button1);
            Controls.Add(label3);
            Controls.Add(btnValidC);
            Controls.Add(label2);
            Controls.Add(label1);
            Controls.Add(dateTimePicker2);
            Controls.Add(dateTimePicker1);
            Name = "User";
            Text = "Accueil";
            Load += User_Load;
            Leave += User_Leave;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private DateTimePicker dateTimePicker1;
        private DateTimePicker dateTimePicker2;
        private Label label1;
        private Label label2;
        private Button btnValidC;
        private Label label3;
        private Button button1;
        private Label solde;
    }
}