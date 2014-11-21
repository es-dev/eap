Imports Gizmox.WebGUI.Forms


Public Class Scrutinio

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

            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table As EAPModel.soraldo_ele_consultazioneDataTable = adapter.GetData
            For Each row As EAPModel.soraldo_ele_consultazioneRow In table
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
                    Dim sezioniRilevate As Integer = 0
                    Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(consultazione)
                    If (visualizzazione = "Candidati Gruppo") Then
                        ShowDatiPresidenti(IDConsultazione, consultazione)
                    ElseIf (visualizzazione = "Preferenze di Lista") Then
                        ShowDatiListe(IDConsultazione, consultazione)
                    ElseIf (visualizzazione = "Quadrature x Sezioni") Then
                        ShowQuadratureSezione(IDConsultazione, consultazione)
                    End If

                    Dim numeroSezioniCollegio As Integer = GetNumeroSezioniCollegio(IDConsultazione)
                    sezioniRilevate = GetSezioniRilevate(IDConsultazione)
                    lblSezioniRilevate.Text = "Sezioni rilevate " + sezioniRilevate.ToString + " su " + numeroSezioniCollegio.ToString

                    Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
                    Dim sezioniValidate = sezioniIDs.Count
                    lblSezioniValidate.Text = "Sezioni validate " + sezioniValidate.ToString + " su " + numeroSezioniCollegio.ToString

                    CalcoloTotaliSchede(IDConsultazione, consultazione)

                End If
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub SetStyleGrid()
        Try
            grid.Columns(0).Width = 120
            grid.Columns(2).Width = 300

        Catch ex As Exception

        End Try
    End Sub

    Private Function GetNumeroSezioniCollegio(ByVal IDConsultazione As Integer) As Integer
        Try
            Dim numeroSezioniCollegio As Integer = 82
            Return numeroSezioniCollegio

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub CalcoloTotaliSchedeReferendum(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim totBianche As Integer = 0
            Dim totContestati As Integer = 0
            Dim totNulle As Integer = 0
            Dim totValidi As Integer = 0
            Dim totVotantiM As Integer = 0
            Dim totVotantiF As Integer = 0
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni = GetSezioniIDs(IDConsultazione, consultazione)
            For Each IDSezione As Integer In sezioni
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    totBianche += row.bianchi
                    totContestati += row.contestati
                    totNulle += row.nulli
                    totValidi += row.validi
                End If
                totVotantiF += GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                totVotantiM += GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)

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

    Private Sub CalcoloTotaliSchede(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim totBianche As Integer = 0
            Dim totContestati As Integer = 0
            Dim totNulle As Integer = 0
            Dim totValidi As Integer = 0
            Dim totVotantiM As Integer = 0
            Dim totVotantiF As Integer = 0
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni = GetSezioniIDs(IDConsultazione, consultazione)
            For Each IDSezione As Integer In sezioni
                Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
                If (table.Count >= 1) Then
                    Dim row = table(0)
                    totBianche += row.bianchi
                    totContestati += row.contestati
                    totNulle += row.nulli
                    totValidi += row.validi
                    totVotantiF += GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                    totVotantiM += GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
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

    Private Function GetSezioniRilevate(ByVal IDConsultazione As Integer) As Integer
        Try
            Dim sezioniRilevate As Integer = 0
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(IDConsultazione)
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                sezioniRilevate += 1
            Next

            Return sezioniRilevate

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSezioniRilevateReferendum(ByVal IDConsultazione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_refTableAdapter
            Dim table = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table.Count

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub ShowDatiPresidenti(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim tableVoti As New EAPModel.VotiDataTable

            Dim gruppi = GetGruppi(IDConsultazione)
            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
            For Each gruppo As EAPModel.soraldo_ele_gruppoRow In gruppi.Rows
                Dim nomePresidente As String = gruppo.descrizione
                Dim numero As Integer = gruppo.num_gruppo
                Dim IDGruppo As Integer = gruppo.id_gruppo
                Dim votiValidi As Integer = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                Dim votiSoloLista As Integer = GetVotiSoloGruppo(IDConsultazione, IDGruppo, sezioniIDs)

                Dim rowVoti As EAPModel.VotiRow = tableVoti.NewVotiRow

                rowVoti.Collegio = "Cosenza"
                rowVoti.Lista_o_Candidato = nomePresidente
                rowVoti.Numero = numero
                rowVoti.Solo_Sindaco = votiSoloLista
                rowVoti.Voti_Validi = votiValidi

                tableVoti.AddVotiRow(rowVoti)
            Next

            grid.DataSource = tableVoti
            SetStyleGrid()


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Public Function GetGruppi(ByVal IDConsultazione As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub ShowDatiListe(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim tableVoti As New EAPModel.VotiDataTable

            Dim liste = GetListe(IDConsultazione)
            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
            For Each lista As EAPModel.soraldo_ele_listaRow In liste.Rows
                Dim nomeLista As String = lista.descrizione
                Dim numero As Integer = lista.num_lista
                Dim IDLista As Integer = lista.id_lista
                Dim votiValidi As Integer = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                Dim rowVoti As EAPModel.VotiRow = tableVoti.NewVotiRow

                rowVoti.Collegio = "Cosenza"
                rowVoti.Lista_o_Candidato = nomeLista
                rowVoti.Numero = numero
                rowVoti.Solo_Sindaco = ""
                rowVoti.Voti_Validi = votiValidi

                tableVoti.AddVotiRow(rowVoti)
            Next

            grid.DataSource = tableVoti
            SetStyleGrid()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowQuadratureSezioneBallottaggio(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim table As New EAPModel.QuadratureSezioniBallottaggioDataTable
            Dim tableSezioni = GetSezioni(IDConsultazione)
            Dim tableVotiGruppo = GetVotiGruppo(IDConsultazione)
            For Each rowSezione As EAPModel.soraldo_ele_sezioniRow In tableSezioni.Rows
                Dim IDSezione = rowSezione.id_sez
                Dim row = table.NewQuadratureSezioniBallottaggioRow
                row.Sezione = rowSezione.num_sez
                row.Elettori = rowSezione.maschi + rowSezione.femmine
                Dim votantiM = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                Dim votantiF = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                row._Votanti_F_ = votantiM + votantiF
                row._Voti_Validi_A_ = rowSezione.validi
                row._Schede_Bianche_B_ = rowSezione.bianchi
                row._Schede_Nulle_C_ = rowSezione.nulli
                row._Schede_Contestate_D_ = rowSezione.contestati
                row._Totale_E_A_B_C_D_F_ = Int(row._Voti_Validi_A_) + Int(row._Schede_Bianche_B_) + Int(row._Schede_Nulle_C_) + Int(row._Schede_Contestate_D_)
                row._Totale_Sindaco_G_A_ = GetVotiGruppoTotale(IDConsultazione, IDSezione, tableVotiGruppo)
                row.Stato = GetStatoSezioneBallottaggio(IDConsultazione, IDSezione, consultazione)

                table.AddQuadratureSezioniBallottaggioRow(row)
            Next

            grid.DataSource = table
            grid.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.AllCells


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowQuadratureSezioneReferendum(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim table As New EAPModel.QuadratureSezioniReferendumDataTable
            Dim tableSezioni = GetSezioni(IDConsultazione)
            For Each rowSezione As EAPModel.soraldo_ele_sezioniRow In tableSezioni.Rows
                Dim IDSezione = rowSezione.id_sez
                Dim row = table.NewQuadratureSezioniReferendumRow
                row.Sezione = rowSezione.num_sez
                Dim maschi = 0
                If (Not rowSezione.IsmaschiNull) Then maschi = rowSezione.maschi
                Dim femmine = 0
                If (Not rowSezione.IsfemmineNull) Then femmine = rowSezione.femmine
                row.Elettori = maschi + femmine
                Dim votantiM = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                Dim votantiF = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                row._Votanti_F_E_ = votantiM + votantiF

                Dim rowReferendum = GetVotiReferendum(IDConsultazione, IDSezione)
                row._Voti_Validi_A_ = 0
                row._Schede_Bianche_B_ = 0
                row._Schede_Nulle_C_ = 0
                row._Schede_Contestate_D_ = 0
                If (Not rowReferendum Is Nothing) Then
                    row._Voti_Validi_A_ = rowReferendum.validi
                    row._Schede_Bianche_B_ = rowReferendum.bianchi
                    row._Schede_Nulle_C_ = rowReferendum.nulli
                    row._Schede_Contestate_D_ = rowReferendum.contestati
                End If
                row._Totale_E_A_B_C_D_ = Int(row._Voti_Validi_A_) + Int(row._Schede_Bianche_B_) + Int(row._Schede_Nulle_C_) + Int(row._Schede_Contestate_D_)
                row._Totale_Referendum_G_A_ = GetVotiReferendumTotale(IDConsultazione, IDSezione)
                row.Stato = GetStatoSezioneReferendum(IDConsultazione, IDSezione, consultazione)

                table.AddQuadratureSezioniReferendumRow(row)
            Next

            grid.DataSource = table
            grid.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.AllCells


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Private Sub ShowQuadratureSezione(ByVal IDConsultazione As Integer, consultazione As String)
        Try
            Dim table As New EAPModel.QuadratureSezioniDataTable
            Dim tableSezioni = GetSezioni(IDConsultazione)
            Dim numeroGruppi = GetNumeroGruppi(IDConsultazione)
            Dim tableVotiCandidati = GetVotiCandidati(IDConsultazione)
            Dim tableCandidati = GetCandidati(IDConsultazione)
            Dim tableVotiLista = GetVotiLista(IDConsultazione)
            Dim tableListe = GetListe(IDConsultazione)
            Dim tableVotiGruppo = GetVotiGruppo(IDConsultazione)
            Dim tableGruppi = GetGruppi(IDConsultazione)
            For Each rowSezione As EAPModel.soraldo_ele_sezioniRow In tableSezioni.Rows
                Dim IDSezione = rowSezione.id_sez
                Dim row = table.NewQuadratureSezioniRow
                row.Collegio = "Cosenza"
                row.Sezione = rowSezione.num_sez
                row.ElettoriM = rowSezione.maschi
                row.ElettoriF = rowSezione.femmine
                row.Elettori = rowSezione.maschi + rowSezione.femmine
                row.VotantiM = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                row.VotantiF = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                row._Votanti_H_ = Int(row.VotantiM) + Int(row.VotantiF)
                row._Voti_Validi_C_ = rowSezione.validi
                row._Schede_Bianche_D_ = rowSezione.bianchi
                row._Schede_Nulle_E_ = rowSezione.nulli
                row._Schede_Contestate_F_ = rowSezione.contestati
                row._Totale_G_C_D_E_F_ = Int(row._Voti_Validi_C_) + Int(row._Schede_Bianche_D_) + Int(row._Schede_Nulle_E_) + Int(row._Schede_Contestate_F_)
                row._Voti_Sindaco_B_ = GetVotiSoloGruppoTotale(IDConsultazione, IDSezione)
                row._Voti_Liste_A_C_B_ = GetVotiListeTotale(IDConsultazione, IDSezione, tableVotiLista)
                row.Stato = GetStatoSezione(IDConsultazione, IDSezione, consultazione, numeroGruppi, tableVotiCandidati, tableCandidati, _
                                            tableVotiLista, tableListe, tableVotiGruppo, tableGruppi, tableSezioni)

                table.AddQuadratureSezioniRow(row)
            Next

            grid.DataSource = table
            grid.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.AllCells


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function GetStatoSezione(IDConsultazione As Integer, IDSezione As Integer, consultazione As String, numeroGruppi As Integer, tableVotiCandidati As DataTable, _
                                    tableCandidati As DataTable, tableVotiLista As DataTable, tableListe As DataTable, tableVotiGruppo As DataTable, _
                                    tableGruppi As DataTable, tableSezioni As DataTable) As String
        Try
            Dim stato = ""
            ' Dim adapterSezioni As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            'Dim tableSezioni = adapterSezioni.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim rows = tableSezioni.Select("id_sez=" + IDSezione.ToString)
            If (rows.Count >= 1) Then
                Dim rowSezione As EAPModel.soraldo_ele_sezioniRow = rows(0)

                'Controllo Votanti>Elettori
                Dim elettori = rowSezione.maschi + rowSezione.femmine
                Dim votantiMaschi = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                Dim votantiFemmine = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                Dim votanti = votantiMaschi + votantiFemmine
                If (votanti > elettori) Then
                    stato = "ERRORE: Numero Votanti maggiore del Numero Elettori"
                End If

                'Controllo G=C+D+E+F+H, G=Votanti
                Dim V = rowSezione.validi
                Dim C = rowSezione.solo_gruppo
                Dim D = rowSezione.bianchi
                Dim E = rowSezione.nulli
                Dim F = rowSezione.contestati
                Dim H = rowSezione.voti_nulli
                Dim G = V + D + E + F + H

                If (stato = "") Then
                    If (G <> votanti) Then
                        stato += " | ERRORE: Validi+Bianchi+Nulle+Contestati non coincide con i Votanti (G=" + G.ToString() + " | Votanti=" + votanti.ToString() + ")"
                    End If

                    If (stato = "") Then
                        'Controllo A<>C-B, A=VotiTotaliListe
                        Dim A = GetVotiListeTotale(IDConsultazione, IDSezione, tableVotiLista)
                        Dim B = GetVotiGruppoTotale(IDConsultazione, IDSezione, tableVotiGruppo)
                        If (A + C <> B) Then
                            stato += " | ERRORE: Totale Voti Liste + Voti Espressi solo a Presidente non coincide con il Totale Presidenti (A+C=" + (A + C).ToString() + " | B=" + V.ToString() + ")"
                        End If

                        If (stato = "") Then
                            'Controllo gruppi V=voti validi, B=voti presidenti/sindaci
                            If (V <> B) Then
                                stato += " | ERRORE: Voti ai Presidenti non coincide con i Voti Validi (V=" + V.ToString() + " | B=" + B.ToString() + ")"
                            End If

                            If (stato = "") Then
                                'controllo dei voti di lista per presidente <= voti presidente
                                For numeroGruppo = 1 To numeroGruppi
                                    Dim IDGruppo = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                                    Dim votiGruppo = GetVotiGruppoSezioneTotale(IDConsultazione, IDSezione, IDGruppo, tableVotiGruppo)
                                    Dim numeroListe = GetNumeroListeGruppo(IDConsultazione, IDGruppo, tableListe)
                                    Dim votiListe = 0
                                    For Each numeroLista In numeroListe
                                        Dim IDLista = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                                        Dim votiLista = GetVotiListaSezioneTotale(IDConsultazione, IDSezione, IDLista, tableVotiLista)
                                        Dim numeroCandidati = GetNumeroCandidati(IDConsultazione, IDLista, tableCandidati)
                                        Dim votiCandidati = 0
                                        Dim compilato = True
                                        For numeroCandidato = 1 To numeroCandidati
                                            Dim IDCandidato = GetIDCandidatoFromNumero(IDConsultazione, IDLista, numeroCandidato, tableCandidati)
                                            votiCandidati += GetVotiCandidatoListaTotale(IDConsultazione, IDSezione, IDCandidato, tableVotiCandidati)
                                            If (Not IsVotiCandidatoListaPresenti(IDConsultazione, IDSezione, IDCandidato, tableVotiCandidati)) Then
                                                compilato = False
                                                Exit For
                                            End If
                                        Next
                                        If (votiCandidati > votiLista) Then
                                            stato += " | ERRORE: i Voti dei Candidati superano i Voti della Lista N." + numeroLista.ToString + " (VC=" + votiCandidati.ToString + " | VL=" + votiLista.ToString
                                            Exit For
                                        End If
                                        If (Not compilato) Then
                                            stato += " | ERRORE: i Voti dei Candidati della Lista N." + numeroLista.ToString + " sono assenti"
                                            Exit For
                                        End If
                                        votiListe += votiLista
                                    Next
                                    If (votiListe > votiGruppo) Then
                                        stato += " | ERRORE: i Voti delle Liste superano i Voti del Presidente N." + numeroGruppo.ToString + " (VL=" + votiListe.ToString + " | VP=" + votiGruppo.ToString
                                        Exit For
                                    End If
                                Next

                            End If
                        End If
                    End If
                End If


                If (stato = "" And votanti > 0 And V > 0) Then
                    stato = "OK"
                ElseIf (stato = "" And votanti = 0 And V = 0) Then
                    stato = ""
                ElseIf (stato <> "" And votanti > 0 And V > 0) Then
                    stato += " Consultazione=" + consultazione
                End If

                'sezione speciale 32
                If (rowSezione.num_sez = 32) Then
                    stato = "OK"
                End If

            End If

            Return stato

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return "ERRORE MODULO"

    End Function

    Private Function GetStatoSezioneBallottaggio(IDConsultazione As Integer, IDSezione As Integer, consultazione As String) As String
        Try
            Dim stato = ""
            Dim adapterSezioni As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim tableSezioni = adapterSezioni.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim tableVotiGruppo = GetVotiGruppo(IDConsultazione)
            If (tableSezioni.Count >= 1) Then
                Dim rowSezione = tableSezioni(0)

                'Controllo Votanti>Elettori
                Dim elettori = rowSezione.maschi + rowSezione.femmine
                Dim votantiMaschi = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                Dim VotantiFemmine = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                Dim F = votantiMaschi + VotantiFemmine
                If (F > elettori) Then
                    stato = "ERRORE: Votanti>Elettori"
                End If

                'Controllo E=A+B+C+D, E=F=Votanti
                Dim A = rowSezione.validi
                Dim B = rowSezione.bianchi
                Dim C = rowSezione.nulli
                Dim D = rowSezione.contestati
                Dim E = A + B + C + D
                If (E <> F) Then
                    stato += " | ERRORE: Validi+Bianchi+Nulle+Contestati<>Votanti"
                End If

                'Controllo G=A
                Dim G = GetVotiGruppoTotale(IDConsultazione, IDSezione, tableVotiGruppo)
                If (A <> G) Then
                    stato += " | ERRORE: Voti Capo Gruppo<>Voti Validi"
                End If

                If (stato = "" And F > 0) Then
                    stato = "OK"
                End If


                'sezione speciale 32
                Dim numeroSezione = GetNumeroSezione(IDConsultazione, IDSezione)
                If (numeroSezione = 32 And E = F And A = G And F > 0) Then
                    stato = "OK"
                End If

            End If

            Return stato

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return "ERRORE MODULO"

    End Function

    Public Function GetStatoSezioneReferendum(IDConsultazione As Integer, IDSezione As Integer, consultazione As String) As String
        Try
            Dim stato = ""
            Dim adapterSezioni As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim tableSezioni = adapterSezioni.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            If (tableSezioni.Count >= 1) Then
                Dim rowSezione = tableSezioni(0)

                'Controllo Votanti>Elettori
                Dim maschi = 0
                If (Not rowSezione.IsmaschiNull) Then maschi = rowSezione.maschi
                Dim femmine = 0
                If (Not rowSezione.IsfemmineNull) Then femmine = rowSezione.femmine
                Dim elettori = maschi + femmine
                Dim votantiMaschi = GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
                Dim VotantiFemmine = GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
                Dim F = votantiMaschi + VotantiFemmine


                'Controllo E=A+B+C+D, E=F=Votanti
                Dim A = 0 : Dim B = 0 : Dim C = 0 : Dim D = 0
                Dim rowReferendum = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not rowReferendum Is Nothing) Then
                    A = rowReferendum.validi
                    B = rowReferendum.bianchi
                    C = rowReferendum.nulli
                    D = rowReferendum.contestati
                End If

                If (A > 0) Then
                    'Controllo votanti>elettori
                    If (F > elettori) Then
                        stato = "ERRORE: Votanti>Elettori"
                    End If

                    Dim E = A + B + C + D
                    If (E <> F) Then
                        stato += " | ERRORE: Validi+Bianchi+Nulle+Contestati<>Votanti"
                    End If

                    'Controllo G=A
                    Dim G = GetVotiReferendumTotale(IDConsultazione, IDSezione)
                    If (A <> G) Then
                        stato += " | ERRORE: Voti Referendum Si+No<>Voti Validi"
                    End If

                    If (stato = "" And F > 0) Then
                        stato = "OK"
                    End If


                    'sezione speciale 32
                    Dim numeroSezione = GetNumeroSezione(IDConsultazione, IDSezione)
                    If (numeroSezione = 32 And E = F And A = G And F > 0) Then
                        stato = "OK"
                    End If
                End If

            End If

            Return stato

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return "ERRORE MODULO"

    End Function

    Public Function GetIDSezione(IDConsultazione As Integer, numeroSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneNumeroSezione(IDConsultazione, numeroSezione)
            If (table.Count >= 1) Then
                Dim row = table(0)
                Return row.id_sez

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetNumeroSezione(IDConsultazione As Integer, IDSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            If (table.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_sezioniRow = table(0)
                Dim numeroSezione = row.num_sez
                Return numeroSezione

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiSoloGruppoTotale(IDConsultazione As Integer, IDSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim voti As Integer = 0
            For Each row As EAPModel.soraldo_ele_voti_gruppoRow In table
                voti += row.lista
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiGruppoTotale(IDConsultazione As Integer, IDSezione As Integer, tableVotiGruppo As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            'Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim rows = tableVotiGruppo.Select("id_sez=" + IDSezione.ToString)
            Dim voti As Integer = 0
            For Each row As EAPModel.soraldo_ele_voti_gruppoRow In rows
                voti += row.voti
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiGruppoSezioneTotale(IDConsultazione As Integer, IDSezione As Integer, IDGruppo As Integer, tableVotiGruppo As DataTable) As Integer
        Try
            Dim rows = GetVotiGruppoSezione(IDConsultazione, IDSezione, IDGruppo, tableVotiGruppo)
            Dim voti As Integer = 0
            For Each row As EAPModel.soraldo_ele_voti_gruppoRow In rows
                voti += row.voti
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiReferendum(IDConsultazione As Integer, IDSezione As Integer) As EAPModel.soraldo_ele_voti_refRow
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_refTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            If (table.Count >= 1) Then
                Dim row = table(0)
                Return row
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiReferendumTotale(IDConsultazione As Integer, IDSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_refTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim voti As Integer = 0
            For Each row As EAPModel.soraldo_ele_voti_refRow In table
                voti += row.si + row.no
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiListeTotale(IDConsultazione As Integer, IDSezione As Integer, tableVotiLista As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            'Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim rows = tableVotiLista.Select("id_sez=" + IDSezione.ToString)
            Dim voti As Integer = 0
            For Each row As EAPModel.soraldo_ele_voti_listaRow In rows
                voti += row.voti
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Public Function GetCandidati(ByVal IDConsultazione As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_candidatiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetIDLista(ByVal IDConsultazione As Integer, ByVal descrizione As String) As Integer
        Try
            Dim lista As EAPModel.soraldo_ele_listaRow = GetLista(IDConsultazione, descrizione)
            If (Not lista Is Nothing) Then
                Dim IDLista As Integer = lista.id_lista
                Return IDLista

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiValidiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, sezioniIDs As ArrayList, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataTable = GetVotiLista(IDConsultazione, IDLista)
            Dim votiValidi As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_listaRow In voti.Rows
                If (sezioniIDs.Contains(voto.id_sez)) Then
                    votiValidi += voto.voti
                End If
            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    'Private Function GetVotiContestatiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
    '    Try
    '        Dim voti As DataTable = GetVotiLista(IDConsultazione, IDLista)
    '        Dim votiContestati As Integer = 0
    '        For Each voto As EAPModel.soraldo_ele_voti_listaRow In voti.Rows
    '            votiContestati += voto.cont
    '        Next
    '        Return votiContestati

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    '    Return -1

    'End Function

    Private Function GetVotiValidiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim voti As DataTable = GetVotiCandidato(IDConsultazione, IDCandidato)
            Dim votiValidi As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_candidatiRow In voti.Rows
                Dim IDSezione = voto.id_sez
                If (sezioniIDs.Contains(IDSezione)) Then
                    votiValidi += voto.voti
                End If
            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetVotiValidiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer, ByVal sezioniIDs As ArrayList) As Integer
        Try
            Dim voti As DataTable = GetVotiGruppo(IDConsultazione, IDGruppo)
            Dim votiValidi As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_gruppoRow In voti.Rows
                Dim IDSezione As Integer = voto.id_sez
                If (sezioniIDs.Contains(IDSezione)) Then
                    votiValidi += voto.voti
                End If

            Next
            Return votiValidi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    'Private Function GetVotiContestatiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer, sezioniIDs As ArrayList) As Integer
    '    Try
    '        Dim voti As DataTable = GetVotiCandidato(IDConsultazione, IDCandidato)
    '        Dim votiContestati As Integer = 0
    '        For Each voto As EAPModel.soraldo_ele_voti_candidatiRow In voti.Rows
    '            Dim IDSezione = voto.id_sez
    '            If (sezioniIDs.Contains(IDSezione)) Then
    '                votiContestati += voto.cont
    '            End If
    '        Next
    '        Return votiContestati

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    '    Return -1

    'End Function

    'Private Function GetVotiContestatiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer, Optional ByVal IDCollegio As Integer = -1) As Integer
    '    Try
    '        Dim voti As DataTable = GetVotiGruppo(IDConsultazione, IDGruppo)
    '        Dim votiContestati As Integer = 0
    '        For Each voto As EAPModel.soraldo_ele_voti_gruppoRow In voti.Rows
    '            Dim IDSezione As Integer = voto.id_sez
    '            votiContestati += voto.cont

    '        Next
    '        Return votiContestati

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    '    Return -1

    'End Function

    Private Function GetVotiSoloGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer, sezioniIDs As ArrayList, Optional ByVal IDCollegio As Integer = -1) As Integer
        Try
            Dim voti As DataTable = GetVotiGruppo(IDConsultazione, IDGruppo)
            Dim votiSoloGruppo As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_gruppoRow In voti.Rows
                Dim IDSezione As Integer = voto.id_sez
                If (sezioniIDs.Contains(IDSezione)) Then
                    votiSoloGruppo += voto.lista
                End If
            Next
            Return votiSoloGruppo

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Private Function GetVotiLista(ByVal IDConsultazione As Integer, ByVal IDLista As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDLista(IDConsultazione, IDLista)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Public Function GetVotiLista(ByVal IDConsultazione As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiListaSezione(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDLista As Integer, tableVotiLista As DataTable) As DataRow()
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneIDSezioneIDLista(IDConsultazione, IDSezione, IDLista)
            Dim rows = tableVotiLista.Select("id_sez=" + IDSezione.ToString + " and id_lista=" + IDLista.ToString)
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiListaSezioneTotale(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDLista As Integer, tableVotiLista As DataTable) As Integer
        Try
            Dim rows = GetVotiListaSezione(IDConsultazione, IDSezione, IDLista, tableVotiLista)
            Dim voti = 0
            For Each row As EAPModel.soraldo_ele_voti_listaRow In rows
                voti += row.voti
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return 0

    End Function

    Private Function GetVotiCandidato(ByVal IDConsultazione As Integer, ByVal IDCandidato As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_candidatiTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDCandidato(IDConsultazione, IDCandidato)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiCandidatoSezione(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDCandidato As Integer, tableVotiCandidati As DataTable) As DataRow()
        Try
            Dim rows = tableVotiCandidati.Select("id_sez=" + IDSezione.ToString + " and id_cand=" + IDCandidato.ToString)
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetVotiCandidatoListaTotale(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDCandidato As Integer, tableVotiCandidati As DataTable) As Integer
        Try
            Dim rows = GetVotiCandidatoSezione(IDConsultazione, IDSezione, IDCandidato, tableVotiCandidati)
            Dim voti = 0
            For Each row As EAPModel.soraldo_ele_voti_candidatiRow In rows
                voti += row.voti
            Next
            Return voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return 0

    End Function

    Private Function IsVotiCandidatoListaPresenti(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDCandidato As Integer, tableVotiCandidati As DataTable) As Boolean
        Try
            Dim exist = True
            Dim rows = GetVotiCandidatoSezione(IDConsultazione, IDSezione, IDCandidato, tableVotiCandidati)
            For Each row As EAPModel.soraldo_ele_voti_candidatiRow In rows
                If (row.IsNull("voti")) Then
                    exist = False
                    Exit For
                End If
            Next
            Return exist

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return 0

    End Function


    Private Function GetVotiGruppo(ByVal IDConsultazione As Integer, ByVal IDGruppo As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneIDGruppo(IDConsultazione, IDGruppo)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Public Function GetVotiGruppo(ByVal IDConsultazione As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function



    Private Function GetVotiGruppoSezione(ByVal IDConsultazione As Integer, IDSezione As Integer, ByVal IDGruppo As Integer, tableVotiGruppo As DataTable) As DataRow()
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_gruppoTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneIDSezioneIDGruppo(IDConsultazione, IDSezione, IDGruppo)
            Dim rows = tableVotiGruppo.Select("id_sez=" + IDSezione.ToString + " and id_gruppo=" + IDGruppo.ToString)
            Return rows

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Public Function GetIDConsultazione(ByVal descrizione As String) As Integer
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

    Public Function GetConsultazione(ByVal IDConsultazioneGenerale As Integer) As String
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim table = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            If (table.Count >= 1) Then
                Dim row = table(0)
                Return row.descrizione
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

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

    Private Sub cboConsultazioni_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboConsultazioni.SelectedIndexChanged
        Try
            Dim descrizione As String = cboConsultazioni.SelectedItem
            LoadVisualizzazioni(descrizione)
            grid.DataSource = Nothing

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadVisualizzazioni(ByVal descrizione As String)
        Try
            cboVisualizzazione.Items.Clear()
            cboVisualizzazione.Items.Add("Candidati Gruppo")
            cboVisualizzazione.Items.Add("Preferenze di Lista")
            cboVisualizzazione.Items.Add("Quadrature x Sezioni")
            cboVisualizzazione.Text = ""
            cboVisualizzazione.SelectedItem = Nothing


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function GetListe(ByVal IDConsultazione As Integer) As DataTable
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Function GetLista(ByVal IDConsultazione As Integer, ByVal descrizione As String) As DataRow
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneDescrizione(IDConsultazione, descrizione)
            Dim rows As DataRow() = table.Select("id_cons=" + IDConsultazione.ToString() + " and descrizione='" + descrizione + "'")
            If (rows.Length >= 1) Then
                Dim row As EAPModel.soraldo_ele_listaRow = rows(0)
                Return row
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub cmdScrutinioParziale_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdScrutinioParziale.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)

            Dim pathRoot = UtilityContainer.GetRootPath(Context)
            Dim templateName As String = "Scrutini_Liste_Europee_F2003_2014" ' IIf(consultazione = "Camera 2013", "Camera2013", "Senato2013")
            Dim fileTemplate As String = pathRoot + "Resources\Templates\" + templateName + ".xls"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Scrutinio2014(consultazione, pathRoot, fileTemplate, fileName, sezioniIDs)
            MessageBoxShow("Calcolo degli scrutini parziali completato con successo. E' possibile accedere all'area reports per effettuare il download del report in formato XLS. Verificare le quadrature prima di trasmettere i dati alla Prefettura.")


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Sub Scrutinio2014(consultazione As String, pathRoot As String, fileTemplate As String, fileName As String, sezioniIDs As ArrayList)
        Try
            Dim fileDestination As String = pathRoot + "Resources\Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New Spire.Xls.Workbook()
            excel.Version = Spire.Xls.ExcelVersion.Version2007
            excel.LoadFromFile(fileDestination)

            Dim sheetName As String = "Foglio1"
            Dim sheet = excel.Worksheets(sheetName)

            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim numeroSezioniCollegio As Integer = 82
                Dim sezioniRilevate As Integer = sezioniIDs.Count

                'scrittura codice segreto
                sheet.SetValue(2, 1, 1183)

                Dim col = 2
                sheet.SetValue(2, col, sezioniRilevate.ToString)
                col += 1

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                sheet.SetValue(2, col, votantiMaschi.ToString)
                col += 1

                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                sheet.SetValue(2, col, votantiFemmine.ToString)
                col += 1

                Dim votantiTotali = votantiMaschi + votantiFemmine
                sheet.SetValue(2, col, votantiTotali.ToString)
                col += 1

                'voti di lista
                Dim votiTotaliListe As Integer = 0
                Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
                Dim tableListe = GetListe(IDConsultazione)
                For numeroLista As Integer = 1 To numeroListe
                    Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                    Dim voti = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                    sheet.SetValue(2, col, voti.ToString)
                    col += 1
                    votiTotaliListe += voti
                Next
                sheet.SetValue(2, col, votiTotaliListe.ToString)
                col += 1

                'totali per gruppo
                Dim votiTotaliGruppi As Integer = 0
                Dim numeroGruppi As Integer = GetNumeroGruppi(IDConsultazione)
                Dim tableGruppi = GetGruppi(IDConsultazione)
                For numeroGruppo As Integer = 1 To numeroGruppi
                    Dim IDGruppo As Integer = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                    Dim voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                    sheet.SetValue(2, col, voti.ToString)
                    col += 1
                    votiTotaliGruppi += voti
                Next
                sheet.SetValue(2, col, votiTotaliGruppi.ToString)
                col += 1


                'totali e quadrature
                Dim soloGruppo = GetVotiSoloGruppo(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, soloGruppo.ToString)
                col += 1

                Dim schedeBianche = GetSchedeBianche(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeBianche.ToString)
                col += 1

                Dim schedeNulle = GetSchedeNulle(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeNulle.ToString)
                col += 1

                Dim schedeContestate = GetSchedeContestate(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeContestate.ToString)
                col += 1

                Dim votiTotali = votiTotaliGruppi + schedeBianche + schedeNulle + schedeContestate
                sheet.SetValue(2, col, votiTotali.ToString)

                'sheet.Unprotect()
                'excel.UnProtect()
                excel.Save()

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Sub Scrutinio2013(consultazione As String, pathRoot As String, fileTemplate As String, fileName As String)
        Try
            Dim fileDestination As String = pathRoot + "Resources\Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New Spire.Xls.Workbook()
            excel.Version = Spire.Xls.ExcelVersion.Version97to2003
            excel.LoadFromFile(fileDestination)

            Dim sheetName As String = IIf(consultazione = "Camera 2013", "camera", "senato")
            Dim sheet = excel.Worksheets(sheetName)

            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim numeroSezioniCollegio As Integer = 82
                Dim sezioniIDs As ArrayList = GetSezioniIDs(IDConsultazione, consultazione) 'sono le sole sezioni rilevate...
                Dim sezioniRilevate As Integer = sezioniIDs.Count
                Dim col = 2
                sheet.SetValue(2, col, sezioniRilevate.ToString)
                col += 1

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                sheet.SetValue(2, col, votantiMaschi.ToString)
                col += 1

                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                sheet.SetValue(2, col, votantiFemmine.ToString)
                col += 1

                Dim votantiTotali = votantiMaschi + votantiFemmine
                sheet.SetValue(2, col, votantiTotali.ToString)
                col += 1

                'voti di lista
                Dim votiTotaliListe As Integer = 0
                Dim numeroGruppi As Integer = GetNumeroGruppi(IDConsultazione)
                Dim tableGruppi = GetGruppi(IDConsultazione)
                For numeroGruppo As Integer = 1 To numeroGruppi
                    Dim IDLista As Integer = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                    Dim voti = GetVotiValidiGruppo(IDConsultazione, IDLista, sezioniIDs)
                    sheet.SetValue(2, col, voti.ToString)
                    col += 1
                    votiTotaliListe += voti
                Next
                sheet.SetValue(2, col, votiTotaliListe.ToString)
                col += 1

                'totali e quadrature
                Dim schedeBianche = GetSchedeBianche(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeBianche.ToString)
                col += 1

                Dim schedeNulle = GetSchedeNulle(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeNulle.ToString)
                col += 1

                Dim schedeContestate = GetSchedeContestate(IDConsultazione, sezioniIDs)
                sheet.SetValue(2, col, schedeContestate.ToString)
                col += 1

                Dim votiTotali = votiTotaliListe + schedeBianche + schedeNulle + schedeContestate
                sheet.SetValue(2, col, votiTotali.ToString)

                sheet.Unprotect()
                excel.UnProtect()
                excel.Save()

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub Scrutinio2011()
        Try
            Dim templateName As String = "ALLEGATO-N8-ComuneCosenza(Ufficiale)"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileTemplate As String = pathRoot + "Templates\" + templateName + ".xls"
            Dim fileDestination As String = pathRoot + "Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New OfficeUtility.ExcelUtility
            excel.OpenWorkBook(fileDestination)
            Dim sheetName As String = "Comunali Uff"

            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim numeroSezioniCollegio As Integer = GetNumeroSezioniCollegio(IDConsultazione)
                Dim sezioniIDs As ArrayList = GetSezioniIDs(IDConsultazione, consultazione) 'sono le sole sezioni rilevate...
                Dim sezioniRilevate As Integer = sezioniIDs.Count
                excel.SetValue(sheetName, 8, 5, sezioniRilevate.ToString)
                excel.SetValue(sheetName, 8, 7, "su " + numeroSezioniCollegio.ToString)

                'voti di lista
                Dim votiTotaliListe As Integer = 0
                Dim row As Integer = 10
                Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
                Dim tableListe = GetListe(IDConsultazione)
                For numeroLista As Integer = 1 To numeroListe
                    Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                    Dim voti = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                    excel.SetValue(sheetName, row, 10, voti.ToString)
                    row += 1
                    votiTotaliListe += voti
                Next
                excel.SetValue(sheetName, 43, 10, votiTotaliListe.ToString)

                'voti candidati
                Dim votiTotaliCandidati As Integer = 0
                Dim votiTotaliSoloCandidati As Integer = 0
                row = 46
                Dim numeroGruppi As Integer = GetNumeroGruppi(IDConsultazione)
                Dim tableGruppi = GetGruppi(IDConsultazione)
                For numeroGruppo As Integer = 1 To numeroGruppi
                    Dim IDGruppo As Integer = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                    Dim voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                    Dim votiSoloCandidati = GetVotiSoloGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                    excel.SetValue(sheetName, row, 10, voti.ToString)
                    row += 1
                    votiTotaliCandidati += voti
                    votiTotaliSoloCandidati += votiSoloCandidati
                Next
                excel.SetValue(sheetName, 53, 10, votiTotaliCandidati.ToString)
                excel.SetValue(sheetName, 54, 10, votiTotaliSoloCandidati.ToString)

                'totali e quadrature
                Dim schedeBianche = GetSchedeBianche(IDConsultazione, sezioniIDs)
                excel.SetValue(sheetName, 56, 10, schedeBianche.ToString)

                Dim schedeNulle = GetSchedeNulle(IDConsultazione, sezioniIDs)
                excel.SetValue(sheetName, 57, 10, schedeNulle.ToString)

                Dim schedeContestate = GetSchedeContestate(IDConsultazione, sezioniIDs)
                excel.SetValue(sheetName, 58, 10, schedeContestate.ToString)

                Dim votiTotali = votiTotaliCandidati + schedeBianche + schedeNulle + schedeContestate
                excel.SetValue(sheetName, 60, 10, votiTotali.ToString)

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                excel.SetValue(sheetName, 63, 3, votantiMaschi.ToString)

                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                excel.SetValue(sheetName, 63, 5, votantiFemmine.ToString)

                Dim votantiTotali = votantiMaschi + votantiFemmine
                excel.SetValue(sheetName, 63, 10, votantiTotali.ToString)

                excel.CloseWorkBook(True, fileDestination)
                excel.Quit()


            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function GetVotiValidi(IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim votiTotaliCandidati As Integer = 0
            Dim numeroGruppi As Integer = GetNumeroGruppi(IDConsultazione)
            Dim tableGruppi = GetGruppi(IDConsultazione)
            For numeroGruppo As Integer = 1 To numeroGruppi
                Dim IDGruppo As Integer = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                Dim voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                votiTotaliCandidati += voti
            Next
            Return votiTotaliCandidati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    'Private Sub ScrutinioParziale2010()
    '    Try
    '        Dim templateName As String = "8-SCRUTINIO PARZIALE"
    '        Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
    '        Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
    '        Dim fileTemplate As String = pathRoot + "Templates\" + templateName + ".xls"
    '        Dim fileDestination As String = pathRoot + "Reports\" + fileName
    '        IO.File.Copy(fileTemplate, fileDestination, True)

    '        Dim excel As New OfficeUtility.ExcelUtility
    '        excel.OpenWorkBook(fileDestination)
    '        Dim sheetName As String = "Candidati+Liste"
    '        excel.SetValue(sheetName, 3, 7, "COSENZA")

    '        Dim consultazione As String = cboConsultazioni.SelectedItem
    '        If (Not consultazione Is Nothing) Then
    '            Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
    '            Dim numeroSezioniCollegio As Integer = GetNumeroSezioniCollegio(IDConsultazione)
    '            Dim sezioniIDs As ArrayList = GetSezioniIDs(IDConsultazione)
    '            Dim sezioniRilevate As Integer = sezioniIDs.Count ' GetSezioniRilevate(IDConsultazione)
    '            excel.SetValue(sheetName, 5, 3, sezioniRilevate.ToString)
    '            excel.SetValue(sheetName, 5, 4, "su " + numeroSezioniCollegio.ToString)

    '            Dim votiTotaliCandidati As Integer = 0
    '            Dim IDGruppo As Integer = GetIDGruppoFromNumero(IDConsultazione, 1)
    '            Dim voti As Integer = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
    '            excel.SetValue(sheetName, 8, 3, voti.ToString)
    '            votiTotaliCandidati += voti
    '            IDGruppo = GetIDGruppoFromNumero(IDConsultazione, 2)
    '            voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
    '            excel.SetValue(sheetName, 11, 3, voti.ToString)
    '            votiTotaliCandidati += voti
    '            IDGruppo = GetIDGruppoFromNumero(IDConsultazione, 3)
    '            voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
    '            excel.SetValue(sheetName, 17, 3, voti.ToString)
    '            votiTotaliCandidati += voti
    '            excel.SetValue(sheetName, 23, 3, votiTotaliCandidati.ToString)

    '            Dim votiTotaliListe As Integer = 0
    '            Dim row As Integer = 8
    '            Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
    '            For numeroLista As Integer = 1 To numeroListe
    '                Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista)
    '                voti = GetVotiValidiLista(IDConsultazione, IDLista)
    '                excel.SetValue(sheetName, row, 10, voti.ToString)
    '                row += 1
    '                votiTotaliListe += voti
    '            Next
    '            excel.SetValue(sheetName, 23, 10, votiTotaliListe.ToString)

    '            excel.CloseWorkBook(True, fileDestination)
    '            excel.Quit()

    '            Dim objLinkParameters As New LinkParameters()
    '            objLinkParameters.Target = "_blank"
    '            Link.Open("Resources/Reports/", objLinkParameters)
    '        End If

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    'End Sub

    Public Function GetSezioniIDs(ByVal IDConsultazione As Integer, consultazione As String) As ArrayList
        Try
            Dim sezioniIDs As New ArrayList
            Dim numeroGruppi = GetNumeroGruppi(IDConsultazione)
            Dim tableVotiCandidati = GetVotiCandidati(IDConsultazione)
            Dim tableCandidati = GetCandidati(IDConsultazione)
            Dim tableVotiLista = GetVotiLista(IDConsultazione)
            Dim tableListe = GetListe(IDConsultazione)
            Dim tableVotiGruppo = GetVotiGruppo(IDConsultazione)
            Dim tableGruppi = GetGruppi(IDConsultazione)
            Dim tableSezioni = GetSezioni(IDConsultazione)
            For Each rowSezione As EAPModel.soraldo_ele_sezioniRow In tableSezioni.Rows
                Dim IDSezione = rowSezione.id_sez
                Dim stato = GetStatoSezione(IDConsultazione, IDSezione, consultazione, numeroGruppi, tableVotiCandidati, _
                                            tableCandidati, tableVotiLista, tableListe, tableVotiGruppo, tableGruppi, tableSezioni)
                If (stato = "OK") Then
                    sezioniIDs.Add(IDSezione)
                End If
            Next

            Return sezioniIDs

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Public Function GetSezioni(IDConsultazione As Integer) As DataTable
        Try
            Dim adapterSezioni As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim table = adapterSezioni.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try
        Return Nothing
    End Function


    Private Function GetIDGruppoFromNumero(ByVal IDConsultazione As Integer, ByVal numero As Integer, tableGruppi As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_gruppoTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneNumero(IDConsultazione, numero)
            Dim rows = tableGruppi.Select("num_gruppo=" + numero.ToString)
            If (rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_gruppoRow = rows(0)
                Dim IDGruppo As Integer = row.id_gruppo
                Return IDGruppo
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetIDListaFromNumero(ByVal IDConsultazione As Integer, ByVal numero As Integer, tableListe As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneNumero(IDConsultazione, numero)
            Dim rows = tableListe.Select("num_lista=" + numero.ToString)
            If (rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_listaRow = rows(0)
                Dim IDLista As Integer = row.id_lista
                Return IDLista
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetIDCandidatoFromNumero(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, ByVal numero As Integer, tableCandidati As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_candidatiTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneIDListaNumero(IDConsultazione, IDLista, numero)
            Dim rows = tableCandidati.Select("id_lista=" + IDLista.ToString + " and num_cand=" + numero.ToString)
            If (rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_candidatiRow = rows(0)
                Dim IDCandidato As Integer = row.id_cand
                Return IDCandidato
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetNumeroListe(ByVal IDConsultazione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Dim numeroListe As Integer = table.Rows.Count
            Return numeroListe

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetNumeroListeGruppo(ByVal IDConsultazione As Integer, IDGruppo As Integer, tableListe As DataTable) As List(Of Integer)
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneIDGruppo(IDConsultazione, IDGruppo)
            Dim rows = tableListe.Select("id_gruppo=" + IDGruppo.ToString)
            Dim numeroListe As New List(Of Integer)
            For Each row As EAPModel.soraldo_ele_listaRow In rows
                numeroListe.Add(row.num_lista)
            Next
            Return numeroListe

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Public Function GetNumeroGruppi(ByVal IDConsultazione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_gruppoTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazione(IDConsultazione)
            Dim numeroGruppi As Integer = table.Rows.Count
            Return numeroGruppi

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetNumeroCandidati(ByVal IDConsultazione As Integer, ByVal IDLista As Integer, tableCandidati As DataTable) As Integer
        Try
            'Dim adapter As New EAPModelTableAdapters.soraldo_ele_candidatiTableAdapter
            'Dim table As DataTable = adapter.GetDataByIDConsultazioneIDLista(IDConsultazione, IDLista)
            Dim rows = tableCandidati.Select("id_lista=" + IDLista.ToString)
            Dim numeroCandidati As Integer = rows.Count
            Return numeroCandidati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

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


    Private Sub cmdScrutinioFinale_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdScrutinioFinale.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)

            Dim pathRoot = UtilityContainer.GetRootPath(Context)
            Dim templateName As String = "Scrutini_Liste_Europee_F2003_2014" ' IIf(consultazione = "Camera 2013", "Camera2013", "Senato2013")
            Dim fileTemplate As String = pathRoot + "Resources\Templates\" + templateName + ".xls"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Scrutinio2014(consultazione, pathRoot, fileTemplate, fileName, sezioniIDs)
            MessageBoxShow("Calcolo degli scrutini finali completato con successo. E' possibile accedere all'area reports per effettuare il download del report in formato XLS. Verificare le quadrature prima di trasmettere i dati alla Prefettura.")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


    Private Function GetVotiSoloGruppo(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
                If (table.Count >= 1) Then
                    Dim sezione = table(0)
                    totale += sezione.solo_gruppo
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSchedeBianche(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
                If (table.Count >= 1) Then
                    Dim sezione = table(0)
                    totale += sezione.bianchi
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetSchedeBiancheReferendum(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    If (Not row.IsbianchiNull) Then
                        totale += row.bianchi
                    End If
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetSchedeNulleReferendum(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    If (Not row.IsnulliNull) Then
                        totale += row.nulli
                    End If
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetSchedeContestateReferendum(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    If (Not row.IscontestatiNull) Then
                        totale += row.contestati
                    End If
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Private Function GetSchedeNulle(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
                If (table.Count >= 1) Then
                    Dim sezione = table(0)
                    totale += sezione.nulli + sezione.voti_nulli
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSchedeContestate(ByVal IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim table = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
                If (table.Count >= 1) Then
                    Dim sezione = table(0)
                    totale += sezione.contestati
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetVotantiMaschi(ByVal IDConsultazione As Integer, ByVal consultazione As String, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale = 0
            For Each IDSezione As Integer In sezioniIDs
                totale += GetVotantiMaschiSezione(IDConsultazione, consultazione, IDSezione)
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotantiMaschiSezione(ByVal IDConsultazione As Integer, ByVal consultazione As String, IDSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_parzialeTableAdapter
            Dim voti As EAPModel.soraldo_ele_voti_parzialeDataTable = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim dataUltimaRilevazione As Date = GetDataUltimaRilevazione(IDConsultazione, consultazione)
            Dim totale As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_parzialeRow In voti
                Dim dataVoto As DateTime = New DateTime(voto.data.Year, voto.data.Month, voto.data.Day, voto.orario.Hours, voto.orario.Minutes, voto.orario.Seconds)
                If (dataUltimaRilevazione = dataVoto) Then
                    totale += voto.voti_uomini
                End If

            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetDataUltimaRilevazione(ByVal IDConsultazione As Integer, ByVal consultazione As String) As DateTime
        Try
            Dim IDConsultazioneGenerale As Integer = GetIDConsultazioneGenerale(consultazione)
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_rilaffTableAdapter
            Dim table As DataTable = adapter.GetDataByIDConsultazioneGenerale(IDConsultazioneGenerale)
            If (table.Rows.Count >= 1) Then
                Dim row As EAPModel.soraldo_ele_rilaffRow = table.Rows(0)
                Dim dataUltimaRilevazione As Date = New Date(row.data.Year, row.data.Month, row.data.Day, row.orario.Hours, row.orario.Minutes, row.orario.Seconds)
                Return dataUltimaRilevazione

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return DateTime.MinValue

    End Function

    Public Function GetVotantiFemmine(ByVal IDConsultazione As Integer, ByVal consultazione As String, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale = 0
            For Each IDSezione As Integer In sezioniIDs
                totale += GetVotantiFemmineSezione(IDConsultazione, consultazione, IDSezione)
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1


    End Function

    Private Function GetVotantiFemmineSezione(ByVal IDConsultazione As Integer, ByVal consultazione As String, IDSezione As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_voti_parzialeTableAdapter
            Dim voti As EAPModel.soraldo_ele_voti_parzialeDataTable = adapter.GetDataByIDConsultazioneIDSezione(IDConsultazione, IDSezione)
            Dim dataUltimaRilevazione As Date = GetDataUltimaRilevazione(IDConsultazione, consultazione)
            Dim totale As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_parzialeRow In voti
                Dim dataVoto As DateTime = New DateTime(voto.data.Year, voto.data.Month, voto.data.Day, voto.orario.Hours, voto.orario.Minutes, voto.orario.Seconds)
                If (dataUltimaRilevazione = dataVoto) Then
                    totale += voto.voti_donne
                End If

            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1


    End Function

    Private Sub cmdPreferenzeCandidati_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdPreferenzeCandidati.Click
        Try
            Dim consultazione As String = cboConsultazioni.SelectedItem
            Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
            Dim tableCandidati = GetCandidati(IDConsultazione)

            Dim pathRoot = UtilityContainer.GetRootPath(Context)
            Dim templateName As String = "Scrutini_Preferenze_Europee_F2003_2014" ' IIf(consultazione = "Camera 2013", "Camera2013", "Senato2013")
            Dim fileTemplate As String = pathRoot + "Resources\Templates\" + templateName + ".xls"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Preferenze2014(consultazione, pathRoot, fileTemplate, fileName, sezioniIDs, tableCandidati)
            MessageBoxShow("Calcolo delle preferenze ai candidati completato con successo. E' possibile accedere all'area reports per effettuare il download del report in formato XLS. Verificare le quadrature prima di trasmettere i dati alla Prefettura.")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try

    End Sub

    Public Sub Preferenze2014(consultazione As String, pathRoot As String, fileTemplate As String, fileName As String, sezioniIDs As ArrayList, tableCandidati As DataTable)
        Try
            Dim fileDestination As String = pathRoot + "Resources\Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New Spire.Xls.Workbook()
            excel.Version = Spire.Xls.ExcelVersion.Version2007
            excel.LoadFromFile(fileDestination)

            Dim sheetName As String = "Foglio1"
            Dim sheet = excel.Worksheets(sheetName)

            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim numeroSezioniCollegio As Integer = 82
                Dim sezioniRilevate As Integer = sezioniIDs.Count

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiTotali = votantiMaschi + votantiFemmine

                'scrittura codice segreto
                sheet.SetValue(2, 1, 1184)

                'voti di lista
                Dim col = 2
                Dim votiTotaliListe As Integer = 0
                Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
                Dim tableListe = GetListe(IDConsultazione)
                For numeroLista As Integer = 1 To numeroListe
                    Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                    Dim numeroCandidati As Integer = GetNumeroCandidati(IDConsultazione, IDLista, tableCandidati)
                    Dim votiTotaliCandidati = 0
                    For numeroCandidato As Integer = 1 To numeroCandidati
                        Dim IDCandidato As Integer = GetIDCandidatoFromNumero(IDConsultazione, IDLista, numeroCandidato, tableCandidati)
                        Dim votiCandidato = GetVotiValidiCandidato(IDConsultazione, IDCandidato, sezioniIDs)
                        sheet.SetValue(2, col, votiCandidato.ToString)
                        col += 1
                        votiTotaliCandidati += votiCandidato

                    Next
                    'Dim votiLista = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                    'votiTotaliListe += votiLista
                    sheet.SetValue(2, col, votiTotaliCandidati.ToString)
                    col += 1

                Next

                'sheet.Unprotect()
                'excel.UnProtect()
                excel.Save()

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub Preferenze2011(fileTemplate As String, fileDestination As String, tableCandidati As DataTable)
        Try
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim word As New OfficeUtility.WordUtility
            word.OpenDocument(fileDestination)

            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
                word.SetValue("$Ns", sezioniIDs.Count.ToString)

                Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
                Dim tableListe = GetListe(IDConsultazione)
                For numeroLista As Integer = 1 To numeroListe
                    Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                    'Dim voti As Integer = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                    Dim numeroCandidati As Integer = GetNumeroCandidati(IDConsultazione, IDLista, tableCandidati)
                    For numeroCandidato As Integer = 1 To numeroCandidati
                        Dim IDCandidato As Integer = GetIDCandidatoFromNumero(IDConsultazione, IDLista, numeroCandidato, tableCandidati)
                        Dim voti = GetVotiValidiCandidato(IDConsultazione, IDCandidato, sezioniIDs)
                        Dim fieldName = "$L" + numeroLista.ToString + "C" + numeroCandidato.ToString
                        word.SetValue(fieldName, voti.ToString)

                    Next
                Next

                word.CloseDocument(True)
                word.Quit()


            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ScrutinioBallottaggio2011()
        Try
            Dim templateName As String = "Ballottaggio_2011"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".doc"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileTemplate As String = pathRoot + "Templates\" + templateName + ".doc"
            Dim fileDestination As String = pathRoot + "Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim word As New OfficeUtility.WordUtility
            word.OpenDocument(fileDestination)

            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
                word.SetValue("$N", sezioniIDs.Count.ToString)

                'voti candidati
                Dim votiTotaliCandidati As Integer = 0
                Dim votiTotaliSoloCandidati As Integer = 0
                Dim numeroGruppi As Integer = GetNumeroGruppi(IDConsultazione)
                Dim tableGruppi = GetGruppi(IDConsultazione)
                For numeroGruppo As Integer = 1 To numeroGruppi
                    Dim IDGruppo As Integer = GetIDGruppoFromNumero(IDConsultazione, numeroGruppo, tableGruppi)
                    Dim voti = GetVotiValidiGruppo(IDConsultazione, IDGruppo, sezioniIDs)
                    word.SetValue("$C" + numeroGruppo.ToString, voti.ToString)
                    votiTotaliCandidati += voti
                Next
                word.SetValue("$VOTI_VALIDI", votiTotaliCandidati.ToString)

                'totali e quadrature
                Dim schedeBianche = GetSchedeBianche(IDConsultazione, sezioniIDs)
                word.SetValue("$SCHEDE_BIANCHE", schedeBianche.ToString)

                Dim schedeNulle = GetSchedeNulle(IDConsultazione, sezioniIDs)
                word.SetValue("$SCHEDE_NULLE", schedeNulle.ToString)

                Dim schedeContestate = GetSchedeContestate(IDConsultazione, sezioniIDs)
                word.SetValue("$CONTESTATE", schedeContestate.ToString)

                Dim votiTotali = votiTotaliCandidati + schedeBianche + schedeNulle + schedeContestate
                word.SetValue("$TOTALE", votiTotali.ToString)

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiTotali = votantiMaschi + votantiFemmine
                word.SetValue("$VOTANTI", votantiTotali.ToString)

                word.SetValue("$DataOra", Now.ToString("dd/MM/yyyy hh.mm.ss"))

                word.CloseDocument(True)
                word.Quit()


            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    'ToDo: con word.utility office
    'Public Sub ScrutinioReferendum2011(consultazione As String)
    '    Try
    '        If (Not consultazione Is Nothing) Then
    '            Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
    '            Dim Nr = GetNumeroReferendum(consultazione)
    '            Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
    '            Dim templateName As String = "Referendum_2011"
    '            Dim fileName As String = templateName + "_n" + Nr.ToString + "_sezioni_" + sezioniIDs.Count.ToString + "_su_82.doc"
    '            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
    '            Dim fileTemplate As String = pathRoot + "Templates\" + templateName + ".doc"
    '            Dim fileDestination As String = pathRoot + "Reports\" + fileName
    '            IO.File.Copy(fileTemplate, fileDestination, True)

    '            Dim word As New OfficeUtility.WordUtility
    '            word.OpenDocument(fileDestination)
    '            word.SetValue("$Ns", sezioniIDs.Count.ToString)
    '            word.SetValue("$Nr", Nr.ToString)

    '            'voti si+no
    '            Dim si = GetSiReferendum(IDConsultazione, sezioniIDs)
    '            Dim no = GetNoReferendum(IDConsultazione, sezioniIDs)
    '            word.SetValue("$si", si.ToString)
    '            word.SetValue("$no", no.ToString)

    '            Dim totaleValidi = si + no
    '            word.SetValue("$TotaleValidi", totaleValidi.ToString)

    '            'totali e quadrature
    '            Dim schedeBianche = GetSchedeBiancheReferendum(IDConsultazione, sezioniIDs)
    '            word.SetValue("$Bianche", schedeBianche.ToString)

    '            Dim schedeNulle = GetSchedeNulleReferendum(IDConsultazione, sezioniIDs)
    '            word.SetValue("$Nulle", schedeNulle.ToString)

    '            Dim schedeContestate = GetSchedeContestateReferendum(IDConsultazione, sezioniIDs)
    '            word.SetValue("$Contestate", schedeContestate.ToString)

    '            Dim votiTotali = totaleValidi + schedeBianche + schedeNulle + schedeContestate
    '            word.SetValue("$TotaleVoti", votiTotali.ToString)

    '            Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
    '            Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
    '            Dim votantiTotali = votantiMaschi + votantiFemmine
    '            word.SetValue("$maschi", votantiMaschi.ToString)
    '            word.SetValue("$femmine", votantiFemmine.ToString)
    '            word.SetValue("$TotaleVotanti", votantiTotali.ToString)

    '            word.SetValue("$data", Now.ToString("dd/MM/yyyy HH.mm.ss"))

    '            word.CloseDocument(True)
    '            word.Quit()


    '        End If

    '    Catch ex As Exception
    '        UtilityContainer.ErrorLog(ex)

    '    End Try
    'End Sub

    Public Sub ScrutinioReferendum2011(consultazione As String, pathRoot As String)
        Try
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim Nr = GetNumeroReferendum(consultazione)
                Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
                Dim templateName As String = "Referendum_2011"
                Dim fileName As String = templateName + "_n" + Nr.ToString + "_sezioni_" + sezioniIDs.Count.ToString + "_su_82.doc"
                Dim fileTemplate As String = pathRoot + "Resources\Templates\" + templateName + ".doc"
                Dim fileDestination As String = pathRoot + "Resources\Reports\" + fileName

                IO.File.Copy(fileTemplate, fileDestination, True)

                Dim word As New Aspose.Words.Document(fileDestination)
                word.Range.Replace("$Ns", sezioniIDs.Count.ToString, False, False)
                word.Range.Replace("$Nr", Nr.ToString, False, False)

                'voti si+no
                Dim si = GetSiReferendum(IDConsultazione, sezioniIDs)
                Dim no = GetNoReferendum(IDConsultazione, sezioniIDs)
                word.Range.Replace("$si", si.ToString, False, False)
                word.Range.Replace("$no", no.ToString, False, False)

                Dim totaleValidi = si + no
                word.Range.Replace("$TotaleValidi", totaleValidi.ToString, False, False)

                'totali e quadrature
                Dim schedeBianche = GetSchedeBiancheReferendum(IDConsultazione, sezioniIDs)
                word.Range.Replace("$Bianche", schedeBianche.ToString, False, False)

                Dim schedeNulle = GetSchedeNulleReferendum(IDConsultazione, sezioniIDs)
                word.Range.Replace("$Nulle", schedeNulle.ToString, False, False)

                Dim schedeContestate = GetSchedeContestateReferendum(IDConsultazione, sezioniIDs)
                word.Range.Replace("$Contestate", schedeContestate.ToString, False, False)

                Dim votiTotali = totaleValidi + schedeBianche + schedeNulle + schedeContestate
                word.Range.Replace("$TotaleVoti", votiTotali.ToString, False, False)

                Dim votantiMaschi = GetVotantiMaschi(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiFemmine = GetVotantiFemmine(IDConsultazione, consultazione, sezioniIDs)
                Dim votantiTotali = votantiMaschi + votantiFemmine
                word.Range.Replace("$maschi", votantiMaschi.ToString, False, False)
                word.Range.Replace("$femmine", votantiFemmine.ToString, False, False)
                word.Range.Replace("$TotaleVotanti", votantiTotali.ToString, False, False)
                word.Range.Replace("$data", Now.ToString("dd/MM/yyyy HH.mm.ss"), False, False)

                word.Save(fileDestination, Aspose.Words.SaveFormat.Doc)

            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function GetNoReferendum(IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    If (Not row.IsbianchiNull) Then
                        totale += row.no
                    End If
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetSiReferendum(IDConsultazione As Integer, sezioniIDs As ArrayList) As Integer
        Try
            Dim totale As Integer = 0
            For Each IDSezione As Integer In sezioniIDs
                Dim row = GetVotiReferendum(IDConsultazione, IDSezione)
                If (Not row Is Nothing) Then
                    If (Not row.IsbianchiNull) Then
                        totale += row.si
                    End If
                End If
            Next
            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Public Function GetNumeroReferendum(consultazione As String) As Integer
        Try
            Dim pos = consultazione.IndexOf(".")
            Dim numero = consultazione.Substring(pos + 1, consultazione.Length - pos - 1)
            If (IsNumeric(numero)) Then
                Return numero
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Private Sub Preferenze2010(tableCandidati As DataTable)
        Try
            Dim templateName As String = "10-PREFERENZE"
            Dim fileName As String = templateName + "_" + Now.ToString("ddMMyyyy_hhmmss") + ".xls"
            Dim pathRoot As String = Gizmox.WebGUI.Forms.VWGContext.Current.HttpContext.Request.PhysicalApplicationPath + "Resources\"
            Dim fileTemplate As String = pathRoot + "Templates\" + templateName + ".xls"
            Dim fileDestination As String = pathRoot + "Reports\" + fileName
            IO.File.Copy(fileTemplate, fileDestination, True)

            Dim excel As New OfficeUtility.ExcelUtility
            excel.OpenWorkBook(fileDestination)
            Dim sheetName As String = "preferenze"
            excel.SetValue(sheetName, 3, 8, "COSENZA")


            Dim consultazione As String = cboConsultazioni.SelectedItem
            If (Not consultazione Is Nothing) Then
                Dim IDConsultazione As Integer = GetIDConsultazione(consultazione)
                Dim sezioniIDs = GetSezioniIDs(IDConsultazione, consultazione)
                Dim numeroListe As Integer = GetNumeroListe(IDConsultazione)
                Dim tableListe = GetListe(IDConsultazione)
                For numeroLista As Integer = 1 To numeroListe
                    Dim row As Integer = Int((numeroLista - 1) / 4) * 20 + 7
                    Dim col As Integer = (numeroLista - 1) * 3 + 3
                    col = col - Int((numeroLista - 1) / 4) * 12

                    Dim IDLista As Integer = GetIDListaFromNumero(IDConsultazione, numeroLista, tableListe)
                    Dim voti As Integer = GetVotiValidiLista(IDConsultazione, IDLista, sezioniIDs)
                    excel.SetValue(sheetName, row, col, voti.ToString)

                    Dim numeroCandidati As Integer = GetNumeroCandidati(IDConsultazione, IDLista, tableCandidati)
                    For numeroCandidato As Integer = 1 To numeroCandidati
                        Dim rowCandidato As Integer = row + 1 + numeroCandidato
                        Dim IDCandidato As Integer = GetIDCandidatoFromNumero(IDConsultazione, IDLista, numeroCandidato, tableCandidati)
                        voti = GetVotiValidiCandidato(IDConsultazione, IDCandidato, sezioniIDs)
                        excel.SetValue(sheetName, rowCandidato, col, voti.ToString)

                    Next
                Next

                excel.CloseWorkBook(True, fileDestination)
                excel.Quit()

                Dim objLinkParameters As New LinkParameters()
                objLinkParameters.Target = "_blank"
                Link.Open("Resources/Reports/", objLinkParameters)
            End If

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
            'Dim root = UtilityContainer.GetRootUrl(Context)
            'Dim url = root + "/resources/reports"
            'Link.Open(url)
            Dim _reports = New Reports
            _reports.Show()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdPubblica_Click(sender As System.Object, e As System.EventArgs) Handles cmdPubblica.Click
        Try
            Dim root = UtilityContainer.GetRootPath(Context)
            Dim syncMySQL = SynchronizeMySQLServers(root)

            MessageBoxShow("La sincronizzazione dei servers MySQL è terminata con successo.")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Function SynchronizeMySQLServers(root As String) As Boolean
        Try
            Dim strFilePath = root + "Resources\Tools\SyncMySQL.cmd"
            Dim psi As New System.Diagnostics.ProcessStartInfo("cmd.exe")
            psi.UseShellExecute = False
            psi.RedirectStandardInput = True
            psi.RedirectStandardOutput = True
            psi.RedirectStandardError = True
            psi.WorkingDirectory = "c:\temp"

            Dim proc As System.Diagnostics.Process
            proc = System.Diagnostics.Process.Start(psi)

            Dim strm As System.IO.StreamReader
            strm = System.IO.File.OpenText(strFilePath)

            Dim sout As System.IO.StreamReader
            sout = proc.StandardOutput

            Dim sin As System.IO.StreamWriter
            sin = proc.StandardInput
            While (strm.Peek() <> -1)
                sin.WriteLine(strm.ReadLine())
            End While
            strm.Close()

            Dim stEchoFmt As String
            stEchoFmt = "# {0} run successfully. Exiting"
            sin.WriteLine(String.Format(stEchoFmt, strFilePath))
            sin.WriteLine("EXIT")
            proc.Close()

            Dim results As String
            results = sout.ReadToEnd.Trim
            sin.Close()
            sout.Close()

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

    Public Function GetVotiCandidati(IDConsultazione As Integer) As DataTable
        Try
            Dim adapter = New EAPModelTableAdapters.soraldo_ele_voti_candidatiTableAdapter
            Dim table = adapter.GetDataByIDConsultazione(IDConsultazione)
            Return table

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try
        Return Nothing

    End Function

End Class
