Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class VerificaSezioni
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(VerificaSezioni))
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.cboSezioni = New Gizmox.WebGUI.Forms.ComboBox()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdVerificaSezione = New Gizmox.WebGUI.Forms.Button()
        Me.lblStatoSezione = New Gizmox.WebGUI.Forms.Label()
        Me.imgStatoSezione = New Gizmox.WebGUI.Forms.PictureBox()
        Me.errorProvider = New Gizmox.WebGUI.Forms.ErrorProvider(Me.components)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel1.SuspendLayout()
        CType(Me.imgStatoSezione, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(642, 64)
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
        Me.PictureBox1.Location = New System.Drawing.Point(807, 3)
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
        Me.Panel1.Size = New System.Drawing.Size(889, 90)
        Me.Panel1.TabIndex = 1
        '
        'Label2
        '
        Me.Label2.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(168, 116)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(500, 62)
        Me.Label2.TabIndex = 2
        Me.Label2.Text = "Selezionare la sezione desiderata o indicare il numero [compreso tra 1 e 82] nell" & _
    "a casella di testo"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'cboSezioni
        '
        Me.cboSezioni.AllowDrag = False
        Me.cboSezioni.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cboSezioni.AutoCompleteMode = Gizmox.WebGUI.Forms.AutoCompleteMode.Append
        Me.cboSezioni.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.Fixed3D
        Me.cboSezioni.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cboSezioni.FormattingEnabled = True
        Me.cboSezioni.Location = New System.Drawing.Point(372, 178)
        Me.cboSezioni.Name = "cboSezioni"
        Me.cboSezioni.Size = New System.Drawing.Size(93, 33)
        Me.cboSezioni.TabIndex = 3
        '
        'Label4
        '
        Me.Label4.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(214, 222)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(408, 50)
        Me.Label4.TabIndex = 2
        Me.Label4.Text = "Fare clic sul pulsante Verifica per ottenere lo stato della sezione"
        Me.Label4.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'cmdVerificaSezione
        '
        Me.cmdVerificaSezione.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.cmdVerificaSezione.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdVerificaSezione.Location = New System.Drawing.Point(361, 274)
        Me.cmdVerificaSezione.Name = "cmdVerificaSezione"
        Me.cmdVerificaSezione.Size = New System.Drawing.Size(115, 38)
        Me.cmdVerificaSezione.TabIndex = 4
        Me.cmdVerificaSezione.Text = "Verifica"
        '
        'lblStatoSezione
        '
        Me.lblStatoSezione.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.lblStatoSezione.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblStatoSezione.ForeColor = System.Drawing.Color.Green
        Me.lblStatoSezione.Location = New System.Drawing.Point(130, 328)
        Me.lblStatoSezione.Name = "lblStatoSezione"
        Me.lblStatoSezione.Size = New System.Drawing.Size(581, 111)
        Me.lblStatoSezione.TabIndex = 2
        Me.lblStatoSezione.Text = "Stato validità della sezione"
        Me.lblStatoSezione.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'imgStatoSezione
        '
        Me.imgStatoSezione.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.imgStatoSezione.BackColor = System.Drawing.Color.Transparent
        Me.imgStatoSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle(resources.GetString("imgStatoSezione.Image"))
        Me.imgStatoSezione.Location = New System.Drawing.Point(361, 442)
        Me.imgStatoSezione.Name = "imgStatoSezione"
        Me.imgStatoSezione.Size = New System.Drawing.Size(110, 182)
        Me.imgStatoSezione.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.StretchImage
        Me.imgStatoSezione.TabIndex = 5
        Me.imgStatoSezione.TabStop = False
        '
        'errorProvider
        '
        Me.errorProvider.BlinkRate = 3
        '
        'VerificaSezioni
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.imgStatoSezione)
        Me.Controls.Add(Me.lblStatoSezione)
        Me.Controls.Add(Me.cmdVerificaSezione)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.cboSezioni)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Panel1)
        Me.FormBorderStyle = Gizmox.WebGUI.Forms.FormBorderStyle.Sizable
        Me.Size = New System.Drawing.Size(889, 633)
        Me.Text = "VerificaSezioni"
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel1.ResumeLayout(False)
        CType(Me.imgStatoSezione, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cboSezioni As Gizmox.WebGUI.Forms.ComboBox
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdVerificaSezione As Gizmox.WebGUI.Forms.Button
    Friend WithEvents lblStatoSezione As Gizmox.WebGUI.Forms.Label
    Friend WithEvents imgStatoSezione As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents errorProvider As Gizmox.WebGUI.Forms.ErrorProvider

End Class