

Public Class Operatori

    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.

        Try
            LoadConsultazioni()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Private Sub LoadConsultazioni()
        Try
            cboConsultazioni.Items.Clear()
            cboConsultazioniDestinazione.Items.Clear()

            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As EAPModel.soraldo_ele_consultazioneDataTable = adapter.GetData
            For Each row As EAPModel.soraldo_ele_consultazioneRow In table
                Dim consultazione As String = row.descrizione
                cboConsultazioni.Items.Add(consultazione)
                cboConsultazioniDestinazione.Items.Add(consultazione)

            Next

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
            Dim eHomepage As New eStart
            Context.Transfer(eHomepage)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Private Sub cmdEnableOperators_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdEnableOperators.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
                Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
                For Each row As EAPModel.soraldo_ele_operatoriRow In table.Rows
                    If (row.id_sede <> 0) Then
                        row.permessi = 16
                        adapter.Update(row)
                    End If
                Next
                MessageBoxShow("Tutti gli operatori sono stati ABILITATI.")
            End If


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdDisableOperators_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdDisableOperators.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
                Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
                For Each row As EAPModel.soraldo_ele_operatoriRow In table.Rows
                    If (row.id_sede <> 0) Then
                        row.permessi = 0
                        adapter.Update(row)
                    End If
                Next
                MessageBoxShow("Tutti gli operatori sono stati DISABILITATI.")
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdCheckLogin_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdCheckLogin.Click
        Try
            Dim consultazione = cboConsultazioni.SelectedItem
            Dim page As New CheckOperatori(consultazione)
            Context.Transfer(page)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdCopiaPermessi_Click(sender As System.Object, e As System.EventArgs) Handles cmdCopiaPermessi.Click
        Try
            Dim consultazioneOrigine As String = cboConsultazioni.SelectedItem
            Dim consultazioneDestinazione As String = cboConsultazioniDestinazione.SelectedItem
            If (consultazioneOrigine IsNot Nothing AndAlso consultazioneDestinazione IsNot Nothing AndAlso _
               consultazioneOrigine.Length > 0 AndAlso consultazioneDestinazione.Length > 0 AndAlso _
               consultazioneOrigine <> consultazioneDestinazione) Then
                Dim IDConsultazioneOrigine = GetIDConsultazione(consultazioneOrigine)
                Dim IDConsultazioneDestinazione = GetIDConsultazione(consultazioneDestinazione)

                Dim copied = CopiaPermessi(IDConsultazioneOrigine, IDConsultazioneDestinazione)
                If (copied) Then
                    UtilityContainer.MessageBox("Permessi duplicati in modo corretto.", "Informazione")
                Else
                    UtilityContainer.MessageBox("Si è verificato un errore durante la clonazione dei permessi. Controllare i dati e riprovare.", "Attenzione", Gizmox.WebGUI.Forms.MessageBoxIcon.Warning)
                End If
            Else
                UtilityContainer.MessageBox("Occorre selezionare una consultazione valida e assicurarsi che la consultazione di destinazione non coincida con quella di partenza.", "Attenzione", Gizmox.WebGUI.Forms.MessageBoxIcon.Warning)

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function CopiaPermessi(IDConsultazioneOrigine As Integer, IDConsultazioneDestinazione As Integer) As Boolean
        Try
            Dim tableDestinazione As New EAPModel.soraldo_ele_operatoriDataTable
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
            Dim tableOrigine = adapter.GetDataByIDConsultazione(IDConsultazioneOrigine)
            For Each rowOrigine As EAPModel.soraldo_ele_operatoriRow In tableOrigine
                Dim rowDestinazione = tableDestinazione.Newsoraldo_ele_operatoriRow
                rowDestinazione.aid = rowOrigine.aid
                rowDestinazione.id_comune = rowOrigine.id_comune
                rowDestinazione.id_cons = IDConsultazioneDestinazione

                Dim IDSedeDestinazione = GetIDSedeDestinazione(IDConsultazioneOrigine, rowOrigine.id_sede, IDConsultazioneDestinazione)
                rowDestinazione.id_sede = IDSedeDestinazione
                rowDestinazione.permessi = rowOrigine.permessi
                tableDestinazione.Addsoraldo_ele_operatoriRow(rowDestinazione)

            Next

            If (tableDestinazione.Count >= 1) Then
                adapter.DeleteDataByIDConsultazione(IDConsultazioneDestinazione)
                adapter.Update(tableDestinazione)
            End If

            Return True


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return False

    End Function

    Private Function GetIDSedeDestinazione(IDConsultazioneOrigine As Integer, IDSedeOrigine As Integer, IDConsultazioneDestinazione As Integer) As Integer
        Try
            Dim sede As String = GetSede(IDConsultazioneOrigine, IDSedeOrigine)
            Dim IDSedeDestinazione = GetIDSede(IDConsultazioneDestinazione, sede)
            Return IDSedeDestinazione

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSede(IDConsultazione As Integer, IDSede As Integer) As String
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sedeTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSede(IDConsultazione, IDSede)
            If (table.Count >= 1) Then
                Dim row = table(0)
                Dim sede = row.indirizzo
                Return sede

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetIDSede(IDConsultazione As Integer, sede As String) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sedeTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneSede(IDConsultazione, sede)
            If (table.Count >= 1) Then
                Dim row = table(0)
                Dim IDSede = row.id_sede
                Return IDSede

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Private Sub cmdCopiaCorpoElettorale_Click(sender As System.Object, e As System.EventArgs) Handles cmdCopiaCorpoElettorale.Click
        Try
            Dim consultazioneOrigine As String = cboConsultazioni.SelectedItem
            Dim consultazioneDestinazione As String = cboConsultazioniDestinazione.SelectedItem
            If (consultazioneOrigine IsNot Nothing AndAlso consultazioneDestinazione IsNot Nothing AndAlso _
               consultazioneOrigine.Length > 0 AndAlso consultazioneDestinazione.Length > 0 AndAlso _
               consultazioneOrigine <> consultazioneDestinazione) Then
                Dim IDConsultazioneOrigine = GetIDConsultazione(consultazioneOrigine)
                Dim IDConsultazioneDestinazione = GetIDConsultazione(consultazioneDestinazione)

                Dim copied = CopiaCorpoElettorale(IDConsultazioneOrigine, IDConsultazioneDestinazione)
                If (copied) Then
                    UtilityContainer.MessageBox("Corpo Elettorale duplicato in modo corretto.", "Informazione")
                Else
                    UtilityContainer.MessageBox("Si è verificato un errore durante la clonazione dele corpo elettorale. Controllare i dati e riprovare.", "Attenzione", Gizmox.WebGUI.Forms.MessageBoxIcon.Warning)
                End If
            Else
                UtilityContainer.MessageBox("Occorre selezionare una consultazione valida e assicurarsi che la consultazione di destinazione non coincida con quella di partenza.", "Attenzione", Gizmox.WebGUI.Forms.MessageBoxIcon.Warning)

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function CopiaCorpoElettorale(IDConsultazioneOrigine As Integer, IDConsultazioneDestinazione As Integer) As Boolean
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim tableOrigine = adapter.GetDataByIDConsultazione(IDConsultazioneOrigine)
            For Each rowOrigine In tableOrigine
                Dim numeroSezione = rowOrigine.num_sez
                Dim tableDestinazione = adapter.GetDataByIDConsultazioneNumeroSezione(IDConsultazioneDestinazione, numeroSezione)
                If (tableDestinazione.Count >= 1) Then
                    If (Not rowOrigine.IsfemmineNull And Not rowOrigine.IsmaschiNull) Then
                        Dim rowDestinazione = tableDestinazione(0)
                        rowDestinazione.femmine = rowOrigine.femmine
                        rowDestinazione.maschi = rowOrigine.maschi
                        adapter.Update(rowDestinazione)
                    End If
                End If
            Next
            Return True

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return False

    End Function

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
