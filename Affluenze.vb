Imports Gizmox.WebGUI.Forms

Public Class Affluenze


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

    Private Sub LoadCollegi(ByVal descrizione As String)
        Try
            cboCollegio.Items.Clear()
            cboCollegio.Items.Add("Tutti i Collegi")

            Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(descrizione)
            Dim collegi= GetCollegi(IDConsultazioneGenerale)
            For Each collegio As EAPVoti.soraldo_ele_collegiRow In collegi
                Dim nomeCollegio As String = collegio.descrizione
                cboCollegio.Items.Add(nomeCollegio)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetCollegi(ByVal IDConsultazioneGenerale As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_collegiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            Dim rows As DataRow() = table.Select("id_cons_gen=" + IDConsultazioneGenerale.ToString(), "descrizione asc")
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub LoadConsultazioni()
        Try
            cboConsultazioni.Items.Clear()

            Dim adapter As New EAPOperatori2TableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As EAPOperatori2.soraldo_ele_consultazioneDataTable = adapter.GetData
            For Each row In table
                cboConsultazioni.Items.Add(row.descrizione)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdAggiorna_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdAggiorna.Click
        Try
            Dim descrizione As String = cboConsultazioni.SelectedItem
            If (Not descrizione Is Nothing) Then
                Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(descrizione)
                SetColonneGrid(IDConsultazioneGenerale)

                Dim IDConsultazione As Integer = GetIDConsultazione(descrizione)
                Dim collegio As String = cboCollegio.SelectedItem
                Dim IDCollegio As Integer = GetIDCollegio(IDConsultazioneGenerale, collegio)
                FillDatiSezioni(IDConsultazione, IDConsultazioneGenerale, IDCollegio)

                grid.DataSource = tableAffluenze
                SetStyleGrid()

                Dim sezioniRilevate As Integer = GetSezioniRilevate(IDConsultazione, IDCollegio)
                Dim numeroSezioniCollegio As Integer = GetNumeroSezioniCollegio(IDConsultazione, IDCollegio)
                'ToDo: lblSezioniRilevate.Text = "Sezioni rilevate " + sezioniRilevate.ToString + " su " + numeroSezioniCollegio.ToString

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetSezioniRilevate(ByVal IDConsultazione As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim sezioniRilevate As Integer = 0
            Dim adapter As New EAPTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAP.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(IDConsultazione)
            For Each sezione As EAP.soraldo_ele_sezioniRow In sezioni
                Dim IDSezione As Integer = sezione.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    sezioniRilevate += 1
                End If
            Next

            Return sezioniRilevate

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetNumeroSezioniCollegio(ByVal IDConsultazione As Integer, ByVal IDCollegio As Integer) As Integer
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_collegi_sezioniTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDCollegio(IDConsultazione, IDCollegio)
            Dim numeroSezioniCollegio As Integer = table.Rows.Count
            If (IDCollegio = -1) Then
                numeroSezioniCollegio = 82
            End If
            Return numeroSezioniCollegio

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetIDCollegio(ByVal IDConsultazioneGenerale As Integer, ByVal collegio As String) As Integer
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_collegiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGeneraleDescrizione(IDConsultazioneGenerale, collegio)
            Dim rows As DataRow() = table.Select("id_cons_gen=" + IDConsultazioneGenerale.ToString() + " and descrizione='" + collegio + "'")
            If (rows.Length >= 1) Then
                Dim row As EAPVoti.soraldo_ele_collegiRow = rows(0)
                Dim IDCollegio As Integer = row.id_collegio
                Return IDCollegio

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub SetStyleGrid()
        Try
            For Each column As Gizmox.WebGUI.Forms.DataGridViewColumn In grid.Columns
                Dim columnName As String = column.Name
                If (columnName.IndexOf("/") >= 0) Then
                    column.Width = 120
                End If
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub FillDatiSezioni(ByVal IDConsultazione As Integer, ByVal IDConsultazioneGenerale As Integer, Optional ByVal IDCollegio As Integer = -1)
        Try
            tableAffluenze.Rows.Clear()

            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni = adapter.GetDataByIDConsultazione(IDConsultazione)

            Dim rowAffluenza As EAPAffluenze.AffluenzeRow = Nothing
            Dim totaleMaschi As Integer = 0
            Dim totaleFemmine As Integer = 0
            Dim totaliAffluenze As New Hashtable
            Dim affluenze = GetRilevazioniAffluenze(IDConsultazioneGenerale)
            For Each affluenza As EAPAffluenze.soraldo_ele_rilaffRow In affluenze.Rows
                Dim data As Date = affluenza.data
                Dim orario As TimeSpan = affluenza.orario
                Dim columnName As String = data.ToString("dd/MM/yy") + " - " + orario.Hours.ToString("00") + "." + orario.Minutes.ToString("00")
                totaliAffluenze.Add(columnName, 0)
                totaliAffluenze.Add(columnName + "(M)", 0)
                totaliAffluenze.Add(columnName + "(F)", 0)
            Next
            For Each sezione As EAPAffluenze.soraldo_ele_sezioniRow In sezioni
                Dim IDSezione As Integer = sezione.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    rowAffluenza = tableAffluenze.NewAffluenzeRow

                    Dim maschi As Integer = 0
                    If (Not sezione.IsmaschiNull) Then maschi = sezione.maschi
                    Dim femmine As Integer = 0
                    If (Not sezione.IsfemmineNull) Then femmine = sezione.femmine

                    rowAffluenza.Sezione = sezione.num_sez
                    rowAffluenza._Iscritti_Uomini_ = maschi
                    rowAffluenza._Iscritti_Donne_ = femmine
                    rowAffluenza.Iscritti = maschi + femmine
                    totaleMaschi += maschi
                    totaleFemmine += femmine


                    For Each affluenza As EAPAffluenze.soraldo_ele_rilaffRow In affluenze.Rows
                        Dim data As Date = affluenza.data
                        Dim orario As TimeSpan = affluenza.orario
                        Dim columnName As String = data.ToString("dd/MM/yy") + " - " + orario.Hours.ToString("00") + "." + orario.Minutes.ToString("00")
                        Dim votoParziale = GetVotoParziale(IDConsultazione, IDSezione, columnName)
                        If (Not votoParziale Is Nothing) Then
                            rowAffluenza(columnName) = votoParziale.voti_complessivi
                            If (orario.Hours = 15) Then
                                rowAffluenza(columnName + "(M)") = votoParziale.voti_uomini
                                rowAffluenza(columnName + "(F)") = votoParziale.voti_donne
                                totaliAffluenze(columnName) += votoParziale.voti_complessivi
                                totaliAffluenze(columnName + "(M)") += votoParziale.voti_uomini
                                totaliAffluenze(columnName + "(F)") += votoParziale.voti_donne
                            End If
                        End If
                    Next

                    tableAffluenze.AddAffluenzeRow(rowAffluenza)
                End If

            Next

            'Totali
            rowAffluenza = tableAffluenze.NewAffluenzeRow
            rowAffluenza.Sezione = "TOTALI"
            rowAffluenza._Iscritti_Uomini_ = totaleMaschi
            rowAffluenza._Iscritti_Donne_ = totaleFemmine
            rowAffluenza.Iscritti = totaleMaschi + totaleFemmine

            For Each column As DataColumn In tableAffluenze.Columns
                Dim columnName As String = column.ColumnName
                If (columnName.IndexOf("/") >= 0) Then
                    rowAffluenza(columnName) = totaliAffluenze(columnName)
                End If
            Next
            tableAffluenze.AddAffluenzeRow(rowAffluenza)

            'Percentuali
            rowAffluenza = tableAffluenze.NewAffluenzeRow
            rowAffluenza.Sezione = "PERCENTUALI[%]"

            Dim totale As Integer = totaleMaschi + totaleFemmine
            rowAffluenza._Iscritti_Uomini_ = (totaleMaschi / totale * 100).ToString("0.0")
            rowAffluenza._Iscritti_Donne_ = (totaleFemmine / totale * 100).ToString("0.0")
            rowAffluenza.Iscritti = "100.0"
            For Each column As DataColumn In tableAffluenze.Columns
                Dim columnName As String = column.ColumnName
                If (columnName.IndexOf("(M)") >= 0) Then
                    Dim columnNameTot As String = columnName.Replace("(M)", "")
                    Dim columnNameM As String = columnNameTot + "(M)"
                    Dim columnNameF As String = columnNameTot + "(F)"
                    Dim totaleAffluenzaMaschi As Integer = totaliAffluenze(columnNameM)
                    Dim totaleAffluenzaFemmine As Integer = totaliAffluenze(columnNameF)
                    Dim totaleAffluenza As Integer = totaleAffluenzaMaschi + totaleAffluenzaFemmine
                    If (totaleAffluenza <> 0) Then
                        rowAffluenza(columnNameM) = (totaleAffluenzaMaschi / totale * 100).ToString("0.0")
                        rowAffluenza(columnNameF) = (totaleAffluenzaFemmine / totale * 100).ToString("0.0")
                    End If
                    rowAffluenza(columnNameTot) = (totaleAffluenza / totale * 100).ToString("0.0")
                End If
            Next
            tableAffluenze.AddAffluenzeRow(rowAffluenza)



        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function IsInCollegio(ByVal IDConsultazione As Integer, ByVal IDCollegio As Integer, ByVal IDSezione As Integer) As Boolean
        Try
            'If (IDCollegio <> -1) Then
            '    Dim adapter As New EAPVotiTableAdapters.soraldo_ele_collegi_sezioniTableAdapter
            '    Dim table As DataTable = adapter.GetDataByIDConsultazioneIDCollegioIDSezione(IDConsultazione, IDCollegio, IDSezione)
            '    Dim inCollegio As Boolean = (table.Rows.Count >= 1)
            '    Return inCollegio
            'Else
            '    Return True
            'End If
            Return True

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return False

    End Function

    Private Function GetVotoParziale(ByVal IDConsultazione As Integer, ByVal IDSezione As Integer, dataSQL As String) As EAPAffluenze.soraldo_ele_voti_parzialeRow
        Try
            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_voti_parzialeTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            For Each row In table
                Dim dataRowSQL = row.data.ToString("dd/MM/yy") + " - " + row.orario.Hours.ToString("00") + "." + row.orario.Minutes.ToString("00")
                If (dataRowSQL = dataSQL) Then
                    Return row
                End If
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetRilevazioniAffluenze(ByVal IDConsultazioneGenerale As Integer) As DataTable
        Try
            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_rilaffTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private tableAffluenze As New EAPAffluenze.AffluenzeDataTable

    Private Sub SetColonneGrid(ByVal IDConsultazioneGenerale As Integer)
        Try
            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_rilaffTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            Dim affluenze As DataRow() = table.Select("id_cons_gen=" + IDConsultazioneGenerale.ToString, "data asc, orario asc")
            Dim count As Integer = affluenze.Length
            For index As Integer = 0 To count - 1
                Dim affluenza As EAPAffluenze.soraldo_ele_rilaffRow = affluenze(index)
                Dim data As String = affluenza.data.ToString("dd/MM/yy") + " - " + affluenza.orario.Hours.ToString("00") + "." + affluenza.orario.Minutes.ToString("00")
                Dim searchColumn As String = "Affluenza" + (index + 1).ToString
                For Each column As DataColumn In tableAffluenze.Columns
                    Dim columnName As String = column.ColumnName.Replace(searchColumn, data)
                    column.ColumnName = columnName
                Next
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetIDConsultazione(ByVal descrizione As String) As Integer
        Try
            Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(descrizione)
            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_cons_comuneTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            Dim consultazioni As DataRow() = table.Select("id_cons_gen=" + IDConsultazioneGenerale.ToString)
            If (consultazioni.Length >= 1) Then
                Dim consultazione As EAPAffluenze.soraldo_ele_cons_comuneRow = consultazioni(0)
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
            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As DataTable = adapter.GetDataByDescrizione(descrizione)
            Dim consultazioni As DataRow() = table.Select("descrizione='" + descrizione + "'")
            If (consultazioni.Length >= 0) Then
                Dim consultazione As EAPAffluenze.soraldo_ele_consultazioneRow = consultazioni(0)
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

    Private Sub cmdDownloadXLS_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdDownloadXLS.Click
        Try
            Dim fileTemplate = UtilityContainer.GetRootPath(Context) + "Resources\Templates\Cosenza_Affluenze.xls"
            Dim fileName As String = "Cosenza_Affluenza_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileXLS As String = pathRoot + "Reports\" + fileName
            IO.File.Copy(fileTemplate, fileXLS)
            Dim excel As New Spire.Xls.Workbook()
            excel.Version = Spire.Xls.ExcelVersion.Version97to2003
            excel.LoadFromFile(fileXLS)

            Dim sheetName As String = "Affluenze"
            Dim sheet = excel.Worksheets(sheetName)

            Dim row As Integer = 1
            Dim consultazione As String = cboConsultazioni.SelectedItem
            sheet.SetValue(row, 1, "COMUNE DI")
            sheet.SetValue(row, 2, "COSENZA")
            row += 1
            sheet.SetValue(row, 1, "CONSULTAZIONE")
            sheet.SetValue(row, 2, consultazione)
            row += 1

            Dim col As Integer = 1
            For Each column As Gizmox.WebGUI.Forms.DataGridViewColumn In grid.Columns
                row = 3

                Dim columnName As String = column.Name
                sheet.SetValue(row, col, columnName)
                row += 1
                For Each rowGrid As Gizmox.WebGUI.Forms.DataGridViewRow In grid.Rows
                    If (Not IsDBNull(rowGrid.Cells(columnName).Value)) Then
                        Dim value As String = rowGrid.Cells(columnName).Value
                        sheet.SetValue(row, col, value)
                    End If

                    row += 1
                Next
                col += 1
            Next
            sheet.Unprotect()
            excel.UnProtect()
            excel.Save()

            MessageBox.Show("Export dati affluenze completato con successo")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cboConsultazioni_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboConsultazioni.SelectedIndexChanged
        Try
            Dim descrizione As String = cboConsultazioni.SelectedItem
            LoadCollegi(descrizione)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub timerSync_Tick(sender As System.Object, e As System.EventArgs) Handles timerSync.Tick
        Try
            cmdAggiorna_Click(Nothing, Nothing)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub lnkReports_LinkClicked(sender As System.Object, e As Gizmox.WebGUI.Forms.LinkLabelLinkClickedEventArgs) Handles lnkReports.LinkClicked
        Try
            Dim root = UtilityContainer.GetRootUrl(Context)
            Dim url = root + "/resources/reports"
            Link.Open(url)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
