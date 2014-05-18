<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class CheckOperatori
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(CheckOperatori))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.cmdIndietro = New Gizmox.WebGUI.Forms.Button()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdAggiorna = New Gizmox.WebGUI.Forms.Button()
        Me.lblOperatoriOK = New Gizmox.WebGUI.Forms.Label()
        Me.lblOperatoriNoOK = New Gizmox.WebGUI.Forms.Label()
        Me.cmdAzzeraFlag = New Gizmox.WebGUI.Forms.Button()
        Me.grid = New Gizmox.WebGUI.Forms.DataGridView()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.timerCheck = New Gizmox.WebGUI.Forms.Timer(Me.components)
        Me.lblMessage = New Gizmox.WebGUI.Forms.Label()
        Me.timerMessage = New Gizmox.WebGUI.Forms.Timer(Me.components)
        Me.Panel1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.grid, System.ComponentModel.ISupportInitialize).BeginInit()
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
        Me.Label8.Location = New System.Drawing.Point(667, 64)
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
        Me.PictureBox1.Location = New System.Drawing.Point(832, 3)
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
        Me.Label2.Location = New System.Drawing.Point(470, 93)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(424, 25)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "CHECK INSEDIAMENTO SEDI (1° LOGIN)"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'cmdAggiorna
        '
        Me.cmdAggiorna.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdAggiorna.BackColor = System.Drawing.Color.Ivory
        Me.cmdAggiorna.CustomStyle = "F"
        Me.cmdAggiorna.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdAggiorna.Location = New System.Drawing.Point(7, 464)
        Me.cmdAggiorna.Name = "cmdAggiorna"
        Me.cmdAggiorna.Size = New System.Drawing.Size(85, 23)
        Me.cmdAggiorna.TabIndex = 4
        Me.cmdAggiorna.Text = "Aggiorna"
        '
        'lblOperatoriOK
        '
        Me.lblOperatoriOK.Font = New System.Drawing.Font("Tahoma", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblOperatoriOK.ForeColor = System.Drawing.Color.Blue
        Me.lblOperatoriOK.Location = New System.Drawing.Point(5, 95)
        Me.lblOperatoriOK.Name = "lblOperatoriOK"
        Me.lblOperatoriOK.Size = New System.Drawing.Size(437, 23)
        Me.lblOperatoriOK.TabIndex = 6
        Me.lblOperatoriOK.Text = "Sedi - operatore con accesso riuscito : N/A"
        '
        'lblOperatoriNoOK
        '
        Me.lblOperatoriNoOK.Font = New System.Drawing.Font("Tahoma", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblOperatoriNoOK.ForeColor = System.Drawing.Color.Red
        Me.lblOperatoriNoOK.Location = New System.Drawing.Point(5, 118)
        Me.lblOperatoriNoOK.Name = "Label4"
        Me.lblOperatoriNoOK.Size = New System.Drawing.Size(437, 23)
        Me.lblOperatoriNoOK.TabIndex = 6
        Me.lblOperatoriNoOK.Text = "Sedi - operatore con problemi di accesso : N/A"
        '
        'cmdAzzeraFlag
        '
        Me.cmdAzzeraFlag.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdAzzeraFlag.BackColor = System.Drawing.Color.Ivory
        Me.cmdAzzeraFlag.CustomStyle = "F"
        Me.cmdAzzeraFlag.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdAzzeraFlag.Location = New System.Drawing.Point(98, 464)
        Me.cmdAzzeraFlag.Name = "cmdAggiorna"
        Me.cmdAzzeraFlag.Size = New System.Drawing.Size(203, 23)
        Me.cmdAzzeraFlag.TabIndex = 4
        Me.cmdAzzeraFlag.Text = "Azzera Flag Accesso Operatore"
        '
        'grid
        '
        Me.grid.AllowUserToAddRows = False
        Me.grid.AllowUserToDeleteRows = False
        Me.grid.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.grid.ColumnHeadersHeightSizeMode = Gizmox.WebGUI.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.grid.ItemsPerPage = 100
        Me.grid.Location = New System.Drawing.Point(7, 151)
        Me.grid.Name = "grid"
        Me.grid.ReadOnly = True
        Me.grid.RowTemplate.DefaultCellStyle.FormatProvider = New System.Globalization.CultureInfo("it-IT")
        Me.grid.Size = New System.Drawing.Size(886, 302)
        Me.grid.TabIndex = 7
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
        Me.Panel2.Location = New System.Drawing.Point(0, 502)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(906, 46)
        Me.Panel2.TabIndex = 1
        '
        'timerCheck
        '
        Me.timerCheck.Enabled = True
        Me.timerCheck.Interval = 60000
        '
        'lblMessage
        '
        Me.lblMessage.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblMessage.ForeColor = System.Drawing.Color.Red
        Me.lblMessage.Location = New System.Drawing.Point(401, 10)
        Me.lblMessage.Name = "lblMessage"
        Me.lblMessage.Size = New System.Drawing.Size(490, 27)
        Me.lblMessage.TabIndex = 2
        Me.lblMessage.Visible = False
        '
        'timerMessage
        '
        Me.timerMessage.Interval = 10000
        '
        'CheckOperatori
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.grid)
        Me.Controls.Add(Me.cmdAzzeraFlag)
        Me.Controls.Add(Me.lblOperatoriNoOK)
        Me.Controls.Add(Me.lblOperatoriOK)
        Me.Controls.Add(Me.cmdAggiorna)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.cmdIndietro)
        Me.Controls.Add(Me.cmdLogout)
        Me.Controls.Add(Me.Panel1)
        Me.Size = New System.Drawing.Size(906, 548)
        Me.Text = "EAP - Elezioni OnLine - Homepage"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.timerCheck, Me.timerMessage}
        Me.Panel1.ResumeLayout(False)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.grid, System.ComponentModel.ISupportInitialize).EndInit()
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
    Friend WithEvents cmdAggiorna As Gizmox.WebGUI.Forms.Button
    Friend WithEvents lblOperatoriOK As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lblOperatoriNoOK As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdAzzeraFlag As Gizmox.WebGUI.Forms.Button
    Friend WithEvents grid As Gizmox.WebGUI.Forms.DataGridView
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents timerCheck As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents lblMessage As Gizmox.WebGUI.Forms.Label
    Friend WithEvents timerMessage As Gizmox.WebGUI.Forms.Timer

End Class