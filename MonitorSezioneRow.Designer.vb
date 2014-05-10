Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class MonitorSezioneRow
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(MonitorSezioneRow))
        Me.lblSezione = New Gizmox.WebGUI.Forms.Label()
        Me.imgSezione = New Gizmox.WebGUI.Forms.PictureBox()
        Me.errProvider = New Gizmox.WebGUI.Forms.ErrorProvider()
        Me.SuspendLayout()
        '
        'lblSezione
        '
        Me.lblSezione.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezione.Font = New System.Drawing.Font("Tahoma", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezione.Location = New System.Drawing.Point(0, 0)
        Me.lblSezione.Name = "lblSezione"
        Me.lblSezione.Size = New System.Drawing.Size(54, 16)
        Me.lblSezione.TabIndex = 0
        Me.lblSezione.Text = "0"
        Me.lblSezione.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'imgSezione
        '
        Me.imgSezione.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.imgSezione.BackColor = System.Drawing.Color.White
        Me.imgSezione.Cursor = Gizmox.WebGUI.Forms.Cursors.Hand
        Me.imgSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle(resources.GetString("imgSezione.Image"))
        Me.imgSezione.Location = New System.Drawing.Point(4, 16)
        Me.imgSezione.Name = "imgSezione"
        Me.imgSezione.Size = New System.Drawing.Size(42, 38)
        Me.imgSezione.SizeMode = Gizmox.WebGUI.Forms.PictureBoxSizeMode.StretchImage
        Me.imgSezione.TabIndex = 1
        Me.imgSezione.TabStop = False
        '
        'errProvider
        '
        Me.errProvider.BlinkRate = 3
        Me.errProvider.BlinkStyle = Gizmox.WebGUI.Forms.ErrorBlinkStyle.BlinkIfDifferentError
        '
        'MonitorSezioneRow
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.imgSezione)
        Me.Controls.Add(Me.lblSezione)
        Me.Size = New System.Drawing.Size(50, 70)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents lblSezione As Gizmox.WebGUI.Forms.Label
    Friend WithEvents imgSezione As Gizmox.WebGUI.Forms.PictureBox
    Friend WithEvents errProvider As Gizmox.WebGUI.Forms.ErrorProvider

End Class
