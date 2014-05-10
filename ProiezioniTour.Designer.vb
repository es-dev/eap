Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ProiezioniTour
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
        Me.htmlBox = New Gizmox.WebGUI.Forms.HtmlBox()
        Me.timerRefresh = New Gizmox.WebGUI.Forms.Timer()
        Me.GroupBox1 = New Gizmox.WebGUI.Forms.GroupBox()
        Me.cmdNextPage = New Gizmox.WebGUI.Forms.Button()
        Me.cmdTour = New Gizmox.WebGUI.Forms.Button()
        Me.lblAggiornamento = New Gizmox.WebGUI.Forms.Label()
        Me.GroupBox1.SuspendLayout()
        Me.SuspendLayout()
        '
        'htmlBox
        '
        Me.htmlBox.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.htmlBox.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.Gray)
        Me.htmlBox.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.None
        Me.htmlBox.ContentType = "text/html"
        Me.htmlBox.Expires = -1
        Me.htmlBox.Html = "<HTML>No content.</HTML>"
        Me.htmlBox.Location = New System.Drawing.Point(-2, 49)
        Me.htmlBox.Name = "htmlBox"
        Me.htmlBox.Size = New System.Drawing.Size(852, 499)
        Me.htmlBox.TabIndex = 0
        '
        'timerRefresh
        '
        Me.timerRefresh.Enabled = True
        Me.timerRefresh.Interval = 60000
        '
        'GroupBox1
        '
        Me.GroupBox1.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.GroupBox1.Controls.Add(Me.lblAggiornamento)
        Me.GroupBox1.Controls.Add(Me.cmdTour)
        Me.GroupBox1.Controls.Add(Me.cmdNextPage)
        Me.GroupBox1.FlatStyle = Gizmox.WebGUI.Forms.FlatStyle.Flat
        Me.GroupBox1.Location = New System.Drawing.Point(0, 0)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(850, 49)
        Me.GroupBox1.TabIndex = 1
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = "TourBox"
        '
        'cmdNextPage
        '
        Me.cmdNextPage.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdNextPage.Location = New System.Drawing.Point(677, 17)
        Me.cmdNextPage.Name = "cmdNextPage"
        Me.cmdNextPage.Size = New System.Drawing.Size(164, 23)
        Me.cmdNextPage.TabIndex = 0
        Me.cmdNextPage.Text = "Schermata successiva >>"
        '
        'cmdTour
        '
        Me.cmdTour.Anchor = CType((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.cmdTour.Location = New System.Drawing.Point(572, 17)
        Me.cmdTour.Name = "cmdTour"
        Me.cmdTour.Size = New System.Drawing.Size(94, 23)
        Me.cmdTour.TabIndex = 1
        Me.cmdTour.Text = "Ferma il tour"
        '
        'lblAggiornamento
        '
        Me.lblAggiornamento.AutoSize = True
        Me.lblAggiornamento.Font = New System.Drawing.Font("Tahoma", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblAggiornamento.ForeColor = System.Drawing.Color.Red
        Me.lblAggiornamento.Location = New System.Drawing.Point(21, 16)
        Me.lblAggiornamento.Name = "lblAggiornamento"
        Me.lblAggiornamento.Size = New System.Drawing.Size(533, 23)
        Me.lblAggiornamento.TabIndex = 2
        Me.lblAggiornamento.Text = "Ultimo aggiornamento  --/--/---- --.--"
        '
        'ProiezioniTour
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.GroupBox1)
        Me.Controls.Add(Me.htmlBox)
        Me.Size = New System.Drawing.Size(850, 548)
        Me.Text = "ProiezioniTour"
        Me.RegisteredTimers = New Gizmox.WebGUI.Forms.Timer() {Me.timerRefresh}
        Me.GroupBox1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents htmlBox As Gizmox.WebGUI.Forms.HtmlBox
    Friend WithEvents timerRefresh As Gizmox.WebGUI.Forms.Timer
    Friend WithEvents GroupBox1 As Gizmox.WebGUI.Forms.GroupBox
    Friend WithEvents cmdTour As Gizmox.WebGUI.Forms.Button
    Friend WithEvents cmdNextPage As Gizmox.WebGUI.Forms.Button
    Friend WithEvents lblAggiornamento As Gizmox.WebGUI.Forms.Label

End Class