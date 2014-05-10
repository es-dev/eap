Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common


Public Class ProiezioneCandidati


    Public Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ProiezioneCandidati_Load(sender As Object, e As System.EventArgs) Handles Me.Load
        Try
            LoadCandidati()
            AggiornaCandidati()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private IDConsultazione = 5
    Private consultazione = "Ballottaggio 2011"

    Private Sub LoadCandidati()
        Try
            Dim adapter As New EAP2TableAdapters.soraldo_ele_gruppoTableAdapter
            Dim table = adapter.GetDataByIDConsultazione(IDConsultazione)
            panelCandidati.Controls.Clear()
            For Each row In table
                Dim numero = row.num_gruppo
                Dim nomeCandidato = row.descrizione
                Dim IDGruppo = row.id_gruppo
                Dim candidato As New ProiezioneCandidatoRow(IDGruppo, numero, nomeCandidato)
                panelCandidati.Controls.Add(candidato)

            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub AggiornaCandidati()
        Try
            Dim spoglio As New Scrutinio()
            Dim sezioniIDs = spoglio.GetSezioniIDs(IDConsultazione, consultazione)
            Dim votiTotali = spoglio.GetVotiValidi(IDConsultazione, sezioniIDs)
            Dim votazioni As New EAP2.VotazioniDataTable
            For Each candidato As ProiezioneCandidatoRow In panelCandidati.Controls
                Dim IDGruppo = candidato.IDGruppo
                Dim voti = spoglio.GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                candidato.AggiornaVoto(voti, votiTotali)
                Dim votazione = votazioni.NewVotazioniRow
                votazione.IDGruppo = IDGruppo
                votazione.Voti = voti
                votazioni.AddVotazioniRow(votazione)
            Next

            Dim votiTop = votazioni.Select(Nothing, "[voti] desc")
            Dim votoTop1 As EAP2.VotazioniRow = votiTop(0)
            'Dim votoTop2 As EAP2.VotazioniRow = votiTop(1)

            For Each candidato As ProiezioneCandidatoRow In panelCandidati.Controls
                Dim voti As Integer = candidato.Voti
                If (votoTop1.Voti = voti) Then
                    candidato.ZoomImmagine()
                End If
            Next

            lblSezioniScrutinate.Text = "Sezioni scrutinate " + sezioniIDs.Count.ToString + " su 82"

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
   
    Private Sub timerVotazioni_Tick(sender As System.Object, e As System.EventArgs) Handles timerVotazioni.Tick
        Try
            lnkRefresh_LinkClicked(Nothing, Nothing)


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub lnkRefresh_LinkClicked(sender As System.Object, e As Gizmox.WebGUI.Forms.LinkLabelLinkClickedEventArgs) Handles lnkRefresh.LinkClicked
        Try
            LoadCandidati()
            AggiornaCandidati()
            lblTimeUpgrade.Text = Now.ToString("HH.mm") + " [hh.mm]"

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
