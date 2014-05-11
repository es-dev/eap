Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common


Public Class MonitorSezioneRow

    Public Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        
    End Sub

    Public NumeroSezione As Integer = -1
    Private consultazioni = Nothing

    Public Sub New(numeroSezione As Integer, consultazioni As Hashtable)

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            MyClass.consultazioni = consultazioni
            MyClass.NumeroSezione = numeroSezione
            lblSezione.Text = numeroSezione.ToString

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Sub SetStato(stato As String)
        Try
            If (stato = "OK") Then
                lblSezione.ForeColor = Color.Green
                imgSezione.Image = New Resources.ImageResourceHandle("sede_elettorale_ok.jpg")
            ElseIf (stato = "PARTIALDATA") Then
                lblSezione.ForeColor = Color.Black
                imgSezione.Image = New Resources.ImageResourceHandle("sede_elettorale_working.jpg")
            ElseIf (stato = "") Then
                lblSezione.ForeColor = Color.Black
                imgSezione.Image = New Resources.ImageResourceHandle("sede_elettorale.jpg")
            Else
                lblSezione.ForeColor = Color.Red
                imgSezione.Image = New Resources.ImageResourceHandle("sede_elettorale_allarme.jpg")
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub imgSezione_Click(sender As System.Object, e As System.EventArgs) Handles imgSezione.Click
        Try
            Dim statoSezione As New StatoSezione(NumeroSezione, consultazioni)
            statoSezione.ShowDialog()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
