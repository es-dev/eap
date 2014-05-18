<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class eStart
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(eStart))
        Me.Panel1 = New Gizmox.WebGUI.Forms.Panel()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.PictureBox1 = New Gizmox.WebGUI.Forms.PictureBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdStatoAffluenze = New Gizmox.WebGUI.Forms.Button()
        Me.cmdStatoVoti = New Gizmox.WebGUI.Forms.Button()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdMonitor = New Gizmox.WebGUI.Forms.Button()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdLogout = New Gizmox.WebGUI.Forms.Button()
        Me.Label6 = New Gizmox.WebGUI.Forms.Label()
        Me.Label7 = New Gizmox.WebGUI.Forms.Label()
        Me.cmdEnableOperators = New Gizmox.WebGUI.Forms.Button()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Panel2 = New Gizmox.WebGUI.Forms.Panel()
        Me.Panel1.SuspendLayout()
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
        Me.Panel1.Size = New System.Drawing.Size(893, 90)
        Me.Panel1.TabIndex = 1
        '
        'Label8
        '
        Me.Label8.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(660, 64)
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
        Me.PictureBox1.Location = New System.Drawing.Point(825, 3)
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
        'cmdStatoAffluenze
        '
        Me.cmdStatoAffluenze.BackColor = System.Drawing.Color.Beige
        Me.cmdStatoAffluenze.CustomStyle = "F"
        Me.cmdStatoAffluenze.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdStatoAffluenze.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdStatoAffluenze.Location = New System.Drawing.Point(188, 160)
        Me.cmdStatoAffluenze.Name = "cmdStatoAffluenze"
        Me.cmdStatoAffluenze.Size = New System.Drawing.Size(299, 43)
        Me.cmdStatoAffluenze.TabIndex = 3
        Me.cmdStatoAffluenze.Text = "Stato Affluenze"
        '
        'cmdStatoVoti
        '
        Me.cmdStatoVoti.BackColor = System.Drawing.Color.Beige
        Me.cmdStatoVoti.CustomStyle = "F"
        Me.cmdStatoVoti.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdStatoVoti.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdStatoVoti.Location = New System.Drawing.Point(188, 252)
        Me.cmdStatoVoti.Name = "cmdStatoVoti"
        Me.cmdStatoVoti.Size = New System.Drawing.Size(299, 43)
        Me.cmdStatoVoti.TabIndex = 3
        Me.cmdStatoVoti.Text = "Spoglio Elettorale"
        '
        'Label2
        '
        Me.Label2.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(506, 160)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(321, 43)
        Me.Label2.TabIndex = 1
        Me.Label2.Text = "Consente di avere in tempo reale le affluenze suddivise per sezioni, uomini, donn" & _
    "e, percentuali ..."
        '
        'Label4
        '
        Me.Label4.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(506, 252)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(321, 43)
        Me.Label4.TabIndex = 1
        Me.Label4.Text = "Permette di visualizzazione in real-time i dati di scrutinio per collegio, sezion" & _
    "i, liste, candidati, schede..."
        '
        'cmdMonitor
        '
        Me.cmdMonitor.BackColor = System.Drawing.Color.Beige
        Me.cmdMonitor.CustomStyle = "F"
        Me.cmdMonitor.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdMonitor.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdMonitor.Location = New System.Drawing.Point(188, 344)
        Me.cmdMonitor.Name = "cmdMonitor"
        Me.cmdMonitor.Size = New System.Drawing.Size(299, 43)
        Me.cmdMonitor.TabIndex = 3
        Me.cmdMonitor.Text = "Monitor Sezioni"
        '
        'Label5
        '
        Me.Label5.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(506, 344)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(321, 43)
        Me.Label5.TabIndex = 1
        Me.Label5.Text = "Consente il monitoraggio delle sezioni e la gestione di più consultazioni simulta" & _
    "nee, export dei dati e reports ..."
        '
        'cmdLogout
        '
        Me.cmdLogout.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdLogout.BackColor = System.Drawing.Color.Ivory
        Me.cmdLogout.CustomStyle = "F"
        Me.cmdLogout.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdLogout.Location = New System.Drawing.Point(746, 473)
        Me.cmdLogout.Name = "cmdLogout"
        Me.cmdLogout.Size = New System.Drawing.Size(135, 23)
        Me.cmdLogout.TabIndex = 4
        Me.cmdLogout.Text = "Disconnetti (Esci)"
        '
        'Label6
        '
        Me.Label6.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label6.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(582, 93)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(307, 25)
        Me.Label6.TabIndex = 0
        Me.Label6.Text = "ACCESSO SPECIALE - PREFETTURA"
        Me.Label6.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'Label7
        '
        Me.Label7.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.Label7.Font = New System.Drawing.Font("Tahoma", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.Location = New System.Drawing.Point(506, 426)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(321, 43)
        Me.Label7.TabIndex = 1
        Me.Label7.Text = "Consente di abilitare o disabilitare l'accesso degli operatori al sistema EAP ..." & _
    ""
        '
        'cmdEnableOperators
        '
        Me.cmdEnableOperators.BackColor = System.Drawing.Color.Beige
        Me.cmdEnableOperators.CustomStyle = "F"
        Me.cmdEnableOperators.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.cmdEnableOperators.Font = New System.Drawing.Font("Tahoma", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.cmdEnableOperators.Location = New System.Drawing.Point(188, 426)
        Me.cmdEnableOperators.Name = "cmdEnableOperators"
        Me.cmdEnableOperators.Size = New System.Drawing.Size(299, 43)
        Me.cmdEnableOperators.TabIndex = 3
        Me.cmdEnableOperators.Text = "Abilita/Disabilita Operatori"
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
        Me.Panel2.Location = New System.Drawing.Point(0, 502)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(893, 46)
        Me.Panel2.TabIndex = 1
        '
        'eStart
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.cmdEnableOperators)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.cmdLogout)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.cmdMonitor)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.cmdStatoVoti)
        Me.Controls.Add(Me.cmdStatoAffluenze)
        Me.Controls.Add(Me.Panel1)
        Me.Size = New System.Drawing.Size(893, 548)
        Me.Text = "EAP - Elezioni OnLine - Homepage"
        Me.Panel1.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As Gizmox.WebGUI.Forms.Panel
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents PictureBox1 As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdStatoAffluenze As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdStatoVoti As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdMonitor As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdLogout As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label6 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label7 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdEnableOperators As Gizmox.WebGUI.Forms.Button
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Panel2 As Gizmox.WebGUI.Forms.Panel

End Class