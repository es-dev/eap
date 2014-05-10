Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class StatoSezione
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
        Me.lblSezione = New Gizmox.WebGUI.Forms.Label()
        Me.grid = New Gizmox.WebGUI.Forms.DataGridView()
        Me.cmdClose = New Gizmox.WebGUI.Forms.Button()
        CType(Me.grid, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'lblSezione
        '
        Me.lblSezione.Anchor = CType(((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.lblSezione.BackColor = System.Drawing.Color.SteelBlue
        Me.lblSezione.BorderColor = New Gizmox.WebGUI.Forms.BorderColor(System.Drawing.Color.FromArgb(CType(CType(224, Byte), Integer), CType(CType(224, Byte), Integer), CType(CType(224, Byte), Integer)))
        Me.lblSezione.BorderStyle = Gizmox.WebGUI.Forms.BorderStyle.FixedSingle
        Me.lblSezione.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSezione.ForeColor = System.Drawing.Color.White
        Me.lblSezione.Location = New System.Drawing.Point(9, 9)
        Me.lblSezione.Name = "lblSezione"
        Me.lblSezione.Size = New System.Drawing.Size(620, 30)
        Me.lblSezione.TabIndex = 0
        Me.lblSezione.Text = "SEZIONE N."
        Me.lblSezione.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'grid
        '
        Me.grid.AllowUserToAddRows = False
        Me.grid.AllowUserToDeleteRows = False
        Me.grid.Anchor = CType((((Gizmox.WebGUI.Forms.AnchorStyles.Top Or Gizmox.WebGUI.Forms.AnchorStyles.Bottom) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Left) _
            Or Gizmox.WebGUI.Forms.AnchorStyles.Right), Gizmox.WebGUI.Forms.AnchorStyles)
        Me.grid.AutoSizeColumnsMode = Gizmox.WebGUI.Forms.DataGridViewAutoSizeColumnsMode.AllCells
        Me.grid.ColumnHeadersHeightSizeMode = Gizmox.WebGUI.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.grid.Location = New System.Drawing.Point(9, 50)
        Me.grid.Name = "grid"
        Me.grid.RowTemplate.DefaultCellStyle.FormatProvider = New System.Globalization.CultureInfo("it-IT")
        Me.grid.Size = New System.Drawing.Size(620, 198)
        Me.grid.TabIndex = 1
        '
        'cmdClose
        '
        Me.cmdClose.Anchor = Gizmox.WebGUI.Forms.AnchorStyles.Bottom
        Me.cmdClose.Location = New System.Drawing.Point(278, 265)
        Me.cmdClose.Name = "cmdClose"
        Me.cmdClose.Size = New System.Drawing.Size(75, 23)
        Me.cmdClose.TabIndex = 2
        Me.cmdClose.Text = "Chiudi"
        '
        'StatoSezione
        '
        Me.BackColor = System.Drawing.Color.White
        Me.Controls.Add(Me.cmdClose)
        Me.Controls.Add(Me.grid)
        Me.Controls.Add(Me.lblSezione)
        Me.FormBorderStyle = Gizmox.WebGUI.Forms.FormBorderStyle.Sizable
        Me.Size = New System.Drawing.Size(638, 297)
        Me.Text = "Stato Sezione"
        CType(Me.grid, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents lblSezione As Gizmox.WebGUI.Forms.Label
    Friend WithEvents grid As Gizmox.WebGUI.Forms.DataGridView
    Friend WithEvents cmdClose As Gizmox.WebGUI.Forms.Button

End Class