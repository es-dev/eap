<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class EditingData
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(EditingData))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.panelUser = New Gizmox.WebGUI.Forms.Panel()
        Me.lblUser = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox2 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel3 = New Gizmox.WebGUI.Forms.Panel()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.cmdVoti = New Gizmox.WebGUI.Forms.Button()
        Me.cmdAffluenze = New Gizmox.WebGUI.Forms.Button()
        Me.cmdSpoglio = New Gizmox.WebGUI.Forms.Button()
        Me.panelHome = New Gizmox.WebGUI.Forms.Panel()
        Me.Label7 = New Gizmox.WebGUI.Forms.Label()
        Me.Label6 = New Gizmox.WebGUI.Forms.Label()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.Panel1.SuspendLayout()
        Me.panelUser.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.panelHome.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.Azure
        Me.Panel1.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.Panel1.Controls.Add(Me.panelUser)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.Label8)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = Gizmox.WebGUI.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(826, 90)
        Me.Panel1.TabIndex = 1
        '
        'panelUser
        '
        Me.panelUser.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.panelUser.Controls.Add(Me.lblUser)
        Me.panelUser.Controls.Add(Me.Label4)
        Me.panelUser.Controls.Add(Me.PictureBox2)
        Me.panelUser.Location = New System.Drawing.Point(545, 3)
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
        'Label4
        '
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 8.25!, System.Drawing.FontStyle.Underline, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(33, 3)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(101, 15)
        Me.Label4.TabIndex = 1
        Me.Label4.Text = "Utente connesso:"
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
        Me.PictureBox1.Location = New System.Drawing.Point(762, 3)
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
        Me.Label8.Location = New System.Drawing.Point(601, 62)
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
        'Panel3
        '
        Me.Panel3.BackColor = System.Drawing.Color.MintCream
        Me.Panel3.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.Panel3.Controls.Add(Me.cmdLogout)
        Me.Panel3.Controls.Add(Me.cmdVoti)
        Me.Panel3.Controls.Add(Me.cmdAffluenze)
        Me.Panel3.Controls.Add(Me.cmdSpoglio)
        Me.Panel3.Dock = Gizmox.WebGUI.Forms.DockStyle.Left
        Me.Panel3.Location = New System.Drawing.Point(0, 90)
        Me.Panel3.Name = "Panel3"
        Me.Panel3.Size = New System.Drawing.Size(165, 409)
        Me.Panel3.TabIndex = 3
        '
        'cmdLogout
        '
        Me.cmdLogout.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdLogout.BackColor = System.Drawing.Color.Ivory
        Me.cmdLogout.CustomStyle = "F"
        Me.cmdLogout.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdLogout.Location = New System.Drawing.Point(12, 378)
        Me.cmdLogout.Name = "cmdLogout"
        Me.cmdLogout.Size = New System.Drawing.Size(135, 23)
        Me.cmdLogout.TabIndex = 4
        Me.cmdLogout.Text = "Disconnetti (Esci)"
        '
        'cmdVoti
        '
        Me.cmdVoti.BackColor = System.Drawing.Color.Ivory
        Me.cmdVoti.CustomStyle = "F"
        Me.cmdVoti.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdVoti.Location = New System.Drawing.Point(12, 82)
        Me.cmdVoti.Name = "cmdVoti"
        Me.cmdVoti.Size = New System.Drawing.Size(135, 23)
        Me.cmdVoti.TabIndex = 4
        Me.cmdVoti.Text = "Stato dei Voti"
        '
        'cmdAffluenze
        '
        Me.cmdAffluenze.BackColor = System.Drawing.Color.Ivory
        Me.cmdAffluenze.CustomStyle = "F"
        Me.cmdAffluenze.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdAffluenze.Location = New System.Drawing.Point(12, 53)
        Me.cmdAffluenze.Name = "cmdAffluenze"
        Me.cmdAffluenze.Size = New System.Drawing.Size(135, 23)
        Me.cmdAffluenze.TabIndex = 4
        Me.cmdAffluenze.Text = "Stato delle Affluenze"
        '
        'cmdSpoglio
        '
        Me.cmdSpoglio.BackColor = System.Drawing.Color.Ivory
        Me.cmdSpoglio.CustomStyle = "F"
        Me.cmdSpoglio.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdSpoglio.Location = New System.Drawing.Point(12, 24)
        Me.cmdSpoglio.Name = "cmdSpoglio"
        Me.cmdSpoglio.Size = New System.Drawing.Size(135, 23)
        Me.cmdSpoglio.TabIndex = 4
        Me.cmdSpoglio.Text = "Gestione Spoglio Elettorale"
        '
        'panelHome
        '
        Me.panelHome.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.None
        Me.panelHome.Controls.Add(Me.Label7)
        Me.panelHome.Controls.Add(Me.Label6)
        Me.panelHome.Controls.Add(Me.Label5)
        Me.panelHome.Location = New System.Drawing.Point(250, 143)
        Me.panelHome.Name = "panelHome"
        Me.panelHome.Size = New System.Drawing.Size(478, 311)
        Me.panelHome.TabIndex = 4
        '
        'Label7
        '
        Me.Label7.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.ForeColor = System.Drawing.Color.DimGray
        Me.Label7.Location = New System.Drawing.Point(3, 206)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(472, 53)
        Me.Label7.TabIndex = 1
        Me.Label7.Text = "Selezionare una voce dal menù a destra. E' possibile gestire i dati dello spoglio" & _
    " elettorale, visualizzare lo stato delle affluenze o dei voti ..."
        Me.Label7.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label6
        '
        Me.Label6.Font = New System.Drawing.Font("Tahoma", 48.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(44, 107)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(400, 86)
        Me.Label6.TabIndex = 0
        Me.Label6.Text = "Elettorale"
        Me.Label6.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label5
        '
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 24.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(44, 54)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(400, 53)
        Me.Label5.TabIndex = 0
        Me.Label5.Text = "Gestione Spoglio"
        Me.Label5.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
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
        Me.Panel2.Location = New System.Drawing.Point(0, 499)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(826, 46)
        Me.Panel2.TabIndex = 1
        '
        'EditingData
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Panel3)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.panelHome)
        Me.Controls.Add(Me.Panel1)
        Me.Size = New System.Drawing.Size(826, 545)
        Me.Text = "EAP - Elezioni OnLine - Homepage"
        Me.Panel1.ResumeLayout(False)
        Me.panelUser.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.panelHome.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel3 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents cmdSpoglio As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdLogout As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdVoti As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdAffluenze As Gizmox.WebGUI.Forms.Button
    Friend WithEvents panelUser As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents lblUser As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox2 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents panelHome As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label7 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label6 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel

End Class