<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Scrutinio
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
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Scrutinio))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.lblSezioniValidate = New Gizmox.WebGUI.Forms.Label()
        Me.lblSezioniRilevate = New Gizmox.WebGUI.Forms.Label()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.cmdIndietro = New Gizmox.WebGUI.Forms.Button()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdAggiorna = New Gizmox.WebGUI.Forms.Button()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdScrutinioParziale = New Gizmox.WebGUI.Forms.Button()
        Me.lnkReports = New Gizmox.WebGUI.Forms.LinkLabel()
        Me.txtTotValidi = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotContestati = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotNulle = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotBianche = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label7 = New Gizmox.WebGUI.Forms.Label()
        Me.Label11 = New Gizmox.WebGUI.Forms.Label()
        Me.Label12 = New Gizmox.WebGUI.Forms.Label()
        Me.Label13 = New Gizmox.WebGUI.Forms.Label()
        Me.Label14 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotVotanti = New Gizmox.WebGUI.Forms.TextBox()
        Me.cmdPreferenzeCandidati = New Gizmox.WebGUI.Forms.Button()
        Me.txtVotantiM = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label15 = New Gizmox.WebGUI.Forms.Label()
        Me.txtVotantiF = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label16 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdScrutinioFinale = New Gizmox.WebGUI.Forms.Button()
        Me.cboConsultazioni = New Gizmox.WebGUI.Forms.ComboBox()
        Me.cboVisualizzazione = New Gizmox.WebGUI.Forms.ComboBox()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.grid = New Gizmox.WebGUI.Forms.DataGridView()
        Me.timerSync = New Gizmox.WebGUI.Forms.Timer(Me.components)
        Me.cmdPubblica = New Gizmox.WebGUI.Forms.Button()
        Me.lblMessage = New Gizmox.WebGUI.Forms.Label()
        Me.timerMessage = New Gizmox.WebGUI.Forms.Timer(Me.components)
        Me.Panel1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel2.SuspendLayout()
        CType(Me.grid, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.White
        Me.Panel1.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.Silver)
        Me.Panel1.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Inset
        Me.Panel1.Controls.Add(Me.lblSezioniValidate)
        Me.Panel1.Controls.Add(Me.lblSezioniRilevate)
        Me.Panel1.Controls.Add(Me.Label8)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = Gizmox.WebGUI.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(972, 90)
        Me.Panel1.TabIndex = 1
        '
        'lblSezioniValidate
        '
        Me.lblSezioniValidate.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezioniValidate.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniValidate.ForeColor = System.Drawing.Color.LimeGreen
        Me.lblSezioniValidate.Location = New System.Drawing.Point(630, 31)
        Me.lblSezioniValidate.Name = "lblSezioniValidate"
        Me.lblSezioniValidate.Size = New System.Drawing.Size(254, 22)
        Me.lblSezioniValidate.TabIndex = 0
        Me.lblSezioniValidate.Text = "Sezioni validate 0 su 82"
        Me.lblSezioniValidate.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'lblSezioniRilevate
        '
        Me.lblSezioniRilevate.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezioniRilevate.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniRilevate.ForeColor = System.Drawing.Color.Red
        Me.lblSezioniRilevate.Location = New System.Drawing.Point(630, 9)
        Me.lblSezioniRilevate.Name = "lblSezioniRilevate"
        Me.lblSezioniRilevate.Size = New System.Drawing.Size(254, 22)
        Me.lblSezioniRilevate.TabIndex = 0
        Me.lblSezioniRilevate.Text = "Sezioni rilevate 0 su 82"
        Me.lblSezioniRilevate.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(725, 64)
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
        Me.PictureBox1.Location = New System.Drawing.Point(890, 3)
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
        Me.cmdLogout.Location = New System.Drawing.Point(825, 498)
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
        Me.cmdIndietro.Location = New System.Drawing.Point(697, 498)
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
        Me.Label2.Location = New System.Drawing.Point(733, 93)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(235, 25)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "SPOGLIO ELETTORALE"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label4
        '
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(4, 95)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(87, 23)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Consultazione"
        '
        'cmdAggiorna
        '
        Me.cmdAggiorna.BackColor = System.Drawing.Color.Ivory
        Me.cmdAggiorna.CustomStyle = "F"
        Me.cmdAggiorna.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdAggiorna.Location = New System.Drawing.Point(319, 126)
        Me.cmdAggiorna.Name = "cmdAggiorna"
        Me.cmdAggiorna.Size = New System.Drawing.Size(85, 23)
        Me.cmdAggiorna.TabIndex = 4
        Me.cmdAggiorna.Text = "Aggiorna"
        '
        'Label5
        '
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(5, 126)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(67, 23)
        Me.Label5.TabIndex = 6
        Me.Label5.Text = "Visualizza"
        '
        'cmdScrutinioParziale
        '
        Me.cmdScrutinioParziale.BackColor = System.Drawing.Color.Ivory
        Me.cmdScrutinioParziale.CustomStyle = "F"
        Me.cmdScrutinioParziale.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdScrutinioParziale.Location = New System.Drawing.Point(421, 126)
        Me.cmdScrutinioParziale.Name = "cmdDownloadXLSEuropee"
        Me.cmdScrutinioParziale.Size = New System.Drawing.Size(115, 23)
        Me.cmdScrutinioParziale.TabIndex = 4
        Me.cmdScrutinioParziale.Text = "Scrutinio Parziale"
        '
        'lnkReports
        '
        Me.lnkReports.ClientMode = True
        Me.lnkReports.LinkColor = System.Drawing.Color.Blue
        Me.lnkReports.Location = New System.Drawing.Point(812, 129)
        Me.lnkReports.Name = "lnkReports"
        Me.lnkReports.Size = New System.Drawing.Size(81, 23)
        Me.lnkReports.TabIndex = 8
        Me.lnkReports.TabStop = True
        Me.lnkReports.Text = "Reports"
        '
        'txtTotValidi
        '
        Me.txtTotValidi.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotValidi.Location = New System.Drawing.Point(61, 498)
        Me.txtTotValidi.Name = "txtTotValidi"
        Me.txtTotValidi.Size = New System.Drawing.Size(55, 20)
        Me.txtTotValidi.TabIndex = 3
        '
        'txtTotContestati
        '
        Me.txtTotContestati.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotContestati.Location = New System.Drawing.Point(203, 498)
        Me.txtTotContestati.Name = "txtTotContestati"
        Me.txtTotContestati.Size = New System.Drawing.Size(55, 20)
        Me.txtTotContestati.TabIndex = 3
        '
        'txtTotNulle
        '
        Me.txtTotNulle.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotNulle.Location = New System.Drawing.Point(327, 497)
        Me.txtTotNulle.Name = "txtTotNulle"
        Me.txtTotNulle.Size = New System.Drawing.Size(55, 20)
        Me.txtTotNulle.TabIndex = 3
        '
        'txtTotBianche
        '
        Me.txtTotBianche.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotBianche.Location = New System.Drawing.Point(466, 498)
        Me.txtTotBianche.Name = "txtTotBianche"
        Me.txtTotBianche.Size = New System.Drawing.Size(55, 20)
        Me.txtTotBianche.TabIndex = 3
        '
        'Label7
        '
        Me.Label7.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label7.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.Location = New System.Drawing.Point(4, 498)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(42, 23)
        Me.Label7.TabIndex = 6
        Me.Label7.Text = "Validi"
        '
        'Label11
        '
        Me.Label11.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label11.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label11.Location = New System.Drawing.Point(130, 498)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(67, 23)
        Me.Label11.TabIndex = 6
        Me.Label11.Text = "Contestati"
        '
        'Label12
        '
        Me.Label12.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label12.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.Location = New System.Drawing.Point(264, 497)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(42, 23)
        Me.Label12.TabIndex = 6
        Me.Label12.Text = "Nulle"
        '
        'Label13
        '
        Me.Label13.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label13.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.Location = New System.Drawing.Point(394, 498)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(53, 23)
        Me.Label13.TabIndex = 6
        Me.Label13.Text = "Bianche"
        '
        'Label14
        '
        Me.Label14.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label14.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label14.Location = New System.Drawing.Point(2, 474)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(53, 23)
        Me.Label14.TabIndex = 6
        Me.Label14.Text = "Votanti"
        '
        'txtTotVotanti
        '
        Me.txtTotVotanti.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotVotanti.Location = New System.Drawing.Point(61, 474)
        Me.txtTotVotanti.Name = "txtTotVotanti"
        Me.txtTotVotanti.Size = New System.Drawing.Size(55, 20)
        Me.txtTotVotanti.TabIndex = 3
        '
        'cmdPreferenzeCandidati
        '
        Me.cmdPreferenzeCandidati.BackColor = System.Drawing.Color.Ivory
        Me.cmdPreferenzeCandidati.CustomStyle = "F"
        Me.cmdPreferenzeCandidati.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdPreferenzeCandidati.Location = New System.Drawing.Point(666, 126)
        Me.cmdPreferenzeCandidati.Name = "cmdDownloadXLS"
        Me.cmdPreferenzeCandidati.Size = New System.Drawing.Size(134, 23)
        Me.cmdPreferenzeCandidati.TabIndex = 4
        Me.cmdPreferenzeCandidati.Text = "Preferenze Candidati"
        '
        'txtVotantiM
        '
        Me.txtVotantiM.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtVotantiM.Location = New System.Drawing.Point(203, 474)
        Me.txtVotantiM.Name = "txtVotantiM"
        Me.txtVotantiM.Size = New System.Drawing.Size(55, 20)
        Me.txtVotantiM.TabIndex = 3
        '
        'Label15
        '
        Me.Label15.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label15.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label15.Location = New System.Drawing.Point(130, 474)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(53, 23)
        Me.Label15.TabIndex = 6
        Me.Label15.Text = "Maschi"
        '
        'txtVotantiF
        '
        Me.txtVotantiF.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtVotantiF.Location = New System.Drawing.Point(327, 474)
        Me.txtVotantiF.Name = "txtVotantiF"
        Me.txtVotantiF.Size = New System.Drawing.Size(55, 20)
        Me.txtVotantiF.TabIndex = 3
        '
        'Label16
        '
        Me.Label16.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label16.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label16.Location = New System.Drawing.Point(264, 474)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(62, 23)
        Me.Label16.TabIndex = 6
        Me.Label16.Text = "Femmine"
        '
        'cmdScrutinioFinale
        '
        Me.cmdScrutinioFinale.BackColor = System.Drawing.Color.Ivory
        Me.cmdScrutinioFinale.CustomStyle = "F"
        Me.cmdScrutinioFinale.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdScrutinioFinale.Location = New System.Drawing.Point(542, 126)
        Me.cmdScrutinioFinale.Name = "Button1"
        Me.cmdScrutinioFinale.Size = New System.Drawing.Size(115, 23)
        Me.cmdScrutinioFinale.TabIndex = 4
        Me.cmdScrutinioFinale.Text = "Scrutinio Finale"
        '
        'cboConsultazioni
        '
        Me.cboConsultazioni.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboConsultazioni.Location = New System.Drawing.Point(97, 97)
        Me.cboConsultazioni.Name = "cboConsultazioni"
        Me.cboConsultazioni.Size = New System.Drawing.Size(216, 21)
        Me.cboConsultazioni.TabIndex = 10
        '
        'cboVisualizzazione
        '
        Me.cboVisualizzazione.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboVisualizzazione.Location = New System.Drawing.Point(97, 126)
        Me.cboVisualizzazione.Name = "cboVisualizzazione"
        Me.cboVisualizzazione.Size = New System.Drawing.Size(216, 21)
        Me.cboVisualizzazione.TabIndex = 11
        '
        'Label10
        '
        Me.Label10.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label10.Location = New System.Drawing.Point(4, 26)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(800, 18)
        Me.Label10.TabIndex = 1
        Me.Label10.Text = "Ing. Pasquale Iaquinta, Ing. Miriam Iusi"
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
        Me.Panel2.Controls.Add(Me.lblMessage)
        Me.Panel2.Controls.Add(Me.Label10)
        Me.Panel2.Controls.Add(Me.Label9)
        Me.Panel2.Dock = Gizmox.WebGUI.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 527)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(972, 46)
        Me.Panel2.TabIndex = 1
        '
        'grid
        '
        Me.grid.AllowUserToAddRows = False
        Me.grid.AllowUserToDeleteRows = False
        Me.grid.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.grid.ColumnHeadersHeightSizeMode = Gizmox.WebGUI.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.grid.ItemsPerPage = 200
        Me.grid.Location = New System.Drawing.Point(5, 159)
        Me.grid.Name = "grid"
        Me.grid.ReadOnly = True
        Me.grid.RowTemplate.DefaultCellStyle.FormatProvider = New System.Globalization.CultureInfo("it-IT")
        Me.grid.Size = New System.Drawing.Size(955, 302)
        Me.grid.TabIndex = 12
        '
        'timerSync
        '
        Me.timerSync.Enabled = True
        Me.timerSync.Interval = 60000
        '
        'cmdPubblica
        '
        Me.cmdPubblica.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdPubblica.BackColor = System.Drawing.Color.Ivory
        Me.cmdPubblica.CustomStyle = "F"
        Me.cmdPubblica.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdPubblica.ForeColor = System.Drawing.Color.RoyalBlue
        Me.cmdPubblica.Location = New System.Drawing.Point(566, 498)
        Me.cmdPubblica.Name = "cmdPubblica"
        Me.cmdPubblica.Size = New System.Drawing.Size(122, 23)
        Me.cmdPubblica.TabIndex = 4
        Me.cmdPubblica.Text = "Pubblica"
        '
        'lblMessage
        '
        Me.lblMessage.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblMessage.ForeColor = System.Drawing.Color.Red
        Me.lblMessage.Location = New System.Drawing.Point(462, 10)
        Me.lblMessage.Name = "lblMessage"
        Me.lblMessage.Size = New System.Drawing.Size(490, 27)
        Me.lblMessage.TabIndex = 2
        Me.lblMessage.Visible = False
        '
        'timerMessage
        '
        Me.timerMessage.Interval = 10000
        '
        'Scrutinio
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.cmdPubblica)
        Me.Controls.Add(Me.grid)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.cboVisualizzazione)
        Me.Controls.Add(Me.cboConsultazioni)
        Me.Controls.Add(Me.cmdScrutinioFinale)
        Me.Controls.Add(Me.Label16)
        Me.Controls.Add(Me.txtVotantiF)
        Me.Controls.Add(Me.Label15)
        Me.Controls.Add(Me.txtVotantiM)
        Me.Controls.Add(Me.cmdPreferenzeCandidati)
        Me.Controls.Add(Me.txtTotVotanti)
        Me.Controls.Add(Me.Label14)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.Label12)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.txtTotBianche)
        Me.Controls.Add(Me.txtTotNulle)
        Me.Controls.Add(Me.txtTotContestati)
        Me.Controls.Add(Me.txtTotValidi)
        Me.Controls.Add(Me.lnkReports)
        Me.Controls.Add(Me.cmdScrutinioParziale)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.cmdAggiorna)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.cmdIndietro)
        Me.Controls.Add(Me.cmdLogout)
        Me.Controls.Add(Me.Panel1)
        Me.Location = New System.Drawing.Point(15, -91)
        Me.Size = New System.Drawing.Size(972, 573)
        Me.Text = "EAP - Elezioni OnLine - Homepage"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.timerSync, Me.timerMessage}
        Me.Panel1.ResumeLayout(False)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel2.ResumeLayout(False)
        CType(Me.grid, System.ComponentModel.ISupportInitialize).EndInit()
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
    Friend WithEvents cmdAggiorna As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdScrutinioParziale As Gizmox.WebGUI.Forms.Button
    Friend WithEvents lnkReports As Gizmox.WebGUI.Forms.LinkLabel
    Friend WithEvents lblSezioniRilevate As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotValidi As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotContestati As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotNulle As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotBianche As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label7 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label11 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label12 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label13 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label14 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotVotanti As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents cmdPreferenzeCandidati As Gizmox.WebGUI.Forms.Button
    Friend WithEvents txtVotantiM As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label15 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtVotantiF As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label16 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdScrutinioFinale As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cboConsultazioni As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents cboVisualizzazione As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents grid As Gizmox.WebGUI.Forms.DataGridView
    Friend WithEvents lblSezioniValidate As Gizmox.WebGUI.Forms.Label
    Friend WithEvents timerSync As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents cmdPubblica As Gizmox.WebGUI.Forms.Button
    Friend WithEvents lblMessage As Gizmox.WebGUI.Forms.Label
    Friend WithEvents timerMessage As Gizmox.WebGUI.Forms.Timer

End Class