Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common


Public Class StatoSezione



    Public Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.

    End Sub

    Private consultazioni = Nothing
    Private numeroSezione As Integer = -1
    Public Sub New(numeroSezione As Integer, consultazioni As Hashtable)

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            MyClass.consultazioni = consultazioni
            MyClass.numeroSezione = numeroSezione

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


    Private Sub StatoSezioneReferendum_Load(sender As Object, e As System.EventArgs) Handles Me.Load
        Try
            lblSezione.Text = "Sezione n. " + numeroSezione.ToString
            LoadStatoConsultazioni()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatoConsultazioni()
        Try
            Dim table As New EAPModel.StatoSezioneDataTable
            Dim scrutinioSezioni As New Scrutinio
            For Each IDConsultazione As Integer In consultazioni.keys
                Dim consultazione = consultazioni(IDConsultazione)
                Dim IDSezione = scrutinioSezioni.GetIDSezione(IDConsultazione, numeroSezione)
                Dim row = table.NewStatoSezioneRow
                row.Consultazione = consultazione

                Dim numeroGruppi = scrutinioSezioni.GetNumeroGruppi(IDConsultazione)
                Dim tableVotiCandidati = scrutinioSezioni.GetVotiCandidati(IDConsultazione)
                Dim tableCandidati = scrutinioSezioni.GetCandidati(IDConsultazione)
                Dim tableVotiLista = scrutinioSezioni.GetVotiLista(IDConsultazione)
                Dim tableListe = scrutinioSezioni.GetListe(IDConsultazione)
                Dim tableVotiGruppo = scrutinioSezioni.GetVotiGruppo(IDConsultazione)
                Dim tableGruppi = scrutinioSezioni.GetGruppi(IDConsultazione)
                Dim tableSezioni = scrutinioSezioni.GetSezioni(IDConsultazione)
                Dim stato = scrutinioSezioni.GetStatoSezione(IDConsultazione, IDSezione, consultazione, numeroGruppi, tableVotiCandidati, _
                                                             tableCandidati, tableVotiLista, tableListe, tableVotiGruppo, tableGruppi, tableSezioni)
                row.Stato = stato
                table.AddStatoSezioneRow(row)
            Next
            grid.DataSource = table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try
    End Sub

End Class
