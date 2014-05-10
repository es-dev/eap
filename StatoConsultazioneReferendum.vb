Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common
Imports WorkSpaceContent_Library

Public Class StatoConsultazioneReferendum

    Private consultazione As String = Nothing
    Public Sub New(consultazione As String)

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            MyClass.consultazione = consultazione

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try

    End Sub

    Private Sub VerificaQuadrature()
        Try
            Dim si As Integer = txtSI.Text
            Dim no As Integer = txtNO.Text
            Dim A As Integer = txtTotaleValidi.Text
            If (A <> si + no) Then
                errProvider.SetError(txtTotaleValidi, "Il totale validi non corrisponde a si+no")
            End If

            Dim B As Integer = txtContestati.Text
            Dim C As Integer = txtBianche.Text
            Dim D As Integer = txtNulle.Text
            Dim E As Integer = txtTotaleComplessivo.Text
            If (A + B + C + D <> E) Then
                errProvider.SetError(txtTotaleComplessivo, "Il totale complessivo E <> A+B+C+D")
            End If

            Dim F As Integer = txtTotaleVotanti.Text
            If (F <> E) Then
                errProvider.SetError(txtTotaleVotanti, "Il totale votanti F<>E")
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadData(consultazione As String)
        Try
            Dim scrutinioSezioni As New Scrutinio()
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = scrutinioSezioni.GetIDConsultazione(consultazione)
                Dim sezioniIDs = scrutinioSezioni.GetSezioniIDs(IDConsultazione, consultazione)
                lblSezioniScrutinate.Text = "Sezioni scrutinate n." + sezioniIDs.count.ToString + " su 82"

                'voti si+no
                Dim si = scrutinioSezioni.GetSiReferendum(IDConsultazione, sezioniIDs)
                Dim no = scrutinioSezioni.GetNoReferendum(IDConsultazione, sezioniIDs)
                txtSI.Text = si
                txtNO.Text = no

                Dim totaleValidi = si + no
                txtTotaleValidi.Text = totaleValidi

                'totali e quadrature
                Dim schedeBianche = scrutinioSezioni.GetSchedeBiancheReferendum(IDConsultazione, sezioniIDs)
                txtBianche.Text = schedeBianche

                Dim schedeNulle = scrutinioSezioni.GetSchedeNulleReferendum(IDConsultazione, sezioniIDs)
                txtNulle.Text = schedeNulle

                Dim schedeContestate = scrutinioSezioni.GetSchedeContestateReferendum(IDConsultazione, sezioniIDs)
                txtContestati.Text = schedeContestate

                Dim votiTotali = totaleValidi + schedeBianche + schedeNulle + schedeContestate
                txtTotaleComplessivo.Text = votiTotali

                Dim votantiMaschi = scrutinioSezioni.GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiFemmine = scrutinioSezioni.GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiTotali = votantiMaschi + votantiFemmine
                txtMaschi.Text = votantiMaschi
                txtFemmine.Text = votantiFemmine
                txtTotaleVotanti.Text = votantiTotali

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdClose_Click(sender As System.Object, e As System.EventArgs) Handles cmdClose.Click
        Try
            Close()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub StatoConsultazioneReferendum_Load(sender As Object, e As System.EventArgs) Handles Me.Load
        Try
            lblConsultazione.Text = consultazione
            LoadData(consultazione)
            VerificaQuadrature()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
