Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ProiezioneCandidatoRow
    Inherits Gizmox.WebGui.Forms.UserControl

    'UserControl1 overrides dispose to clean up the component list.
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
        Me.imgCandidato = New Gizmox.WebGUI.Forms.PictureBox()
        Me.lblNomeCandidato = New Gizmox.WebGUI.Forms.Label()
        Me.lblVotoCandidato = New Gizmox.WebGUI.Forms.Label()
        Me.errProvider = New Gizmox.WebGUI.Forms.ErrorProvider()
        Me.SuspendLayout()
        '
        'imgCandidato
        '
        Me.imgCandidato.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.None
        Me.imgCandidato.BackColor = System.Drawing.Color.White
        Me.imgCandidato.Location = New System.Drawing.Point(119, 49)
        Me.imgCandidato.Name = "imgCandidato"
        Me.imgCandidato.Size = New System.Drawing.Size(90, 144)
        Me.imgCandidato.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.StretchImage
        Me.imgCandidato.TabIndex = 0
        Me.imgCandidato.TabStop = False
        '
        'lblNomeCandidato
        '
        Me.lblNomeCandidato.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblNomeCandidato.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblNomeCandidato.Location = New System.Drawing.Point(0, 1)
        Me.lblNomeCandidato.Name = "lblNomeCandidato"
        Me.lblNomeCandidato.Size = New System.Drawing.Size(330, 23)
        Me.lblNomeCandidato.TabIndex = 1
        Me.lblNomeCandidato.Text = "0 - nome COGNOME"
        Me.lblNomeCandidato.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'lblVotoCandidato
        '
        Me.lblVotoCandidato.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Bottom Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblVotoCandidato.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblVotoCandidato.ForeColor = System.Drawing.Color.Red
        Me.lblVotoCandidato.Location = New System.Drawing.Point(0, 214)
        Me.lblVotoCandidato.Name = "lblVotoCandidato"
        Me.lblVotoCandidato.Size = New System.Drawing.Size(330, 40)
        Me.lblVotoCandidato.TabIndex = 1
        Me.lblVotoCandidato.Text = "0% (-)"
        Me.lblVotoCandidato.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'errProvider
        '
        Me.errProvider.BlinkRate = 6
        Me.errProvider.BlinkStyle = Gizmox.WebGUI.Forms.ErrorBlinkStyle.BlinkIfDifferentError
        '
        'ProiezioneCandidatoRow
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.lblVotoCandidato)
        Me.Controls.Add(Me.lblNomeCandidato)
        Me.Controls.Add(Me.imgCandidato)
        Me.Size = New System.Drawing.Size(333, 254)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents imgCandidato As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents lblNomeCandidato As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lblVotoCandidato As Gizmox.WebGUI.Forms.Label
    Friend WithEvents errProvider As Gizmox.WebGUI.Forms.ErrorProvider

End Class
