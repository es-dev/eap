Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class StatoConsultazioneReferendum
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
        Me.lblConsultazione = New Gizmox.WebGUI.Forms.Label()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.txtSI = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtNO = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.Label4 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotaleValidi = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtContestati = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label5 = New Gizmox.WebGUI.Forms.Label()
        Me.Label6 = New Gizmox.WebGUI.Forms.Label()
        Me.txtBianche = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtNulle = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label7 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotaleComplessivo = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label8 = New Gizmox.WebGUI.Forms.Label()
        Me.txtTotaleVotanti = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label9 = New Gizmox.WebGUI.Forms.Label()
        Me.Label10 = New Gizmox.WebGUI.Forms.Label()
        Me.txtFemmine = New Gizmox.WebGUI.Forms.TextBox()
        Me.txtMaschi = New Gizmox.WebGUI.Forms.TextBox()
        Me.Label11 = New Gizmox.WebGUI.Forms.Label()
        Me.Label12 = New Gizmox.WebGUI.Forms.Label()
        Me.Label13 = New Gizmox.WebGUI.Forms.Label()
        Me.lblSezioniScrutinate = New Gizmox.WebGUI.Forms.Label()
        Me.cmdClose = New Gizmox.WebGUI.Forms.Button()
        Me.errProvider = New Gizmox.WebGUI.Forms.ErrorProvider()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.SuspendLayout()
        '
        'lblConsultazione
        '
        Me.lblConsultazione.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblConsultazione.BackColor = System.Drawing.Color.SteelBlue
        Me.lblConsultazione.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.FromArgb(CType(CType(224, Byte), Integer), CType(CType(224, Byte), Integer), CType(CType(224, Byte), Integer)))
        Me.lblConsultazione.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.lblConsultazione.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblConsultazione.ForeColor = System.Drawing.Color.White
        Me.lblConsultazione.Location = New System.Drawing.Point(9, 9)
        Me.lblConsultazione.Name = "lblConsultazione"
        Me.lblConsultazione.Size = New System.Drawing.Size(406, 30)
        Me.lblConsultazione.TabIndex = 0
        Me.lblConsultazione.Text = "CONSULTAZIONE N."
        Me.lblConsultazione.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label2
        '
        Me.Label2.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(26, 87)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(159, 23)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "Voti Validi SI"
        '
        'txtSI
        '
        Me.txtSI.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtSI.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtSI.Location = New System.Drawing.Point(209, 86)
        Me.txtSI.Name = "txtSI"
        Me.txtSI.Size = New System.Drawing.Size(100, 20)
        Me.txtSI.TabIndex = 1
        Me.txtSI.Text = "0"
        Me.txtSI.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'txtNO
        '
        Me.txtNO.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtNO.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtNO.Location = New System.Drawing.Point(209, 112)
        Me.txtNO.Name = "txtNO"
        Me.txtNO.Size = New System.Drawing.Size(100, 20)
        Me.txtNO.TabIndex = 1
        Me.txtNO.Text = "0"
        Me.txtNO.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label3
        '
        Me.Label3.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label3.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(26, 113)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(159, 23)
        Me.Label3.TabIndex = 0
        Me.Label3.Text = "Voti Validi NO"
        '
        'Label4
        '
        Me.Label4.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label4.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(26, 139)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(159, 23)
        Me.Label4.TabIndex = 0
        Me.Label4.Text = "Totale Voti Validi (A)"
        '
        'txtTotaleValidi
        '
        Me.txtTotaleValidi.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtTotaleValidi.BackColor = System.Drawing.Color.LemonChiffon
        Me.txtTotaleValidi.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtTotaleValidi.Location = New System.Drawing.Point(209, 138)
        Me.txtTotaleValidi.Name = "txtTotaleValidi"
        Me.txtTotaleValidi.Size = New System.Drawing.Size(100, 20)
        Me.txtTotaleValidi.TabIndex = 1
        Me.txtTotaleValidi.Text = "0"
        Me.txtTotaleValidi.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'txtContestati
        '
        Me.txtContestati.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtContestati.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtContestati.Location = New System.Drawing.Point(209, 164)
        Me.txtContestati.Name = "txtContestati"
        Me.txtContestati.Size = New System.Drawing.Size(100, 20)
        Me.txtContestati.TabIndex = 1
        Me.txtContestati.Text = "0"
        Me.txtContestati.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label5
        '
        Me.Label5.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label5.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(26, 165)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(159, 23)
        Me.Label5.TabIndex = 0
        Me.Label5.Text = "Contestati (B)"
        '
        'Label6
        '
        Me.Label6.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label6.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(26, 191)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(159, 23)
        Me.Label6.TabIndex = 0
        Me.Label6.Text = "Schede Bianche (C)"
        '
        'txtBianche
        '
        Me.txtBianche.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtBianche.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtBianche.Location = New System.Drawing.Point(209, 190)
        Me.txtBianche.Name = "txtBianche"
        Me.txtBianche.Size = New System.Drawing.Size(100, 20)
        Me.txtBianche.TabIndex = 1
        Me.txtBianche.Text = "0"
        Me.txtBianche.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'txtNulle
        '
        Me.txtNulle.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtNulle.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtNulle.Location = New System.Drawing.Point(209, 216)
        Me.txtNulle.Name = "txtNulle"
        Me.txtNulle.Size = New System.Drawing.Size(100, 20)
        Me.txtNulle.TabIndex = 1
        Me.txtNulle.Text = "0"
        Me.txtNulle.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label7
        '
        Me.Label7.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label7.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.Location = New System.Drawing.Point(26, 217)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(159, 23)
        Me.Label7.TabIndex = 0
        Me.Label7.Text = "Schede Nulle (D)"
        '
        'txtTotaleComplessivo
        '
        Me.txtTotaleComplessivo.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtTotaleComplessivo.BackColor = System.Drawing.Color.LemonChiffon
        Me.txtTotaleComplessivo.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtTotaleComplessivo.Location = New System.Drawing.Point(209, 242)
        Me.txtTotaleComplessivo.Name = "txtTotaleComplessivo"
        Me.txtTotaleComplessivo.Size = New System.Drawing.Size(100, 20)
        Me.txtTotaleComplessivo.TabIndex = 1
        Me.txtTotaleComplessivo.Text = "0"
        Me.txtTotaleComplessivo.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label8
        '
        Me.Label8.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label8.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label8.Location = New System.Drawing.Point(26, 243)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(159, 23)
        Me.Label8.TabIndex = 0
        Me.Label8.Text = "Totale Complessivo (E)"
        '
        'txtTotaleVotanti
        '
        Me.txtTotaleVotanti.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtTotaleVotanti.BackColor = System.Drawing.Color.LemonChiffon
        Me.txtTotaleVotanti.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtTotaleVotanti.Location = New System.Drawing.Point(209, 330)
        Me.txtTotaleVotanti.Name = "txtTotaleVotanti"
        Me.txtTotaleVotanti.Size = New System.Drawing.Size(100, 20)
        Me.txtTotaleVotanti.TabIndex = 1
        Me.txtTotaleVotanti.Text = "0"
        Me.txtTotaleVotanti.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label9
        '
        Me.Label9.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label9.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label9.Location = New System.Drawing.Point(26, 331)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(159, 23)
        Me.Label9.TabIndex = 0
        Me.Label9.Text = "Totale Votanti (F)"
        '
        'Label10
        '
        Me.Label10.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label10.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label10.Location = New System.Drawing.Point(26, 305)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(159, 23)
        Me.Label10.TabIndex = 0
        Me.Label10.Text = "Votanti Femmine"
        '
        'txtFemmine
        '
        Me.txtFemmine.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtFemmine.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtFemmine.Location = New System.Drawing.Point(209, 304)
        Me.txtFemmine.Name = "txtFemmine"
        Me.txtFemmine.Size = New System.Drawing.Size(100, 20)
        Me.txtFemmine.TabIndex = 1
        Me.txtFemmine.Text = "0"
        Me.txtFemmine.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'txtMaschi
        '
        Me.txtMaschi.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.txtMaschi.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtMaschi.Location = New System.Drawing.Point(209, 278)
        Me.txtMaschi.Name = "txtMaschi"
        Me.txtMaschi.Size = New System.Drawing.Size(100, 20)
        Me.txtMaschi.TabIndex = 1
        Me.txtMaschi.Text = "0"
        Me.txtMaschi.TextAlign = Gizmox.WebGUI.Forms.HorizontalAlignment.Center
        '
        'Label11
        '
        Me.Label11.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label11.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label11.Location = New System.Drawing.Point(26, 279)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(159, 23)
        Me.Label11.TabIndex = 0
        Me.Label11.Text = "Votanti Maschi"
        '
        'Label12
        '
        Me.Label12.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label12.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.Location = New System.Drawing.Point(312, 243)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(99, 23)
        Me.Label12.TabIndex = 0
        Me.Label12.Text = "= A+B+C+D"
        '
        'Label13
        '
        Me.Label13.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label13.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.Location = New System.Drawing.Point(312, 331)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(99, 23)
        Me.Label13.TabIndex = 0
        Me.Label13.Text = "= E"
        '
        'lblSezioniScrutinate
        '
        Me.lblSezioniScrutinate.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezioniScrutinate.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniScrutinate.Location = New System.Drawing.Point(9, 48)
        Me.lblSezioniScrutinate.Name = "lblSezioniScrutinate"
        Me.lblSezioniScrutinate.Size = New System.Drawing.Size(406, 23)
        Me.lblSezioniScrutinate.TabIndex = 0
        Me.lblSezioniScrutinate.Text = "Sezione Scrutinate n. 0 su 82"
        Me.lblSezioniScrutinate.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'cmdClose
        '
        Me.cmdClose.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Bottom
        Me.cmdClose.Location = New System.Drawing.Point(175, 371)
        Me.cmdClose.Name = "cmdClose"
        Me.cmdClose.Size = New System.Drawing.Size(75, 23)
        Me.cmdClose.TabIndex = 2
        Me.cmdClose.Text = "Chiudi"
        '
        'errProvider
        '
        Me.errProvider.BlinkRate = 3
        Me.errProvider.BlinkStyle = Gizmox.WebGUI.Forms.ErrorBlinkStyle.BlinkIfDifferentError
        '
        'Label1
        '
        Me.Label1.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Top
        Me.Label1.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(316, 139)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(99, 23)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "= SI + NO"
        '
        'StatoConsultazioneReferendum
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.cmdClose)
        Me.Controls.Add(Me.lblSezioniScrutinate)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.Label12)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.txtMaschi)
        Me.Controls.Add(Me.txtFemmine)
        Me.Controls.Add(Me.Label10)
        Me.Controls.Add(Me.Label9)
        Me.Controls.Add(Me.txtTotaleVotanti)
        Me.Controls.Add(Me.Label8)
        Me.Controls.Add(Me.txtTotaleComplessivo)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.txtNulle)
        Me.Controls.Add(Me.txtBianche)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.txtContestati)
        Me.Controls.Add(Me.txtTotaleValidi)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.txtNO)
        Me.Controls.Add(Me.txtSI)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.lblConsultazione)
        Me.Size = New System.Drawing.Size(424, 403)
        Me.Text = "Stato Consultazione Referendum"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents lblConsultazione As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtSI As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtNO As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label4 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotaleValidi As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtContestati As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label5 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label6 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtBianche As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtNulle As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label7 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotaleComplessivo As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label8 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtTotaleVotanti As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label9 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label10 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents txtFemmine As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents txtMaschi As Gizmox.WebGUI.Forms.TextBox
    Friend WithEvents Label11 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label12 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label13 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lblSezioniScrutinate As Gizmox.WebGUI.Forms.Label
    Friend WithEvents cmdClose As Gizmox.WebGUI.Forms.Button
    Friend WithEvents errProvider As Gizmox.WebGUI.Forms.ErrorProvider
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label

End Class