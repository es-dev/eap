<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class eStat
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(eStat))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.panelUser = New Gizmox.WebGUI.Forms.Panel()
        Me.lblUser = New Gizmox.WebGUI.Forms.Label()
        Me.lblTipoUtente = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox2 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.listCamera = New Gizmox.WebGUI.Forms.ListView()
        Me.ColumnHeader1 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader2 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader3 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader7 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.lblSezioniRilevateCamera = New Gizmox.WebGUI.Forms.Label()
        Me.Label6 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotValidiCamera = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotContestatiCamera = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label7 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotVotantiCamera = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotBiancheCamera = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label11 = New Gizmox.WebGUI.Forms.Label()
        Me.Label12 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotNulleCamera = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label13 = New Gizmox.WebGUI.Forms.Label()
        Me.panelCamera = New Gizmox.WebGUI.Forms.Panel()
        Me.panelSenato = New Gizmox.WebGUI.Forms.Panel()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.Label14 = New Gizmox.WebGUI.Forms.Label()
        Me.listSenato = New Gizmox.WebGUI.Forms.ListView()
        Me.ColumnHeader4 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader5 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader6 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.ColumnHeader8 = New Gizmox.WebGUI.Forms.ColumnHeader()
        Me.txtTotNulleSenato = New Gizmox.WebGUI.Forms.TextBox()
        Me.lblSezioniRilevateSenato = New Gizmox.WebGUI.Forms.Label()
        Me.Label16 = New Gizmox.WebGUI.Forms.Label()
        Me.Label17 = New Gizmox.WebGUI.Forms.Label()
        Me.Label18 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotValidiSenato = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotBiancheSenato = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotContestatiSenato = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtTotVotantiSenato = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label19 = New Gizmox.WebGUI.Forms.Label()
        Me.cboConsultazione = New Gizmox.WebGUI.Forms.ComboBox()
        Me.Label15 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdRefresh = New Gizmox.WebGUI.Forms.Button()
        Me.tmrRefresh = New Gizmox.WebGUI.Forms.Timer()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.Panel1.SuspendLayout()
        Me.panelUser.SuspendLayout()
        Me.panelCamera.SuspendLayout()
        Me.panelSenato.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.White
        Me.Panel1.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.Panel1.Controls.Add(Me.panelUser)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.Label8)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = Gizmox.WebGUI.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(833, 90)
        Me.Panel1.TabIndex = 1
        '
        'panelUser
        '
        Me.panelUser.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.panelUser.Controls.Add(Me.lblUser)
        Me.panelUser.Controls.Add(Me.lblTipoUtente)
        Me.panelUser.Controls.Add(Me.PictureBox2)
        Me.panelUser.Location = New System.Drawing.Point(552, 3)
        Me.panelUser.Name = "panelUser"
        Me.panelUser.Size = New System.Drawing.Size(211, 43)
        Me.panelUser.TabIndex = 4
        '
        'lblUser
        '
        Me.lblUser.ForeColor = System.Drawing.Color.Red
        Me.lblUser.Location = New System.Drawing.Point(33, 18)
        Me.lblUser.Name = "lblUser"
        Me.lblUser.Size = New System.Drawing.Size(165, 18)
        Me.lblUser.TabIndex = 1
        Me.lblUser.Text = "N/A"
        '
        'lblTipoUtente
        '
        Me.lblTipoUtente.Font = New System.Drawing.Font("Tahoma", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblTipoUtente.Location = New System.Drawing.Point(33, 3)
        Me.lblTipoUtente.Name = "lblTipoUtente"
        Me.lblTipoUtente.Size = New System.Drawing.Size(101, 15)
        Me.lblTipoUtente.TabIndex = 1
        Me.lblTipoUtente.Text = "Utente connesso:"
        '
        'PictureBox2
        '
        Me.PictureBox2.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle(resources.GetString("PictureBox2.Image"))
        Me.PictureBox2.Location = New System.Drawing.Point(3, 3)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(22, 21)
        Me.PictureBox2.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox2.TabIndex = 0
        Me.PictureBox2.TabStop = False
        '
        'PictureBox1
        '
        Me.PictureBox1.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.PictureBox1.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle(resources.GetString("PictureBox1.Image"))
        Me.PictureBox1.Location = New System.Drawing.Point(769, 3)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(45, 56)
        Me.PictureBox1.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.AutoSize
        Me.PictureBox1.TabIndex = 2
        Me.PictureBox1.TabStop = False
        '
        'Label3
        '
        Me.Label3.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(38, 46)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(577, 37)
        Me.Label3.TabIndex = 1
        Me.Label3.Text = "Modulo software per la gestione delle comunicazioni dei dati elettorali dalle sed" & _
    "i periferiche alla server-farm. Gestione dello spoglio elettorale e comunicazion" & _
    "e dei dati agli enti di controllo.."
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(608, 62)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(225, 25)
        Me.Label8.TabIndex = 0
        Me.Label8.Text = "COMUNE DI COSENZA"
        Me.Label8.TextAlign = System.Drawing.ContentAlignment.MiddleRight
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
        'Label2
        '
        Me.Label2.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(526, 93)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(307, 25)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "ACCESSO SPECIALE - PREFETTURA"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label4
        '
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(3, 10)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(408, 22)
        Me.Label4.TabIndex = 0
        Me.Label4.Text = "Elezioni Politiche 13-14 Aprile 2008 - Camera"
        '
        'listCamera
        '
        Me.listCamera.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.listCamera.AutoGenerateColumns = False
        Me.listCamera.Columns.AddRange(New Gizmox.WebGUI.Forms.ColumnHeader() {Me.ColumnHeader1, Me.ColumnHeader2, Me.ColumnHeader3, Me.ColumnHeader7})
        Me.listCamera.DataMember = Nothing
        Me.listCamera.ItemsPerPage = 20
        Me.listCamera.Location = New System.Drawing.Point(3, 39)
        Me.listCamera.Name = "listCamera"
        Me.listCamera.ShowItemToolTips = False
        Me.listCamera.Size = New System.Drawing.Size(808, 233)
        Me.listCamera.TabIndex = 2
        Me.listCamera.TotalItems = 3
        '
        'ColumnHeader1
        '
        Me.ColumnHeader1.Image = Nothing
        Me.ColumnHeader1.Text = "Numero"
        Me.ColumnHeader1.Width = 50
        '
        'ColumnHeader2
        '
        Me.ColumnHeader2.Image = Nothing
        Me.ColumnHeader2.Text = "Coalizione / Lista"
        Me.ColumnHeader2.Width = 420
        '
        'ColumnHeader3
        '
        Me.ColumnHeader3.Image = Nothing
        Me.ColumnHeader3.Text = "Voti"
        Me.ColumnHeader3.Width = 150
        '
        'ColumnHeader7
        '
        Me.ColumnHeader7.Image = Nothing
        Me.ColumnHeader7.Text = "Contestati"
        Me.ColumnHeader7.Width = 150
        '
        'lblSezioniRilevateCamera
        '
        Me.lblSezioniRilevateCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezioniRilevateCamera.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniRilevateCamera.ForeColor = System.Drawing.Color.Red
        Me.lblSezioniRilevateCamera.Location = New System.Drawing.Point(403, 11)
        Me.lblSezioniRilevateCamera.Name = "lblSezioniRilevateCamera"
        Me.lblSezioniRilevateCamera.Size = New System.Drawing.Size(408, 22)
        Me.lblSezioniRilevateCamera.TabIndex = 0
        Me.lblSezioniRilevateCamera.Text = "Sezioni rilevate 0 su 82"
        Me.lblSezioniRilevateCamera.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label6
        '
        Me.Label6.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label6.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(3, 276)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(148, 22)
        Me.Label6.TabIndex = 0
        Me.Label6.Text = "Totale Voti Validi"
        Me.Label6.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'txtTotValidiCamera
        '
        Me.txtTotValidiCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotValidiCamera.Location = New System.Drawing.Point(166, 278)
        Me.txtTotValidiCamera.Name = "txtTotValidiCamera"
        Me.txtTotValidiCamera.Size = New System.Drawing.Size(88, 20)
        Me.txtTotValidiCamera.TabIndex = 3
        '
        'txtTotContestatiCamera
        '
        Me.txtTotContestatiCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotContestatiCamera.Location = New System.Drawing.Point(488, 280)
        Me.txtTotContestatiCamera.Name = "txtTotContestatiCamera"
        Me.txtTotContestatiCamera.Size = New System.Drawing.Size(76, 20)
        Me.txtTotContestatiCamera.TabIndex = 3
        '
        'Label7
        '
        Me.Label7.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label7.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.Location = New System.Drawing.Point(4, 311)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(156, 22)
        Me.Label7.TabIndex = 0
        Me.Label7.Text = "Votanti"
        Me.Label7.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'txtTotVotantiCamera
        '
        Me.txtTotVotantiCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotVotantiCamera.Location = New System.Drawing.Point(166, 314)
        Me.txtTotVotantiCamera.Name = "txtTotVotantiCamera"
        Me.txtTotVotantiCamera.Size = New System.Drawing.Size(88, 20)
        Me.txtTotVotantiCamera.TabIndex = 3
        '
        'txtTotBiancheCamera
        '
        Me.txtTotBiancheCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotBiancheCamera.Location = New System.Drawing.Point(488, 316)
        Me.txtTotBiancheCamera.Name = "txtTotBiancheCamera"
        Me.txtTotBiancheCamera.Size = New System.Drawing.Size(76, 20)
        Me.txtTotBiancheCamera.TabIndex = 3
        '
        'Label11
        '
        Me.Label11.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label11.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label11.Location = New System.Drawing.Point(357, 311)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(99, 22)
        Me.Label11.TabIndex = 0
        Me.Label11.Text = "Bianche"
        Me.Label11.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label12
        '
        Me.Label12.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label12.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.Location = New System.Drawing.Point(626, 276)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(62, 22)
        Me.Label12.TabIndex = 0
        Me.Label12.Text = "Nulle"
        Me.Label12.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'txtTotNulleCamera
        '
        Me.txtTotNulleCamera.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotNulleCamera.Location = New System.Drawing.Point(710, 281)
        Me.txtTotNulleCamera.Name = "txtTotNulleCamera"
        Me.txtTotNulleCamera.Size = New System.Drawing.Size(85, 20)
        Me.txtTotNulleCamera.TabIndex = 3
        '
        'Label13
        '
        Me.Label13.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label13.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.Location = New System.Drawing.Point(273, 278)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(207, 22)
        Me.Label13.TabIndex = 0
        Me.Label13.Text = "Totale Voti Contestati"
        Me.Label13.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'panelCamera
        '
        Me.panelCamera.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.panelCamera.Controls.Add(Me.Label4)
        Me.panelCamera.Controls.Add(Me.Label13)
        Me.panelCamera.Controls.Add(Me.listCamera)
        Me.panelCamera.Controls.Add(Me.txtTotNulleCamera)
        Me.panelCamera.Controls.Add(Me.lblSezioniRilevateCamera)
        Me.panelCamera.Controls.Add(Me.Label12)
        Me.panelCamera.Controls.Add(Me.Label6)
        Me.panelCamera.Controls.Add(Me.Label11)
        Me.panelCamera.Controls.Add(Me.txtTotValidiCamera)
        Me.panelCamera.Controls.Add(Me.txtTotBiancheCamera)
        Me.panelCamera.Controls.Add(Me.txtTotContestatiCamera)
        Me.panelCamera.Controls.Add(Me.txtTotVotantiCamera)
        Me.panelCamera.Controls.Add(Me.Label7)
        Me.panelCamera.Location = New System.Drawing.Point(12, 125)
        Me.panelCamera.Name = "panelCamera"
        Me.panelCamera.Size = New System.Drawing.Size(817, 342)
        Me.panelCamera.TabIndex = 4
        '
        'panelSenato
        '
        Me.panelSenato.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.panelSenato.Controls.Add(Me.Label5)
        Me.panelSenato.Controls.Add(Me.Label14)
        Me.panelSenato.Controls.Add(Me.listSenato)
        Me.panelSenato.Controls.Add(Me.txtTotNulleSenato)
        Me.panelSenato.Controls.Add(Me.lblSezioniRilevateSenato)
        Me.panelSenato.Controls.Add(Me.Label16)
        Me.panelSenato.Controls.Add(Me.Label17)
        Me.panelSenato.Controls.Add(Me.Label18)
        Me.panelSenato.Controls.Add(Me.txtTotValidiSenato)
        Me.panelSenato.Controls.Add(Me.txtTotBiancheSenato)
        Me.panelSenato.Controls.Add(Me.txtTotContestatiSenato)
        Me.panelSenato.Controls.Add(Me.txtTotVotantiSenato)
        Me.panelSenato.Controls.Add(Me.Label19)
        Me.panelSenato.Location = New System.Drawing.Point(12, 125)
        Me.panelSenato.Name = "panelSenato"
        Me.panelSenato.Size = New System.Drawing.Size(817, 342)
        Me.panelSenato.TabIndex = 4
        '
        'Label5
        '
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(3, 10)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(408, 22)
        Me.Label5.TabIndex = 0
        Me.Label5.Text = "Elezioni Politiche 13-14 Aprile 2008 - Senato"
        '
        'Label14
        '
        Me.Label14.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label14.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label14.Location = New System.Drawing.Point(273, 278)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(207, 22)
        Me.Label14.TabIndex = 0
        Me.Label14.Text = "Totale Voti Contestati"
        Me.Label14.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'listSenato
        '
        Me.listSenato.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.listSenato.AutoGenerateColumns = False
        Me.listSenato.Columns.AddRange(New Gizmox.WebGUI.Forms.ColumnHeader() {Me.ColumnHeader4, Me.ColumnHeader5, Me.ColumnHeader6, Me.ColumnHeader8})
        Me.listSenato.DataMember = Nothing
        Me.listSenato.ItemsPerPage = 20
        Me.listSenato.Location = New System.Drawing.Point(3, 39)
        Me.listSenato.Name = "listSenato"
        Me.listSenato.ShowItemToolTips = False
        Me.listSenato.Size = New System.Drawing.Size(808, 233)
        Me.listSenato.TabIndex = 2
        Me.listSenato.TotalItems = 3
        '
        'ColumnHeader4
        '
        Me.ColumnHeader4.Image = Nothing
        Me.ColumnHeader4.Text = "Numero"
        Me.ColumnHeader4.Width = 50
        '
        'ColumnHeader5
        '
        Me.ColumnHeader5.Image = Nothing
        Me.ColumnHeader5.Text = "Coalizione / Lista"
        Me.ColumnHeader5.Width = 420
        '
        'ColumnHeader6
        '
        Me.ColumnHeader6.Image = Nothing
        Me.ColumnHeader6.Text = "Voti"
        Me.ColumnHeader6.Width = 150
        '
        'ColumnHeader8
        '
        Me.ColumnHeader8.Image = Nothing
        Me.ColumnHeader8.Text = "Contestati"
        Me.ColumnHeader8.Width = 150
        '
        'txtTotNulleSenato
        '
        Me.txtTotNulleSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotNulleSenato.Location = New System.Drawing.Point(710, 281)
        Me.txtTotNulleSenato.Name = "txtTotNulleSenato"
        Me.txtTotNulleSenato.Size = New System.Drawing.Size(85, 20)
        Me.txtTotNulleSenato.TabIndex = 3
        '
        'lblSezioniRilevateSenato
        '
        Me.lblSezioniRilevateSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezioniRilevateSenato.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniRilevateSenato.ForeColor = System.Drawing.Color.Red
        Me.lblSezioniRilevateSenato.Location = New System.Drawing.Point(403, 11)
        Me.lblSezioniRilevateSenato.Name = "lblSezioniRilevateSenato"
        Me.lblSezioniRilevateSenato.Size = New System.Drawing.Size(408, 22)
        Me.lblSezioniRilevateSenato.TabIndex = 0
        Me.lblSezioniRilevateSenato.Text = "Sezioni rilevate 0 su 82"
        Me.lblSezioniRilevateSenato.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label16
        '
        Me.Label16.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label16.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label16.Location = New System.Drawing.Point(626, 281)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(62, 22)
        Me.Label16.TabIndex = 0
        Me.Label16.Text = "Nulle"
        Me.Label16.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label17
        '
        Me.Label17.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label17.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label17.Location = New System.Drawing.Point(3, 273)
        Me.Label17.Name = "Label17"
        Me.Label17.Size = New System.Drawing.Size(148, 22)
        Me.Label17.TabIndex = 0
        Me.Label17.Text = "Totale Voti Validi"
        Me.Label17.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label18
        '
        Me.Label18.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label18.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label18.Location = New System.Drawing.Point(381, 309)
        Me.Label18.Name = "Label18"
        Me.Label18.Size = New System.Drawing.Size(99, 22)
        Me.Label18.TabIndex = 0
        Me.Label18.Text = "Bianche"
        Me.Label18.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'txtTotValidiSenato
        '
        Me.txtTotValidiSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotValidiSenato.Location = New System.Drawing.Point(166, 275)
        Me.txtTotValidiSenato.Name = "txtTotValidiSenato"
        Me.txtTotValidiSenato.Size = New System.Drawing.Size(88, 20)
        Me.txtTotValidiSenato.TabIndex = 3
        '
        'txtTotBiancheSenato
        '
        Me.txtTotBiancheSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotBiancheSenato.Location = New System.Drawing.Point(488, 313)
        Me.txtTotBiancheSenato.Name = "txtTotBiancheSenato"
        Me.txtTotBiancheSenato.Size = New System.Drawing.Size(76, 20)
        Me.txtTotBiancheSenato.TabIndex = 3
        '
        'txtTotContestatiSenato
        '
        Me.txtTotContestatiSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotContestatiSenato.Location = New System.Drawing.Point(486, 280)
        Me.txtTotContestatiSenato.Name = "txtTotContestatiSenato"
        Me.txtTotContestatiSenato.Size = New System.Drawing.Size(76, 20)
        Me.txtTotContestatiSenato.TabIndex = 3
        '
        'txtTotVotantiSenato
        '
        Me.txtTotVotantiSenato.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.txtTotVotantiSenato.Location = New System.Drawing.Point(166, 311)
        Me.txtTotVotantiSenato.Name = "txtTotVotantiSenato"
        Me.txtTotVotantiSenato.Size = New System.Drawing.Size(88, 20)
        Me.txtTotVotantiSenato.TabIndex = 3
        '
        'Label19
        '
        Me.Label19.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label19.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label19.Location = New System.Drawing.Point(4, 311)
        Me.Label19.Name = "Label19"
        Me.Label19.Size = New System.Drawing.Size(156, 22)
        Me.Label19.TabIndex = 0
        Me.Label19.Text = "Votanti"
        Me.Label19.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'cboConsultazione
        '
        Me.cboConsultazione.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboConsultazione.DisplayMember = "Elezioni Politiche 2008 - Camera"
        Me.cboConsultazione.DropDownWidth = 295
        Me.cboConsultazione.Location = New System.Drawing.Point(234, 97)
        Me.cboConsultazione.MaxDropDownItems = 8
        Me.cboConsultazione.Name = "cboConsultazione"
        Me.cboConsultazione.Size = New System.Drawing.Size(208, 21)
        Me.cboConsultazione.TabIndex = 5
        Me.cboConsultazione.Text = "ComboBox1"
        '
        'Label15
        '
        Me.Label15.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label15.ForeColor = System.Drawing.Color.RoyalBlue
        Me.Label15.Location = New System.Drawing.Point(12, 96)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(216, 23)
        Me.Label15.TabIndex = 6
        Me.Label15.Text = "Selezionare la consultazione desiderata"
        '
        'cmdRefresh
        '
        Me.cmdRefresh.Location = New System.Drawing.Point(449, 94)
        Me.cmdRefresh.Name = "cmdRefresh"
        Me.cmdRefresh.Size = New System.Drawing.Size(75, 23)
        Me.cmdRefresh.TabIndex = 7
        Me.cmdRefresh.Text = "Aggiorna"
        '
        'tmrRefresh
        '
        Me.tmrRefresh.Interval = 60000
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
        Me.Panel2.Controls.Add(Me.Label10)
        Me.Panel2.Controls.Add(Me.Label9)
        Me.Panel2.Dock = Gizmox.WebGUI.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 479)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(833, 46)
        Me.Panel2.TabIndex = 1
        '
        'eStat
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.cmdRefresh)
        Me.Controls.Add(Me.Label15)
        Me.Controls.Add(Me.cboConsultazione)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.panelCamera)
        Me.Controls.Add(Me.panelSenato)
        Me.Location = New System.Drawing.Point(15, -24)
        Me.Size = New System.Drawing.Size(833, 525)
        Me.Text = "EAP - Elezioni OnLine - eStatistiche"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.tmrRefresh}
        Me.Panel1.ResumeLayout(False)
        Me.panelUser.ResumeLayout(False)
        Me.panelCamera.ResumeLayout(False)
        Me.panelSenato.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents panelUser As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents lblUser As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lblTipoUtente As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox2 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents listCamera As Gizmox.WebGUI.Forms.ListView
    Friend WithEvents ColumnHeader1 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader2 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader3 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader7 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents lblSezioniRilevateCamera As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label6 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotValidiCamera As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotContestatiCamera As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label7 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotVotantiCamera As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotBiancheCamera As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label11 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label12 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotNulleCamera As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label13 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents panelCamera As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents panelSenato As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label14 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents listSenato As Gizmox.WebGUI.Forms.ListView
    Friend WithEvents ColumnHeader4 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader5 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader6 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents ColumnHeader8 As Gizmox.WebGUI.Forms.ColumnHeader
    Friend WithEvents txtTotNulleSenato As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents lblSezioniRilevateSenato As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label16 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label17 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label18 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotValidiSenato As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotBiancheSenato As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotContestatiSenato As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtTotVotantiSenato As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label19 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cboConsultazione As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents Label15 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdRefresh As Gizmox.WebGUI.Forms.Button
    Friend WithEvents tmrRefresh As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel

End Class