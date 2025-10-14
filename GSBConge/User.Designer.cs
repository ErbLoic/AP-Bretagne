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
<<<<<<< HEAD
            label1 = new Label();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(156, 103);
            label1.Name = "label1";
            label1.Size = new Size(29, 15);
            label1.TabIndex = 0;
            label1.Text = "user";
=======
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
            dateTimePicker1.CalendarMonthBackground = SystemColors.InactiveCaption;
            dateTimePicker1.Font = new Font("Segoe UI", 15F);
            dateTimePicker1.Location = new Point(58, 90);
            dateTimePicker1.MinDate = new DateTime(2025, 10, 10, 0, 0, 0, 0);
            dateTimePicker1.Name = "dateTimePicker1";
            dateTimePicker1.Size = new Size(299, 34);
            dateTimePicker1.TabIndex = 0;
            // 
            // dateTimePicker2
            // 
            dateTimePicker2.CalendarMonthBackground = SystemColors.InactiveCaption;
            dateTimePicker2.Font = new Font("Segoe UI", 15F);
            dateTimePicker2.Location = new Point(612, 90);
            dateTimePicker2.Name = "dateTimePicker2";
            dateTimePicker2.Size = new Size(303, 34);
            dateTimePicker2.TabIndex = 1;
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Font = new Font("Segoe UI", 15F);
            label1.Location = new Point(58, 46);
            label1.Name = "label1";
            label1.Size = new Size(110, 28);
            label1.TabIndex = 2;
            label1.Text = "Date début";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Font = new Font("Segoe UI", 15F);
            label2.Location = new Point(612, 46);
            label2.Name = "label2";
            label2.Size = new Size(80, 28);
            label2.TabIndex = 3;
            label2.Text = "Date fin";
            // 
            // btnValidC
            // 
            btnValidC.AutoSize = true;
            btnValidC.BackColor = SystemColors.ActiveCaption;
            btnValidC.Font = new Font("Segoe UI", 14F);
            btnValidC.ForeColor = SystemColors.ActiveCaptionText;
            btnValidC.Location = new Point(365, 152);
            btnValidC.Name = "btnValidC";
            btnValidC.Size = new Size(250, 53);
            btnValidC.TabIndex = 4;
            btnValidC.Text = "Valider";
            btnValidC.UseVisualStyleBackColor = false;
            btnValidC.Click += button1_Click;
            // 
            // label3
            // 
            label3.AutoSize = true;
            label3.Font = new Font("Segoe UI", 12F);
            label3.Location = new Point(365, 232);
            label3.Name = "label3";
            label3.Size = new Size(52, 21);
            label3.TabIndex = 5;
            label3.Text = "label3";
            label3.Visible = false;
            // 
            // button1
            // 
            button1.Font = new Font("Segoe UI", 15F);
            button1.Location = new Point(58, 308);
            button1.Name = "button1";
            button1.Size = new Size(220, 36);
            button1.TabIndex = 6;
            button1.Text = "Quitter";
            button1.UseVisualStyleBackColor = true;
            button1.Click += button1_Click_1;
            // 
            // solde
            // 
            solde.AutoSize = true;
            solde.Font = new Font("Segoe UI", 20F);
            solde.Location = new Point(677, 308);
            solde.Name = "solde";
            solde.Size = new Size(90, 37);
            solde.TabIndex = 7;
            solde.Text = "label4";
>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a
            // 
            // User
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
<<<<<<< HEAD
            ClientSize = new Size(800, 450);
            Controls.Add(label1);
            Name = "User";
            Text = "Accueil";
            Load += this.User_Load;
            Leave += this.User_Leave;
=======
            BackColor = SystemColors.GradientActiveCaption;
            ClientSize = new Size(950, 391);
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
>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

<<<<<<< HEAD
        private Label label1;
=======
        private DateTimePicker dateTimePicker1;
        private DateTimePicker dateTimePicker2;
        private Label label1;
        private Label label2;
        private Button btnValidC;
        private Label label3;
        private Button button1;
        private Label solde;
>>>>>>> ba95a9aa3d22d61a28078cf2880ac9e99b32a99a
    }
}