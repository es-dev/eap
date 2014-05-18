

Public Class CheckOperatori

    Private IDConsultazione As Integer = -1

    Public Sub New(consultazione As String)

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.

        Try
            IDConsultazione = GetIDConsultazione(consultazione)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetIDConsultazione(ByVal descrizione As String) As Integer
        Try
            Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(descrizione)
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_cons_comuneTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            Dim consultazioni As DataRow() = table.Select("id_cons_gen=" + IDConsultazioneGenerale.ToString)
            If (consultazioni.Length >= 1) Then
                Dim consultazione As EAPModel.soraldo_ele_cons_comuneRow = consultazioni(0)
                Dim IDConsultazione As Integer = consultazione.id_cons
                Return IDConsultazione

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetIDConsultazioneGenerale(ByVal descrizione As String) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As DataTable = adapter.GetDataByDescrizione(descrizione)
            Dim consultazioni As DataRow() = table.Select("descrizione='" + descrizione + "'")
            If (consultazioni.Length >= 0) Then
                Dim consultazione As EAPModel.soraldo_ele_consultazioneRow = consultazioni(0)
                Dim IDConsultazioneGenerale As Integer = consultazione.id_cons_gen
                Return IDConsultazioneGenerale
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub cmdLogout_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdLogout.Click
        Try
            Dim login As New Homepage
            Context.Transfer(login)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdIndietro_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdIndietro.Click
        Try
            Dim operatori As New Operatori
            Context.Transfer(operatori)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdAggiorna_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdAggiorna.Click
        Try
            LoadStatoSediOperatori()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatoSediOperatori()
        Try
            'Dim async As New System.Threading.Thread(New System.Threading.ThreadStart(AddressOf LoadStatoSediOperatoriAsync))
            'async.Start()
            LoadStatoSediOperatoriAsync()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatoSediOperatoriAsync()
        Try
            Dim table As New EAPModel.CheckOperatoriDataTable
            Dim adapter As New EAPModelTableAdapters.soraldo_authorsTableAdapter
            Dim tableOperatori As EAPModel.soraldo_authorsDataTable = adapter.GetData()
            Dim countOK As Integer = 0
            Dim countNoOk As Integer = 0
            Dim count As Integer = 0
            For Each rowOperatore As EAPModel.soraldo_authorsRow In tableOperatori
                Dim aid As String = rowOperatore.aid
                If (IsOperatoreEnabled(aid, IDConsultazione)) Then
                    Dim row As EAPModel.CheckOperatoriRow = table.NewCheckOperatoriRow
                    row.Operatore = rowOperatore.name

                    Dim sede As String = GetSedeOperatore(aid, IDConsultazione)
                    If (sede Is Nothing) Then
                        sede = "Tutte le sedi"
                    End If
                    row.Sede = sede

                    If (rowOperatore.counter < 1) Then
                        countNoOk += 1
                        row.Stato = "Errore connessione"
                        row.Descrizione_Problema = "Impossibile ricevere dati di login dall'operatore-sede remota"
                    Else
                        countOK += 1
                        row.Stato = "Connessione OK"
                        row.Descrizione_Problema = "Nessun problema riscontrato durante la connessione remota"

                    End If
                    table.AddCheckOperatoriRow(row)
                    count += 1
                End If
            Next

            grid.AutoSizeColumnsMode = Gizmox.WebGUI.Forms.DataGridViewAutoSizeColumnsMode.AllCells
            grid.DataSource = table

            lblOperatoriOK.Text = "Sedi-operatore con accesso riuscito: " + countOK.ToString + " su " + count.ToString
            lblOperatoriNoOK.Text = "Sedi-operatore con problemi di accesso: " + countNoOk.ToString + " su " + count.ToString

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function IsOperatoreEnabled(aid As String, IDConsultazione As Integer) As Boolean
        Try
            If (aid.ToUpper <> "ADMIN" And aid.ToUpper <> "SUSER") Then
                Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
                Dim table = adapter.GetDataByAidIDConsultazione(aid, IDConsultazione)
                Dim enabled = table.Count >= 1
                Return enabled
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return False

    End Function

    Private Function GetSedeOperatore(ByVal aid As String, IDConsultazione As Integer) As String
        Try
            Dim IDSede As Integer = GetIDSede(aid, IDConsultazione)
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sedeTableAdapter
            Dim table As DataTable = adapter.GetDataByIDSede(IDSede)
            If (table.Rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_sedeRow = table.Rows(0)
                Dim indirizzo As String = row.indirizzo
                Return indirizzo
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetIDSede(ByVal aid As String, IDConsultazione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
            Dim table As DataTable = adapter.GetDataByAidIDConsultazione(aid, IDConsultazione)
            If (table.Rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_operatoriRow = table.Rows(0)
                Dim IDSede As Integer = row.id_sede
                Return IDSede
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub cmdAzzeraFlag_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdAzzeraFlag.Click
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_authorsTableAdapter
            Dim table As DataTable = adapter.GetData()
            For Each row As EAPModel.soraldo_authorsRow In table.Rows
                row.counter = 0
                adapter.Update(row)
            Next

            MessageBoxShow("Azzeramento flag operatori completato con successo.")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub CheckOperatori_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Try
            LoadStatoSediOperatori()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub timerCheck_Tick(sender As System.Object, e As System.EventArgs) Handles timerCheck.Tick
        Try
            LoadStatoSediOperatori()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub timerMessage_Tick(sender As Object, e As EventArgs) Handles timerMessage.Tick
        Try
            lblMessage.Text = ""
            lblMessage.Visible = False
            timerMessage.Stop()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub

    Private Sub MessageBoxShow(message As String)
        Try
            lblMessage.Text = message
            lblMessage.Visible = True
            timerMessage.Start()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub
End Class
