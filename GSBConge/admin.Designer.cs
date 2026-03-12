namespace GSBConge
{
    partial class admin
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
            accepte = new Button();
            refuse = new Button();
            lvadmin = new ListView();
            button1 = new Button();
            SuspendLayout();
            // 
            // accepte
            // 
            accepte.Font = new Font("Segoe UI", 15F);
            accepte.Location = new Point(653, 93);
            accepte.Name = "accepte";
            accepte.Size = new Size(183, 45);
            accepte.TabIndex = 1;
            accepte.Text = "Accepté";
            accepte.UseVisualStyleBackColor = true;
            accepte.Click += accepte_Click;
            // 
            // refuse
            // 
            refuse.Font = new Font("Segoe UI", 15F);
            refuse.Location = new Point(653, 211);
            refuse.Name = "refuse";
            refuse.Size = new Size(183, 49);
            refuse.TabIndex = 2;
            refuse.Text = "Refusé";
            refuse.UseVisualStyleBackColor = true;
            refuse.Click += refuse_Click;
            // 
            // lvadmin
            // 
            lvadmin.BackColor = SystemColors.ButtonHighlight;
            lvadmin.FullRowSelect = true;
            lvadmin.Location = new Point(30, 77);
            lvadmin.Name = "lvadmin";
            lvadmin.Size = new Size(561, 292);
            lvadmin.TabIndex = 3;
            lvadmin.UseCompatibleStateImageBehavior = false;
            // 
            // button1
            // 
            button1.Font = new Font("Segoe UI", 15F);
            button1.Location = new Point(651, 325);
            button1.Name = "button1";
            button1.Size = new Size(185, 44);
            button1.TabIndex = 4;
            button1.Text = "Quitter";
            button1.UseVisualStyleBackColor = true;
            button1.Click += button1_Click;
            // 
            // admin
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.GradientActiveCaption;
            ClientSize = new Size(901, 495);
            Controls.Add(button1);
            Controls.Add(lvadmin);
            Controls.Add(refuse);
            Controls.Add(accepte);
            Name = "admin";
            Text = "Form1";
            Load += admin_Load;
            Leave += admin_Leave;
            ResumeLayout(false);
        }

        #endregion
        private Button accepte;
        private Button refuse;
        private ListView lvadmin;
        private Button button1;
    }
}