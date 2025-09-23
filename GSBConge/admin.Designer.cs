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
            SuspendLayout();
            // 
            // accepte
            // 
            accepte.Location = new Point(653, 146);
            accepte.Name = "accepte";
            accepte.Size = new Size(114, 23);
            accepte.TabIndex = 1;
            accepte.Text = "Accepté";
            accepte.UseVisualStyleBackColor = true;
            // 
            // refuse
            // 
            refuse.Location = new Point(653, 230);
            refuse.Name = "refuse";
            refuse.Size = new Size(114, 23);
            refuse.TabIndex = 2;
            refuse.Text = "Refusé";
            refuse.UseVisualStyleBackColor = true;
            // 
            // admin
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(800, 450);
            Controls.Add(refuse);
            Controls.Add(accepte);
            Name = "admin";
            Text = "Form1";
            ResumeLayout(false);
        }

        #endregion
        private Button accepte;
        private Button refuse;
    }
}