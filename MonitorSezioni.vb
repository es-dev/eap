Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common


Public Class MonitorSezioni

    Private pathRoot As String = Nothing
    Private Sub MonitorSezioni_Load(sender As Object, e As System.EventArgs) Handles Me.Load
        Try
            pathRoot = UtilityContainer.GetRootPath(Context)
            InitConsultazioni()
            LoadConsultazioni()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private consultazioni As New Hashtable
    Private Sub InitConsultazioni()
        Try
            Dim IDs As New List(Of Integer)
            IDs.Add(16)
            Dim scrutinioSezioni As New Scrutinio
            For Each IDConsultazioneGenerale In IDs
                Dim consultazione = scrutinioSezioni.GetConsultazione(IDConsultazioneGenerale)
                consultazioni.Add(IDConsultazioneGenerale, consultazione)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadConsultazioni()
        Try
            cboConsultazioni.Items.Clear()
            cboConsultazioni.Items.Add("Tutte le consultazioni")
            For Each IDConsultazione In consultazioni.Keys
                Dim consultazione = consultazioni(IDConsultazione)
                cboConsultazioni.Items.Add(consultazione)

            Next
            cboConsultazioni.SelectedIndex = 0


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub lnkRefresh_LinkClicked(sender As System.Object, e As Gizmox.WebGUI.Forms.LinkLabelLinkClickedEventArgs) Handles lnkRefresh.LinkClicked
        Try
            lblLastUpdate.Text = "( Aggiornamento in corso --> attendere, il refresh della pagina avverrà tra pochi secondi ... )"
            lnkRefresh.Enabled = False

            timerSync.Start()

            Dim asyncProcess As New Threading.Thread(New Threading.ThreadStart(AddressOf UpdateStato))
            asyncProcess.Start()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub UpdateStato()
        Try
            LoadStatoConsultazioni()
            LoadStatoReports()
            LoadStatoSezioni()
            ' SyncMySQLServers()

            lblLastUpdate.Text = "( Ultimo aggiornamento --> " + Now.ToString("dd/MM/yyyy HH:mm:ss") + " )"

            timerSync.Stop()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        Finally
            lnkRefresh.Enabled = True

        End Try
    End Sub

    Private Sub SyncMySQLServers()
        Try
            Dim scrutinioSezioni As New Scrutinio
            scrutinioSezioni.SynchronizeMySQLServers(pathRoot)

            lblLastUpdate.Text = "( SyncMySQL ultimo aggiornamento --> " + Now.ToString("dd/MM/yyyy HH:mm:ss") + " )"

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
   
    'Private Sub ShowProgress(message As String, progress As Integer)
    '    Try
    '        Dim bars = pBar.Value + progress
    '        If (bars > 100) Then bars = 100
    '        pBar.Value = bars
    '        lblProgress.Text = message + " --> " + progress.ToString + "%"
    '        If (Not lblProgress.Visible) Then
    '            lblProgress.Visible = True
    '            pBar.Visible = True
    '        End If
    '        If (Not lnkRefresh.Enabled) Then
    '            lnkRefresh.Enabled = False
    '        End If

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    'End Sub

    'Private Sub HideProgress()
    '    Try
    '        lblProgress.Visible = False
    '        pBar.Visible = False
    '        pBar.Value = 0

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    'End Sub

    Private Sub LoadStatoConsultazioni()
        Try
            Dim scrutinioSezioni As New Scrutinio
            listStatoConsultazioni.Items.Clear()
            For Each IDConsultazione In consultazioni.Keys
                Dim consultazione = consultazioni(IDConsultazione)
                Dim sezioniScrutinate = scrutinioSezioni.GetSezioniIDs(IDConsultazione, consultazione)
                listStatoConsultazioni.Items.Add(consultazione + " | Sezioni scrutinate " + sezioniScrutinate.Count.ToString + " su 82")
            Next
            lblLastUpdate.Text = "( Consultazioni ultimo aggiornamento --> " + Now.ToString("dd/MM/yyyy HH:mm:ss") + " )"


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatoReports()
        Try
            Dim scrutinioSezioni As New Scrutinio
            listReports.Items.Clear()
            For Each IDConsultazione In consultazioni.Keys
                Dim consultazione = consultazioni(IDConsultazione)
                Dim sezioniIDs = scrutinioSezioni.GetSezioniIDs(IDConsultazione, consultazione)

                Dim templateName As String = IIf(consultazione = "Camera 2013", "Camera2013", "Senato2013")
                Dim fileTemplate As String = pathRoot + "Resources\Templates\" + templateName + ".xls"
                Dim fileName As String = templateName + "_sezioni_" + sezioniIDs.Count.ToString + "_su_82.xls"
                scrutinioSezioni.Scrutinio2013(consultazione, pathRoot, fileTemplate, fileName)

                listReports.Items.Add(consultazione + " | Report: " + fileName)

            Next
            lblLastUpdate.Text = "( Reports ultimo aggiornamento --> " + Now.ToString("dd/MM/yyyy HH:mm:ss") + " )"


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatoSezioni()
        Try
            If (panelSezioni.Controls.Count = 0) Then
                For numeroSezione = 1 To 82
                    Dim sezioneRow As New MonitorSezioneRow(numeroSezione, consultazioni)
                    panelSezioni.Controls.Add(sezioneRow)
                Next
            End If

            Dim scrutinioSezioni As New Scrutinio()
            Dim verificaSezioni As New VerificaSezioni()
            Dim consultazione = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                If (consultazione <> "Tutte le consultazioni") Then
                    Dim IDConsultazione = scrutinioSezioni.GetIDConsultazione(consultazione)
                    For numeroSezione = 1 To 82
                        Dim IDSezione = scrutinioSezioni.GetIDSezione(IDConsultazione, numeroSezione)
                        Dim stato = scrutinioSezioni.GetStatoSezione(IDConsultazione, IDSezione, consultazione)
                        Dim monitorSezioneRow = GetMonitorSezioneRow(numeroSezione, panelSezioni.Controls)
                        monitorSezioneRow.SetStato(stato)
                    Next
                Else
                    For numeroSezione = 1 To 82
                        Dim stato = verificaSezioni.GetStatoSezione(numeroSezione, consultazioni)
                        Dim monitorSezioneRow = GetMonitorSezioneRow(numeroSezione, panelSezioni.Controls)
                        monitorSezioneRow.SetStato(stato)
                    Next
                End If
            End If

            lblLastUpdate.Text = "( Sezioni ultimo aggiornamento --> " + Now.ToString("dd/MM/yyyy HH:mm:ss") + " )"


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetMonitorSezioneRow(numeroSezione As Integer, controls As Gizmox.WebGUI.Forms.Control.ControlCollection) As MonitorSezioneRow
        Try
            For Each monitorRow As MonitorSezioneRow In controls
                If (monitorRow.NumeroSezione = numeroSezione) Then
                    Return monitorRow
                End If
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function


    Private Sub lnkReports_LinkClicked(sender As System.Object, e As Gizmox.WebGUI.Forms.LinkLabelLinkClickedEventArgs) Handles lnkReports.LinkClicked
        Try
            Dim root = UtilityContainer.GetRootUrl(Context)
            Dim url = root + "/resources/reports"
            Link.Open(url)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    
    Private Sub timerRefresh_Tick(sender As System.Object, e As System.EventArgs) Handles timerRefresh.Tick
        Try
            lnkRefresh_LinkClicked(Nothing, Nothing)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub listReports_DoubleClick(sender As Object, e As System.EventArgs) Handles listReports.DoubleClick
        Try
            If (Not listReports.SelectedItem Is Nothing) Then
                Dim item As String = listReports.SelectedItem
                Dim pos = item.IndexOf(":")
                Dim reportName As String = item.Substring(pos + 2, item.Length - (pos + 2))
                Dim root = UtilityContainer.GetRootUrl(Context)
                Dim url = root + "/resources/reports/" + reportName
                Link.Open(url)

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    'Private Sub listStatoConsultazioni_DoubleClick(sender As Object, e As System.EventArgs) Handles listStatoConsultazioni.DoubleClick
    '    Try
    '        If (Not listStatoConsultazioni.SelectedItem Is Nothing) Then
    '            Dim item As String = listStatoConsultazioni.SelectedItem
    '            Dim pos = item.IndexOf("|")
    '            Dim consultazione As String = item.Substring(0, pos - 1)
    '            Dim stato As New StatoConsultazione(consultazione)
    '            stato.Show()

    '        End If
    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    'End Sub

    Private Sub cmdIndietro_Click(sender As System.Object, e As System.EventArgs) Handles cmdIndietro.Click
        Try
            Dim eHomepage As New eStart
            Context.Transfer(eHomepage)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdLogout_Click(sender As System.Object, e As System.EventArgs) Handles cmdLogout.Click
        Try
            Dim login As New Homepage
            Context.Transfer(login)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub chkTimerSync_CheckedChanged(sender As System.Object, e As System.EventArgs) Handles chkTimerSync.CheckedChanged
        Try
            If (chkTimerSync.Checked) Then
                timerRefresh.Start()
                lblLastUpdate.Text = "( Aggiornamenti avviati - la sincronizzazione partirà tra qualche minuto ...)"
                lnkRefresh_LinkClicked(Nothing, Nothing)
            Else
                timerRefresh.Stop()
                lblLastUpdate.Text = "( Aggiornamenti in standby - il refresh delle informazioni è stato fermato )"

            End If
        Catch ex As Exception

        End Try
    End Sub

    Private Sub timerSync_Tick(sender As Object, e As EventArgs) Handles timerSync.Tick
        Try

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub

    Private Sub cmdPubblica_Click(sender As Object, e As EventArgs) Handles cmdPubblica.Click
        Try
            SyncMySQLServers()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub
End Class
