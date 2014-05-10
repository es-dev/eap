Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ProiezioneCandidati
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(ProiezioneCandidati))
        Me.panelCandidati = New Gizmox.WebGUI.Forms.FlowLayoutPanel()
        Me.timerVotazioni = New Gizmox.WebGUI.Forms.Timer()
        Me.lblSezioniScrutinate = New Gizmox.WebGUI.Forms.Label()
        Me.Label2 = New Gizmox.WebGUI.Forms.Label()
        Me.lnkRefresh = New Gizmox.WebGUI.Forms.LinkLabel()
        Me.Label1 = New Gizmox.WebGUI.Forms.Label()
        Me.lblTimeUpgrade = New Gizmox.WebGUI.Forms.Label()
        Me.Label3 = New Gizmox.WebGUI.Forms.Label()
        Me.SuspendLayout()
        '
        'panelCandidati
        '
        Me.panelCandidati.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.Gainsboro)
        Me.panelCandidati.Location = New System.Drawing.Point(9, 75)
        Me.panelCandidati.Name = "panelCandidati"
        Me.panelCandidati.Size = New System.Drawing.Size(697, 293)
        Me.panelCandidati.TabIndex = 0
        '
        'timerVotazioni
        '
        Me.timerVotazioni.Enabled = True
        Me.timerVotazioni.Interval = 60000
        '
        'lblSezioniScrutinate
        '
        Me.lblSezioniScrutinate.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezioniScrutinate.ForeColor = System.Drawing.Color.Blue
        Me.lblSezioniScrutinate.Location = New System.Drawing.Point(9, 3)
        Me.lblSezioniScrutinate.Name = "lblSezioniScrutinate"
        Me.lblSezioniScrutinate.Size = New System.Drawing.Size(697, 23)
        Me.lblSezioniScrutinate.TabIndex = 1
        Me.lblSezioniScrutinate.Text = "Sezioni scrutinate 0 su 82"
        Me.lblSezioniScrutinate.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'Label2
        '
        Me.Label2.Location = New System.Drawing.Point(9, 378)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(697, 34)
        Me.Label2.TabIndex = 2
        Me.Label2.Text = resources.GetString("Label2.Text")
        '
        'lnkRefresh
        '
        Me.lnkRefresh.ClientMode = False
        Me.lnkRefresh.LinkColor = System.Drawing.Color.Blue
        Me.lnkRefresh.Location = New System.Drawing.Point(555, 410)
        Me.lnkRefresh.Name = "lnkRefresh"
        Me.lnkRefresh.Size = New System.Drawing.Size(57, 15)
        Me.lnkRefresh.TabIndex = 3
        Me.lnkRefresh.TabStop = True
        Me.lnkRefresh.Text = "Refresh"
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(9, 412)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(195, 15)
        Me.Label1.TabIndex = 2
        Me.Label1.Text = "Ultimo aggiornamento ricevuto alle ore"
        '
        'lblTimeUpgrade
        '
        Me.lblTimeUpgrade.Font = New System.Drawing.Font("Tahoma", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblTimeUpgrade.ForeColor = System.Drawing.Color.Red
        Me.lblTimeUpgrade.Location = New System.Drawing.Point(204, 412)
        Me.lblTimeUpgrade.Name = "lblTimeUpgrade"
        Me.lblTimeUpgrade.Size = New System.Drawing.Size(98, 13)
        Me.lblTimeUpgrade.TabIndex = 4
        Me.lblTimeUpgrade.Text = "--.-- [hh.mm]"
        '
        'Label3
        '
        Me.Label3.Location = New System.Drawing.Point(302, 412)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(253, 15)
        Me.Label3.TabIndex = 2
        Me.Label3.Text = "E' possibile forzare l'aggiornamento facendo clic su "
        '
        'ProiezioneCandidati
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.lblTimeUpgrade)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.lnkRefresh)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.lblSezioniScrutinate)
        Me.Controls.Add(Me.panelCandidati)
        Me.Size = New System.Drawing.Size(716, 553)
        Me.Text = "ProiezioneCandidati"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.timerVotazioni}
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents panelCandidati As Gizmox.WebGUI.Forms.FlowLayoutPanel
    Friend WithEvents timerVotazioni As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents lblSezioniScrutinate As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label2 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lnkRefresh As Gizmox.WebGUI.Forms.LinkLabel
    Friend WithEvents Label1 As Gizmox.WebGUI.Forms.Label
    Friend WithEvents lblTimeUpgrade As Gizmox.WebGUI.Forms.Label
    Friend WithEvents Label3 As Gizmox.WebGUI.Forms.Label

End Class