Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

Public Class VerificaSezioni


    Private Sub VerificaSezioni_Load(sender As Object, e As System.EventArgs) Handles Me.Load
        Try
            InitConsultazioni()
            HideStato()
            LoadSezioni()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private consultazioni As New Hashtable
    Private Sub InitConsultazioni()
        Try
            Dim IDs As New List(Of Integer)
            IDs.Add(17)
            Dim scrutinioSezioni As New Scrutinio
            For Each IDConsultazioneGenerale In IDs
                Dim consultazione = scrutinioSezioni.GetConsultazione(IDConsultazioneGenerale)
                consultazioni.Add(IDConsultazioneGenerale, consultazione)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub HideStato()
        Try
            lblStatoSezione.Visible = False
            imgStatoSezione.Visible = False

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadSezioni()
        Try
            cboSezioni.Items.Clear()
            For i = 1 To 82
                cboSezioni.Items.Add(i)

            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdVerificaSezione_Click(sender As System.Object, e As System.EventArgs) Handles cmdVerificaSezione.Click
        Try
            errorProvider.SetError(cboSezioni, Nothing)
            If (cboSezioni.SelectedItem IsNot Nothing) Then
                Dim numeroSezione = cboSezioni.SelectedItem
                If (numeroSezione >= 1 And numeroSezione <= 82) Then
                    Dim stato = GetStatoSezione(numeroSezione, consultazioni)
                    If (stato = "OK") Then
                        imgStatoSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle("semaforo_verde.jpg")
                        lblStatoSezione.Text = "La sezione corrente è stata VALIDATA. Tutti i dati risultano correttamente registrati in archivio. Grazie per la collaborazione!"
                        lblStatoSezione.ForeColor = Color.Green
                    ElseIf (stato = "PARTIALDATA") Then
                        imgStatoSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle("semaforo_giallo.jpg")
                        lblStatoSezione.Text = "La sezione corrente NON è stata validata. Fase di caricamento dati o di validazione in corso"
                        lblStatoSezione.ForeColor = Color.Red
                    ElseIf (stato = "") Then
                        imgStatoSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle("semaforo_giallo.jpg")
                        lblStatoSezione.Text = "La sezione corrente NON è stata validata. Non risultano dati caricati"
                        lblStatoSezione.ForeColor = Color.Red
                    Else
                        imgStatoSezione.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle("semaforo_rosso.jpg")
                        lblStatoSezione.Text = "La sezione corrente NON è stata VALIDATA. " + stato
                        lblStatoSezione.ForeColor = Color.Red
                    End If
                    lblStatoSezione.Visible = True
                    imgStatoSezione.Visible = True
                Else
                    errorProvider.SetError(cboSezioni, "Il numero di sezione deve essere compreso tra 1 e 82")

                End If
            Else
                errorProvider.SetError(cboSezioni, "Occorre selezionare o indicare un numero di sezione")

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function GetStatoSezione(numeroSezione As Integer, consultazioni As Hashtable) As String
        Try
            Dim stato = ""
            Dim consultazioniOK = 0
            Dim scrutinioSezioni As New Scrutinio
            For Each IDConsultazione In consultazioni.Keys
                Dim consultazione As String = consultazioni(IDConsultazione)
                Dim IDSezione = scrutinioSezioni.GetIDSezione(IDConsultazione, numeroSezione)
                Dim statoSezione = scrutinioSezioni.GetStatoSezione(IDConsultazione, IDSezione, consultazione)
                stato = statoSezione
                If (statoSezione <> "OK" And statoSezione <> "") Then
                    Return stato
                End If
                If (statoSezione = "OK") Then
                    consultazioniOK += 1
                End If
            Next
            If (consultazioniOK > 0 And consultazioniOK < consultazioni.Count) Then
                stato = "PARTIALDATA"
            End If
            Return stato

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub cboSezioni_MouseClick(sender As Object, e As Gizmox.WebGUI.Forms.MouseEventArgs) Handles cboSezioni.MouseClick
        Try
            HideStato()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

   
End Class
