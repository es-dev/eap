Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class MonitorSezioni
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
    'It can be modified using the Visual WebGui Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(MonitorSezioni))
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.GroupBox1 = New Gizmox.WebGUI.Forms.GroupBox()
        Me.listStatoConsultazioni = New Gizmox.WebGUI.Forms.ListBox()
        Me.GroupBox2 = New Gizmox.WebGUI.Forms.GroupBox()
        Me.listReports = New Gizmox.WebGUI.Forms.ListBox()
        Me.GroupBox3 = New Gizmox.WebGUI.Forms.GroupBox()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.cboConsultazioni = New Gizmox.WebGUI.Forms.ComboBox()
        Me.panelSezioni = New Gizmox.WebGUI.Forms.FlowLayoutPanel()
        Me.lnkReports = New Gizmox.WebGUI.Forms.LinkLabel()
        Me.errProvider = New Gizmox.WebGUI.Forms.ErrorProvider(Me.components)
        Me.lnkRefresh = New Gizmox.WebGUI.Forms.LinkLabel()
        Me.lblLastUpdate = New Gizmox.WebGUI.Forms.Label()
        Me.timerRefresh = New Gizmox.WebGUI.Forms.Timer(Me.components)
        Me.toolTip = New Gizmox.WebGUI.Forms.ToolTip()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.cmdPubblica = New Gizmox.WebGUI.Forms.Button()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.cmdIndietro = New Gizmox.WebGUI.Forms.Button()
        Me.chkTimerSync = New Gizmox.WebGUI.Forms.CheckBox()
        Me.timerSync = New Gizmox.WebGUI.Forms.Timer(Me.components)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel1.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.GroupBox2.SuspendLayout()
        Me.GroupBox3.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(606, 64)
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
        Me.PictureBox1.Location = New System.Drawing.Point(771, 3)
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
        Me.Panel1.Size = New System.Drawing.Size(853, 90)
        Me.Panel1.TabIndex = 1
        '
        'Label2
        '
        Me.Label2.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(144, 90)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(564, 28)
        Me.Label2.TabIndex = 2
        Me.Label2.Text = "Dashboard - Controllo Sezioni - Export e Reports"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.listStatoConsultazioni)
        Me.GroupBox1.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.GroupBox1.Location = New System.Drawing.Point(9, 138)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(368, 113)
        Me.GroupBox1.TabIndex = 3
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = "Stato Consultazioni"
        '
        'listStatoConsultazioni
        '
        Me.listStatoConsultazioni.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.listStatoConsultazioni.Location = New System.Drawing.Point(10, 20)
        Me.listStatoConsultazioni.Name = "listStatoConsultazioni"
        Me.listStatoConsultazioni.Size = New System.Drawing.Size(346, 82)
        Me.listStatoConsultazioni.Sorted = True
        Me.listStatoConsultazioni.TabIndex = 0
        Me.toolTip.SetToolTip(Me.listStatoConsultazioni, "Fai doppio clic per conoscere lo stato di una consultazione ...")
        '
        'GroupBox2
        '
        Me.GroupBox2.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.GroupBox2.Controls.Add(Me.listReports)
        Me.GroupBox2.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.GroupBox2.Location = New System.Drawing.Point(390, 138)
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.Size = New System.Drawing.Size(454, 113)
        Me.GroupBox2.TabIndex = 3
        Me.GroupBox2.TabStop = False
        Me.GroupBox2.Text = "Export / Reports"
        '
        'listReports
        '
        Me.listReports.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.listReports.Location = New System.Drawing.Point(13, 20)
        Me.listReports.Name = "listReports"
        Me.listReports.Size = New System.Drawing.Size(428, 82)
        Me.listReports.Sorted = True
        Me.listReports.TabIndex = 0
        Me.toolTip.SetToolTip(Me.listReports, "Fai doppio clic per aprire un report ...")
        '
        'GroupBox3
        '
        Me.GroupBox3.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.GroupBox3.Controls.Add(Me.Label4)
        Me.GroupBox3.Controls.Add(Me.cboConsultazioni)
        Me.GroupBox3.Controls.Add(Me.panelSezioni)
        Me.GroupBox3.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.GroupBox3.Location = New System.Drawing.Point(9, 251)
        Me.GroupBox3.Name = "GroupBox3"
        Me.GroupBox3.Size = New System.Drawing.Size(835, 334)
        Me.GroupBox3.TabIndex = 4
        Me.GroupBox3.TabStop = False
        Me.GroupBox3.Text = "Controllo Sezioni"
        '
        'Label4
        '
        Me.Label4.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(507, 13)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(87, 20)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Consultazione"
        '
        'cboConsultazioni
        '
        Me.cboConsultazioni.AllowDrag = False
        Me.cboConsultazioni.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cboConsultazioni.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboConsultazioni.Location = New System.Drawing.Point(606, 12)
        Me.cboConsultazioni.Name = "cboConsultazioni"
        Me.cboConsultazioni.Size = New System.Drawing.Size(216, 21)
        Me.cboConsultazioni.TabIndex = 10
        '
        'panelSezioni
        '
        Me.panelSezioni.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.panelSezioni.AutoScroll = True
        Me.panelSezioni.Location = New System.Drawing.Point(10, 38)
        Me.panelSezioni.Name = "panelSezioni"
        Me.panelSezioni.Size = New System.Drawing.Size(812, 288)
        Me.panelSezioni.TabIndex = 0
        Me.toolTip.SetToolTip(Me.panelSezioni, "Fai clic su una sezione per conoscere lo stato ...")
        '
        'lnkReports
        '
        Me.lnkReports.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lnkReports.ClientMode = True
        Me.lnkReports.LinkColor = System.Drawing.Color.Blue
        Me.lnkReports.Location = New System.Drawing.Point(790, 119)
        Me.lnkReports.Name = "lnkReports"
        Me.lnkReports.Size = New System.Drawing.Size(54, 16)
        Me.lnkReports.TabIndex = 8
        Me.lnkReports.TabStop = True
        Me.lnkReports.Text = "Reports"
        Me.lnkReports.TextAlign = System.Drawing.ContentAlignment.TopRight
        '
        'errProvider
        '
        Me.errProvider.BlinkRate = 3
        '
        'lnkRefresh
        '
        Me.lnkRefresh.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lnkRefresh.ClientMode = True
        Me.lnkRefresh.LinkColor = System.Drawing.Color.Blue
        Me.lnkRefresh.Location = New System.Drawing.Point(739, 119)
        Me.lnkRefresh.Name = "lnkRefresh"
        Me.lnkRefresh.Size = New System.Drawing.Size(51, 16)
        Me.lnkRefresh.TabIndex = 8
        Me.lnkRefresh.TabStop = True
        Me.lnkRefresh.Text = "Refresh"
        Me.lnkRefresh.TextAlign = System.Drawing.ContentAlignment.TopRight
        '
        'lblLastUpdate
        '
        Me.lblLastUpdate.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblLastUpdate.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblLastUpdate.ForeColor = System.Drawing.Color.Red
        Me.lblLastUpdate.Location = New System.Drawing.Point(191, 118)
        Me.lblLastUpdate.Name = "lblLastUpdate"
        Me.lblLastUpdate.Size = New System.Drawing.Size(471, 20)
        Me.lblLastUpdate.TabIndex = 9
        Me.lblLastUpdate.Text = "( Ultimo aggiornamento --/--/---- --:--:-- )"
        Me.lblLastUpdate.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'timerRefresh
        '
        Me.timerRefresh.Enabled = True
        Me.timerRefresh.Interval = 60000
        '
        'Label10
        '
        Me.Label10.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label10.Location = New System.Drawing.Point(4, 26)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(516, 18)
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
        Me.Panel2.Controls.Add(Me.cmdPubblica)
        Me.Panel2.Controls.Add(Me.cmdLogout)
        Me.Panel2.Controls.Add(Me.Label10)
        Me.Panel2.Controls.Add(Me.cmdIndietro)
        Me.Panel2.Controls.Add(Me.Label9)
        Me.Panel2.Dock = Gizmox.WebGUI.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 585)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(853, 46)
        Me.Panel2.TabIndex = 1
        '
        'cmdPubblica
        '
        Me.cmdPubblica.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdPubblica.BackColor = System.Drawing.Color.Ivory
        Me.cmdPubblica.CustomStyle = "F"
        Me.cmdPubblica.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdPubblica.ForeColor = System.Drawing.Color.RoyalBlue
        Me.cmdPubblica.Location = New System.Drawing.Point(489, 11)
        Me.cmdPubblica.Name = "cmdPubblica"
        Me.cmdPubblica.Size = New System.Drawing.Size(101, 23)
        Me.cmdPubblica.TabIndex = 4
        Me.cmdPubblica.Text = "Pubblica"
        '
        'cmdLogout
        '
        Me.cmdLogout.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdLogout.BackColor = System.Drawing.Color.Ivory
        Me.cmdLogout.CustomStyle = "F"
        Me.cmdLogout.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdLogout.Location = New System.Drawing.Point(703, 13)
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
        Me.cmdIndietro.Location = New System.Drawing.Point(593, 11)
        Me.cmdIndietro.Name = "cmdIndietro"
        Me.cmdIndietro.Size = New System.Drawing.Size(105, 23)
        Me.cmdIndietro.TabIndex = 4
        Me.cmdIndietro.Text = "<< Indietro"
        '
        'chkTimerSync
        '
        Me.chkTimerSync.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.chkTimerSync.Checked = True
        Me.chkTimerSync.CheckState = Gizmox.WebGUI.Forms.CheckState.Checked
        Me.chkTimerSync.Location = New System.Drawing.Point(643, 118)
        Me.chkTimerSync.Name = "chkTimerSync"
        Me.chkTimerSync.Size = New System.Drawing.Size(97, 17)
        Me.chkTimerSync.TabIndex = 10
        Me.chkTimerSync.Text = "Timer Sync"
        '
        'timerSync
        '
        Me.timerSync.Interval = 1000
        '
        'MonitorSezioni
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.chkTimerSync)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.lblLastUpdate)
        Me.Controls.Add(Me.lnkRefresh)
        Me.Controls.Add(Me.lnkReports)
        Me.Controls.Add(Me.GroupBox3)
        Me.Controls.Add(Me.GroupBox2)
        Me.Controls.Add(Me.GroupBox1)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Panel1)
        Me.Size = New System.Drawing.Size(853, 631)
        Me.Text = "MonitorSezioni"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.timerRefresh, Me.timerSync}
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel1.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        Me.GroupBox2.ResumeLayout(False)
        Me.GroupBox3.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents GroupBox1 As Gizmox.WebGUI.Forms.GroupBox
    Friend WithEvents listStatoConsultazioni As Gizmox.WebGUI.Forms.ListBox
    Friend WithEvents GroupBox2 As Gizmox.WebGUI.Forms.GroupBox
    Friend WithEvents listReports As Gizmox.WebGUI.Forms.ListBox
    Friend WithEvents GroupBox3 As Gizmox.WebGUI.Forms.GroupBox
    Friend WithEvents panelSezioni As Gizmox.WebGUI.Forms.FlowLayoutPanel
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cboConsultazioni As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents lnkReports As Gizmox.WebGUI.Forms.LinkLabel
    Friend WithEvents errProvider As Gizmox.WebGUI.Forms.ErrorProvider
    Friend WithEvents lnkRefresh As Gizmox.WebGUI.Forms.LinkLabel
    Friend WithEvents lblLastUpdate As Gizmox.WebGUI.Forms.Label
    Friend WithEvents timerRefresh As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents toolTip As Gizmox.WebGUI.Forms.ToolTip
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents cmdLogout As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdIndietro As Gizmox.WebGUI.Forms.Button
    Friend WithEvents chkTimerSync As Gizmox.WebGUI.Forms.CheckBox
    Friend WithEvents timerSync As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents cmdPubblica As Gizmox.WebGUI.Forms.Button

End Class