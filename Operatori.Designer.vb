<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Operatori
    Inherits Gizmox.WebGUI.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Visual WebGui Designer
    Private Shadows components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Visual WebGui Designer
    'It can be modified using the Visual webGui Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Operatori))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.cmdIndietro = New Gizmox.WebGUI.Forms.Button()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdEnableOperators = New Gizmox.WebGUI.Forms.Button()
        Me.cmdDisableOperators = New Gizmox.WebGUI.Forms.Button()
        Me.cboConsultazioni = New Gizmox.WebGUI.Forms.ComboBox()
        Me.cmdCheckLogin = New Gizmox.WebGUI.Forms.Button()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.cmdCopiaPermessi = New Gizmox.WebGUI.Forms.Button()
        Me.cmdCopiaCorpoElettorale = New Gizmox.WebGUI.Forms.Button()
        Me.cboConsultazioniDestinazione = New Gizmox.WebGUI.Forms.ComboBox()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.White
        Me.Panel1.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.Silver)
        Me.Panel1.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Inset
        Me.Panel1.Controls.Add(Me.Label8)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = Gizmox.WebGUI.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(906, 90)
        Me.Panel1.TabIndex = 1
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(671, 64)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(225, 25)
        Me.Label8.TabIndex = 0
        Me.Label8.Text = "COMUNE DI COSENZA"
        Me.Label8.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'PictureBox1
        '
        Me.PictureBox1.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.PictureBox1.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle(resources.GetString("PictureBox1.Image"))
        Me.PictureBox1.Location = New System.Drawing.Point(836, 3)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(45, 56)
        Me.PictureBox1.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.AutoSize
        Me.PictureBox1.TabIndex = 2
        Me.PictureBox1.TabStop = False
        '
        'Label3
        '
        Me.Label3.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(48, 44)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(577, 37)
        Me.Label3.TabIndex = 1
        Me.Label3.Text = "Modulo software per la gestione delle comunicazioni dei dati elettorali dalle sed" & _
    "i periferiche alla server-farm. Gestione dello spoglio elettorale e comunicazion" & _
    "e dei dati agli enti di controllo..."
        '
        'Label1
        '
        Me.Label1.Font = New System.Drawing.Font("Tahoma", 24.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(12, 9)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(430, 35)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "EAP - Elezioni Online"
        '
        'cmdLogout
        '
        Me.cmdLogout.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdLogout.BackColor = System.Drawing.Color.Ivory
        Me.cmdLogout.CustomStyle = "F"
        Me.cmdLogout.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdLogout.Location = New System.Drawing.Point(759, 473)
        Me.cmdLogout.Name = "cmdLogout"
        Me.cmdLogout.Size = New System.Drawing.Size(135, 23)
        Me.cmdLogout.TabIndex = 4
        Me.cmdLogout.Text = "Disconnetti (Esci)"
        '
        'cmdIndietro
        '
        Me.cmdIndietro.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdIndietro.BackColor = System.Drawing.Color.Ivory
        Me.cmdIndietro.CustomStyle = "F"
        Me.cmdIndietro.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdIndietro.Location = New System.Drawing.Point(631, 473)
        Me.cmdIndietro.Name = "cmdIndietro"
        Me.cmdIndietro.Size = New System.Drawing.Size(122, 23)
        Me.cmdIndietro.TabIndex = 4
        Me.cmdIndietro.Text = "<< Indietro"
        '
        'Label2
        '
        Me.Label2.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label2.BackColor = System.Drawing.Color.RoyalBlue
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(704, 93)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(198, 25)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "STATO OPERATORI"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label4
        '
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(4, 95)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(100, 23)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Consultazione"
        '
        'cmdEnableOperators
        '
        Me.cmdEnableOperators.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdEnableOperators.BackColor = System.Drawing.Color.Beige
        Me.cmdEnableOperators.CustomStyle = "F"
        Me.cmdEnableOperators.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdEnableOperators.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdEnableOperators.Location = New System.Drawing.Point(276, 149)
        Me.cmdEnableOperators.Name = "cmdEnableOperators"
        Me.cmdEnableOperators.Size = New System.Drawing.Size(299, 43)
        Me.cmdEnableOperators.TabIndex = 3
        Me.cmdEnableOperators.Text = "Abilita Operatori"
        '
        'cmdDisableOperators
        '
        Me.cmdDisableOperators.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdDisableOperators.BackColor = System.Drawing.Color.Beige
        Me.cmdDisableOperators.CustomStyle = "F"
        Me.cmdDisableOperators.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdDisableOperators.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdDisableOperators.Location = New System.Drawing.Point(276, 218)
        Me.cmdDisableOperators.Name = "cmdDisableOperators"
        Me.cmdDisableOperators.Size = New System.Drawing.Size(299, 43)
        Me.cmdDisableOperators.TabIndex = 3
        Me.cmdDisableOperators.Text = "Disabilita Operatori"
        '
        'cboConsultazioni
        '
        Me.cboConsultazioni.AllowDrag = False
        Me.cboConsultazioni.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboConsultazioni.Location = New System.Drawing.Point(110, 96)
        Me.cboConsultazioni.Name = "cboConsultazioni"
        Me.cboConsultazioni.Size = New System.Drawing.Size(256, 21)
        Me.cboConsultazioni.TabIndex = 8
        '
        'cmdCheckLogin
        '
        Me.cmdCheckLogin.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdCheckLogin.BackColor = System.Drawing.Color.Beige
        Me.cmdCheckLogin.CustomStyle = "F"
        Me.cmdCheckLogin.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdCheckLogin.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdCheckLogin.Location = New System.Drawing.Point(276, 287)
        Me.cmdCheckLogin.Name = "cmdEnableOperators"
        Me.cmdCheckLogin.Size = New System.Drawing.Size(299, 43)
        Me.cmdCheckLogin.TabIndex = 3
        Me.cmdCheckLogin.Text = "Check Insediamento Sedi"
        '
        'Label10
        '
        Me.Label10.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label10.Location = New System.Drawing.Point(4, 26)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(800, 18)
        Me.Label10.TabIndex = 1
        Me.Label10.Text = "Ing. Pasquale Iaquinta, Dott.ssa Tina De Simone, Alessandro Iaquinta (Matrixse)"
        '
        'Label9
        '
        Me.Label9.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label9.Location = New System.Drawing.Point(3, 9)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(452, 17)
        Me.Label9.TabIndex = 1
        Me.Label9.Text = "Realizzato da: ESD - con la collaborazione di MatrixSE"
        '
        'Panel2
        '
        Me.Panel2.BackColor = System.Drawing.Color.Lavender
        Me.Panel2.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.Panel2.Controls.Add(Me.Label10)
        Me.Panel2.Controls.Add(Me.Label9)
        Me.Panel2.Dock = Gizmox.WebGUI.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 502)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(906, 46)
        Me.Panel2.TabIndex = 1
        '
        'cmdCopiaPermessi
        '
        Me.cmdCopiaPermessi.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdCopiaPermessi.BackColor = System.Drawing.Color.Beige
        Me.cmdCopiaPermessi.CustomStyle = "F"
        Me.cmdCopiaPermessi.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdCopiaPermessi.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdCopiaPermessi.Location = New System.Drawing.Point(276, 356)
        Me.cmdCopiaPermessi.Name = "cmdCopiaPermessi"
        Me.cmdCopiaPermessi.Size = New System.Drawing.Size(299, 43)
        Me.cmdCopiaPermessi.TabIndex = 3
        Me.cmdCopiaPermessi.Text = "Copia Permessi"
        Me.cmdCopiaPermessi.Visible = False
        '
        'cmdCopiaCorpoElettorale
        '
        Me.cmdCopiaCorpoElettorale.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdCopiaCorpoElettorale.BackColor = System.Drawing.Color.Beige
        Me.cmdCopiaCorpoElettorale.CustomStyle = "F"
        Me.cmdCopiaCorpoElettorale.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdCopiaCorpoElettorale.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdCopiaCorpoElettorale.Location = New System.Drawing.Point(276, 425)
        Me.cmdCopiaCorpoElettorale.Name = "cmdCopiaCorpoElettorale"
        Me.cmdCopiaCorpoElettorale.Size = New System.Drawing.Size(299, 43)
        Me.cmdCopiaCorpoElettorale.TabIndex = 3
        Me.cmdCopiaCorpoElettorale.Text = "Copia Corpo Elettorale"
        Me.cmdCopiaCorpoElettorale.Visible = False
        '
        'cboConsultazioniDestinazione
        '
        Me.cboConsultazioniDestinazione.AllowDrag = False
        Me.cboConsultazioniDestinazione.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cboConsultazioniDestinazione.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboConsultazioniDestinazione.Location = New System.Drawing.Point(631, 409)
        Me.cboConsultazioniDestinazione.Name = "cboConsultazioniDestinazione"
        Me.cboConsultazioniDestinazione.Size = New System.Drawing.Size(256, 21)
        Me.cboConsultazioniDestinazione.TabIndex = 8
        '
        'Label5
        '
        Me.Label5.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(628, 370)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(259, 39)
        Me.Label5.TabIndex = 6
        Me.Label5.Text = "Consultazione di destinazione (valida per copia permessi/corpo elettorale)"
        '
        'Operatori
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.cboConsultazioniDestinazione)
        Me.Controls.Add(Me.cmdCopiaCorpoElettorale)
        Me.Controls.Add(Me.cmdCopiaPermessi)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.cmdCheckLogin)
        Me.Controls.Add(Me.cboConsultazioni)
        Me.Controls.Add(Me.cmdDisableOperators)
        Me.Controls.Add(Me.cmdEnableOperators)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.cmdIndietro)
        Me.Controls.Add(Me.cmdLogout)
        Me.Controls.Add(Me.Panel1)
        Me.FormBorderStyle = Gizmox.WebGUI.Forms.FormBorderStyle.Sizable
        Me.Size = New System.Drawing.Size(906, 548)
        Me.Text = "EAP - Elezioni OnLine - Homepage"
        Me.Panel1.ResumeLayout(False)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdLogout As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdIndietro As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdEnableOperators As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdDisableOperators As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cboConsultazioni As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents cmdCheckLogin As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents cmdCopiaPermessi As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdCopiaCorpoElettorale As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cboConsultazioniDestinazione As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label

End Class