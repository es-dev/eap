Imports Gizmox.WebGUI.Forms

Public Class Voti

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

            Dim adapter As New EAPAffluenzeTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As EAPAffluenze.soraldo_ele_consultazioneDataTable = adapter.GetData
            For Each row As EAPAffluenze.soraldo_ele_consultazioneRow In table
                Dim consultazione As String = row.descrizione
                cboConsultazioni.Items.Add(consultazione)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdAggiorna_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdAggiorna.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim visualizzazione As String = cboVisualizzazione.SelectedItem
                If (Not visualizzazione Is Nothing) Then
                    Dim collegio As String = cboCollegio.SelectedItem
                    If (Not collegio Is Nothing) Then
                        Dim sezioniRilevate As Integer = 0
                        Dim IDCollegio As Integer = -1
                        If (consultazione.IndexOf("Europee") >= 0) Then
                            ShowDatiEuropee(IDConsultazione, visualizzazione, collegio)
                            sezioniRilevate = GetSezioniRilevate(IDConsultazione)
                        ElseIf (consultazione.IndexOf("Provinciali") >= 0) Then
                            If (collegio <> "Tutti i Collegi") Then
                                Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(consultazione)
                                IDCollegio = GetIDCollegio(IDConsultazioneGenerale, collegio)
                            End If
                            If (visualizzazione = "Candidati Presidenti") Then
                                ShowDatiProvincialiPresidenti(IDConsultazione, IDCollegio, collegio)
                            ElseIf (visualizzazione = "Preferenze di Lista") Then
                                ShowDatiProvincialiListe(IDConsultazione, IDCollegio, collegio)
                            End If
                            sezioniRilevate = GetSezioniRilevate(IDConsultazione, IDCollegio)
                        ElseIf (consultazione.IndexOf("Referendum") >= 0) Then
                            ShowDatiReferendum(IDConsultazione, collegio)
                        End If

                        Dim numeroSezioniCollegio As Integer = GetNumeroSezioniCollegio(IDConsultazione, IDCollegio)
                        lblSezioniRilevate.Text = "Sezioni rilevate " + sezioniRilevate.ToString + " su " + numeroSezioniCollegio.ToString

                        CalcoloTotaliSchede(IDConsultazione, IDCollegio)

                    End If
                End If

            End If

            grid.DataSource = tableVoti

            SetStyleGrid()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub SetStyleGrid()
        Try
            grid.Columns(0).Width = 120
            grid.Columns(2).Width = 300

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

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

    Private Sub CalcoloTotaliSchede(ByVal IDConsultazione As Integer, Optional ByVal IDCollegio As Integer = -1)
        Try
            Dim adapter As New EAPTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAP.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(IDConsultazione)

            Dim totBianche As Integer = 0
            Dim totContestati As Integer = 0
            Dim totNulle As Integer = 0
            Dim totValidi As Integer = 0
            Dim totVotantiM As Integer = 0
            Dim totVotantiF As Integer = 0
            For Each sezione As EAP.soraldo_ele_sezioniRow In sezioni
                Dim IDSezione As Integer = sezione.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    totBianche += sezione.bianchi
                    totContestati += sezione.contestati
                    totNulle += sezione.nulli
                    totValidi += sezione.validi
                    totVotantiF += sezione.femmine
                    totVotantiM += sezione.maschi
                End If
            Next
            txtTotBianche.Text = totBianche
            txtTotContestati.Text = totContestati
            txtTotNulle.Text = totNulle
            txtTotValidi.Text = totValidi
            txtTotVotanti.Text = totBianche + totContestati + totNulle + totValidi
            txtVotantiF.Text = totVotantiF
            txtVotantiM.Text = totVotantiM

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

    Private Sub ShowDatiProvincialiPresidenti(ByVal IDConsultazione As Integer, ByVal IDCollegio As Integer, ByVal collegio As String)
        Try
            tableVoti.Rows.Clear()

            Dim gruppi As DataRow() = GetGruppi(IDConsultazione)
            For Each gruppo As EAPVoti.soraldo_ele_gruppoRow In gruppi
                Dim nomePresidente As String = gruppo.descrizione
                Dim numero As Integer = gruppo.num_gruppo
                Dim IDGruppo As Integer = gruppo.id_gruppo
                Dim votiValidi As Integer = GetVotiValidiGruppo(IDConsultazione, IDGruppo, IDCollegio)
                Dim votiContestati As Integer = GetVotiContestatiGruppo(IDConsultazione, IDGruppo, IDCollegio)

                Dim rowVoti As EAPVoti.VotiRow = tableVoti.NewVotiRow

                rowVoti.Collegio = collegio
                rowVoti.Lista_o_Candidato = nomePresidente
                rowVoti.Numero = numero
                rowVoti.Voti_Contestati = votiContestati
                rowVoti.Voti_Validi = votiValidi

                tableVoti.AddVotiRow(rowVoti)
            Next
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowDatiReferendum(ByVal IDConsultazione As Integer, ByVal collegio As String)
        Try
            tableVoti.Rows.Clear()
            Dim quesiti As New ArrayList
            quesiti.Add("Si")
            quesiti.Add("No")

            Dim numero As Integer = 1
            For Each quesito As String In quesiti
                Dim votiValidi As Integer = GetVotiReferendum(IDConsultazione, quesito)
                Dim votiContestati As Integer = 0

                Dim rowVoti As EAPVoti.VotiRow = tableVoti.NewVotiRow

                rowVoti.Collegio = collegio
                rowVoti.Lista_o_Candidato = quesito
                rowVoti.Numero = numero
                rowVoti.Voti_Contestati = votiContestati
                rowVoti.Voti_Validi = votiValidi

                tableVoti.AddVotiRow(rowVoti)
                numero += 1

            Next
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetVotiReferendum(ByVal IDConsultazione As Integer, ByVal quesito As String) As Integer
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_voti_refTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Dim voti As Integer = 0
            For Each row As DataRow In table.Rows
                Dim voto As Integer = row(quesito)
                voti += voto
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetGruppi(ByVal IDConsultazione As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString())
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub ShowDatiProvincialiListe(ByVal IDConsultazione As Integer, ByVal IDCollegio As Integer, ByVal collegio As String)
        Try
            tableVoti.Rows.Clear()

            Dim liste As DataRow() = GetListe(IDConsultazione)
            For Each lista As EAPVoti.soraldo_ele_listaRow In liste
                Dim nomeLista As String = lista.descrizione
                Dim numero As Integer = lista.num_lista
                Dim IDLista As Integer = lista.id_lista
                Dim votiValidi As Integer = GetVotiValidiLista(IDConsultazione, IDLista, IDCollegio)
                Dim votiContestati As Integer = GetVotiContestatiLista(IDConsultazione, IDLista, IDCollegio)

                Dim rowVoti As EAPVoti.VotiRow = tableVoti.NewVotiRow

                rowVoti.Collegio = collegio
                rowVoti.Lista_o_Candidato = nomeLista
                rowVoti.Numero = numero
                rowVoti.Voti_Contestati = votiContestati
                rowVoti.Voti_Validi = votiValidi

                tableVoti.AddVotiRow(rowVoti)
            Next
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Private Sub ShowDatiEuropee(ByVal IDConsultazione As Integer, ByVal visualizzazione As String, ByVal collegio As String)
        Try
            tableVoti.Rows.Clear()

            If (visualizzazione = "Tutte le Liste") Then
                Dim liste As DataRow() = GetListe(IDConsultazione)
                For Each lista As EAPVoti.soraldo_ele_listaRow In liste
                    Dim nomeLista As String = lista.descrizione
                    Dim numero As Integer = lista.num_lista
                    Dim IDLista As Integer = lista.id_lista
                    Dim votiValidi As Integer = GetVotiValidiLista(IDConsultazione, IDLista)
                    Dim votiContestati As Integer = GetVotiContestatiLista(IDConsultazione, IDLista)

                    Dim rowVoti As EAPVoti.VotiRow = tableVoti.NewVotiRow

                    rowVoti.Collegio = collegio
                    rowVoti.Lista_o_Candidato = nomeLista
                    rowVoti.Numero = numero
                    rowVoti.Voti_Contestati = votiContestati
                    rowVoti.Voti_Validi = votiValidi

                    tableVoti.AddVotiRow(rowVoti)
                Next
            Else
                Dim lista As String = visualizzazione
                Dim IDLista As Integer = GetIDLista(IDConsultazione, lista)
                Dim candidati As DataRow() = GetCandidati(IDConsultazione, IDLista)
                For Each candidato As EAPVoti.soraldo_ele_candidatiRow In candidati
                    Dim nomeCandidato As String = candidato.cognome + " " + candidato.nome
                    Dim numero As Integer = candidato.num_cand
                    Dim IDCandidato As Integer = candidato.id_cand
                    Dim votiValidi As Integer = GetVotiValidiCandidato(IDConsultazione, IDCandidato)
                    Dim votiContestati As Integer = GetVotiContestatiCandidato(IDConsultazione, IDCandidato)

                    Dim rowVoti As EAPVoti.VotiRow = tableVoti.NewVotiRow

                    rowVoti.Collegio = collegio
                    rowVoti.Lista_o_Candidato = nomeCandidato
                    rowVoti.Numero = numero
                    rowVoti.Voti_Contestati = votiContestati
                    rowVoti.Voti_Validi = votiValidi

                    tableVoti.AddVotiRow(rowVoti)
                Next
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetCandidati(ByVal IDConsultazione As Integer, ByVal IDLista As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_candidatiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDLista(IDConsultazione, IDLista)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and id_lista=" + IDLista.ToString(), "num_cand")
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetIDLista(ByVal IDConsultazione As Integer, ByVal descrizione As String) As Integer
        Try
            Dim lista As EAPVoti.soraldo_ele_listaRow = GetLista(IDConsultazione, descrizione)
            If (Not lista Is Nothing) Then
                Dim IDLista As Integer = lista.id_lista
                Return IDLista

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiValidiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataRow() = GetVotiLista(IDConsultazione, IDLista)
            Dim votiValidi As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_listaRow In voti
                Dim IDSezione As Integer = voto.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    votiValidi += voto.voti
                End If
            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiContestatiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataRow() = GetVotiLista(IDConsultazione, IDLista)
            Dim votiContestati As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_listaRow In voti
                Dim IDSezione As Integer = voto.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    votiContestati += voto.cont
                End If
            Next
            Return votiContestati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function IsInCollegio(ByVal IDConsultazione As Integer, ByVal IDCollegio As Integer, ByVal IDSezione As Integer) As Boolean
        Try
            If (IDCollegio <> -1) Then
                Dim adapter As New EAPVotiTableAdapters.soraldo_ele_collegi_sezioniTableAdapter
                Dim table As DataTable = adapter.GetDataByIDConsultazioneIDCollegioIDSezione(IDConsultazione, IDCollegio, IDSezione)
                Dim inCollegio As Boolean = (table.Rows.Count >= 1)
                Return inCollegio
            Else
                Return True
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return False

    End Function

    Private Function GetVotiValidiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer) As Integer
        Try
            Dim voti As DataRow() = GetVotiCandidato(IDConsultazione, IDCandidato)
            Dim votiValidi As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_candidatiRow In voti
                votiValidi += voto.voti
            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiValidiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataRow() = GetVotiGruppo(IDConsultazione, IDGruppo)
            Dim votiValidi As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_gruppoRow In voti
                Dim IDSezione As Integer = voto.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    votiValidi += voto.voti
                End If
            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiContestatiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer) As Integer
        Try
            Dim voti As DataRow() = GetVotiCandidato(IDConsultazione, IDCandidato)
            Dim votiContestati As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_candidatiRow In voti
                votiContestati += voto.cont
            Next
            Return votiContestati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiContestatiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataRow() = GetVotiGruppo(IDConsultazione, IDGruppo)
            Dim votiContestati As Integer = 0
            For Each voto As EAPVoti.soraldo_ele_voti_gruppoRow In voti
                Dim IDSezione As Integer = voto.id_sez
                If (IsInCollegio(IDConsultazione, IDCollegio, IDSezione)) Then
                    votiContestati += voto.cont
                End If

            Next
            Return votiContestati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function



    Private Function GetVotiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_voti_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDLista(IDConsultazione, IDLista)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and id_lista=" + IDLista.ToString())
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_voti_candidatiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDCandidato(IDConsultazione, IDCandidato)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and id_cand=" + IDCandidato.ToString())
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDGruppo(IDConsultazione, IDGruppo)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and id_gruppo=" + IDGruppo.ToString())
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private tableVoti As New EAPVoti.VotiDataTable

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

    Private Sub cboConsultazioni_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboConsultazioni.SelectedIndexChanged
        Try
            Dim descrizione As String = cboConsultazioni.SelectedItem
            LoadVisualizzazioni(descrizione)
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadVisualizzazioni(ByVal descrizione As String)
        Try
            cboVisualizzazione.Items.Clear()
            cboCollegio.Items.Clear()

            If (descrizione.IndexOf("Europee") >= 0) Then
                cmdDownloadXLSEuropee.Enabled = True
                cboVisualizzazione.Items.Add("Tutte le Liste")

                Dim IDConsultazione As Integer = GetIDConsultazione(descrizione)
                Dim liste As DataRow() = GetListe(IDConsultazione)
                For Each lista As EAPVoti.soraldo_ele_listaRow In liste
                    Dim nomeLista As String = lista.descrizione
                    cboVisualizzazione.Items.Add(nomeLista)
                Next

            ElseIf (descrizione.IndexOf("Provinciali") >= 0) Then
                cmdDownloadXLSEuropee.Enabled = False

                cboVisualizzazione.Items.Add("Candidati Presidenti")
                cboVisualizzazione.Items.Add("Preferenze di Lista")
                cboCollegio.Items.Add("Tutti i Collegi")
            ElseIf (descrizione.IndexOf("Referendum") >= 0) Then
                cmdDownloadXLSEuropee.Enabled = False

                cboVisualizzazione.Items.Add("Quesito Referendum")
                cboCollegio.Items.Add("Tutti i Collegi")
            End If

            Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(descrizione)
            Dim collegi As DataRow() = GetCollegi(IDConsultazioneGenerale)
            For Each collegio As EAPVoti.soraldo_ele_collegiRow In collegi
                Dim nomeCollegio As String = collegio.descrizione
                cboCollegio.Items.Add(nomeCollegio)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetListe(ByVal IDConsultazione As Integer) As DataRow()
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString(), "num_lista")
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetLista(ByVal IDConsultazione As Integer, ByVal descrizione As String) As DataRow
        Try
            Dim adapter As New EAPVotiTableAdapters.soraldo_ele_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneDescrizione(IDConsultazione, descrizione)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and descrizione='" + descrizione + "'")
            If (rows.Length >= 1) Then
                Dim row As EAPVoti.soraldo_ele_listaRow = rows(0)
                Return row
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

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

    Private Sub cmdDownloadXLSEuropee_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdDownloadXLSEuropee.Click
        Try
            Dim fileName As String = "Cosenza_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileTemplate As String = pathRoot + "Templates\Cosenza.xls"
            Dim fileDestination As String = pathRoot + "Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New OfficeUtility.ExcelUtility
            excel.OpenWorkBook(fileDestination)
            Dim row As Integer = 2
            Dim col As Integer = 1
            Dim sheetName As String = "EUROPEE_COSENZA_COSENZA"

            Dim descrizione As String = cboConsultazioni.SelectedItem
            Dim IDConsultazione As Integer = GetIDConsultazione(descrizione)
            Dim liste As DataRow() = GetListe(IDConsultazione)
            For Each lista As EAPVoti.soraldo_ele_listaRow In liste
                Dim numeroLista As Integer = lista.num_lista
                Dim IDLista As Integer = lista.id_lista
                Dim candidati As DataRow() = GetCandidati(IDConsultazione, IDLista)
                For Each candidato As EAPVoti.soraldo_ele_candidatiRow In candidati
                    Dim numeroCandidato As Integer = candidato.num_cand
                    Dim IDCandidato As Integer = candidato.id_cand
                    Dim voti As Integer = GetVotiValidiCandidato(IDConsultazione, IDCandidato)
                    row = GetRowIndex(excel, sheetName, numeroLista, numeroCandidato)
                    excel.SetValue(sheetName, row, col, voti)
                Next
            Next

            excel.CloseWorkBook(True, fileDestination)
            excel.Quit()

            Dim objLinkParameters As New LinkParameters()
            objLinkParameters.Target = "_self"
            Link.Open("Resources/Reports/", objLinkParameters)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetRowIndex(ByVal excel As OfficeUtility.ExcelUtility, ByVal sheetName As String, ByVal numeroLista As Integer, ByVal numeroCandidato As Integer) As Integer
        Try
            Dim row As Integer = 2
            Dim trovato As Boolean = False
            Do While Not trovato
                Dim nLista As Integer = excel.GetValue(sheetName, row, 4)
                If (nLista = numeroLista) Then
                    Dim nCandidato As Integer = excel.GetValue(sheetName, row, 2)
                    If (nCandidato = numeroCandidato) Then
                        Return row
                    End If
                End If
                row += 1
            Loop
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub cmdIndietro_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdIndietro.Click
        Try
            Dim eHomepage As New eStart
            Context.Transfer(eHomepage)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdLogout_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdLogout.Click
        Try
            Dim login As New Homepage
            Context.Transfer(login)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdDownloadXLS_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdDownloadXLS.Click
        Try
            Dim fileName As String = "Cosenza_Scrutinio_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileXLS As String = pathRoot + "Reports\" + fileName
            Dim excel As New OfficeUtility.ExcelUtility
            excel.CreateWorkBook()

            Dim sheetName As String = "Scrutinio"
            excel.CreateSheet(sheetName)

            Dim row As Integer = 1
            Dim consultazione As String = cboConsultazioni.SelectedItem
            excel.SetValue(sheetName, row, 1, "CONSULTAZIONE")
            excel.SetValue(sheetName, row, 2, consultazione)
            row += 1

            Dim visualizzazione As String = cboVisualizzazione.SelectedItem
            excel.SetValue(sheetName, row, 1, "VISUALIZZAZIONE")
            excel.SetValue(sheetName, row, 2, visualizzazione)
            row += 1

            Dim collegio As String = cboCollegio.SelectedItem
            excel.SetValue(sheetName, row, 1, "COLLEGIO")
            excel.SetValue(sheetName, row, 2, collegio)
            row += 1

            Dim sezioniRilevate As String = lblSezioniRilevate.Text
            excel.SetValue(sheetName, row, 1, "SEZIONI")
            excel.SetValue(sheetName, row, 2, sezioniRilevate)
            row += 1

            Dim col As Integer = 1
            For Each column As Gizmox.WebGUI.Forms.DataGridViewColumn In grid.Columns
                row = 6

                Dim columnName As String = column.Name
                excel.SetValue(sheetName, row, col, columnName)
                row += 1
                For Each rowGrid As Gizmox.WebGUI.Forms.DataGridViewRow In grid.Rows
                    If (Not IsDBNull(rowGrid.Cells(columnName).Value)) Then
                        Dim value As String = rowGrid.Cells(columnName).Value
                        excel.SetValue(sheetName, row, col, value)
                    End If

                    row += 1
                Next
                col += 1
            Next

            row += 1

            Dim votanti As String = txtTotVotanti.Text
            excel.SetValue(sheetName, row, 1, "VOTANTI")
            excel.SetValue(sheetName, row, 2, votanti)
            row += 1

            Dim validi As String = txtTotValidi.Text
            excel.SetValue(sheetName, row, 1, "VALIDI")
            excel.SetValue(sheetName, row, 2, validi)
            row += 1

            Dim contestate As String = txtTotContestati.Text
            excel.SetValue(sheetName, row, 1, "CONTESTATE")
            excel.SetValue(sheetName, row, 2, contestate)
            row += 1

            Dim nulle As String = txtTotNulle.Text
            excel.SetValue(sheetName, row, 1, "NULLE")
            excel.SetValue(sheetName, row, 2, nulle)
            row += 1

            Dim bianche As String = txtTotBianche.Text
            excel.SetValue(sheetName, row, 1, "BIANCHE")
            excel.SetValue(sheetName, row, 2, bianche)
            row += 1


            excel.CloseWorkBook(True, fileXLS)
            excel.Quit()


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub



End Class
