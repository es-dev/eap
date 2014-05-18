

Public Class GestioneSpoglio

    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            Dim user As String = Session.Item("user")
            Dim authenticated As Boolean = (Not user Is Nothing)
            ShowUserInformation(user)
            ActivateCommand(authenticated, user)

            ClearCombo()
            If (authenticated) Then
                LoadConsultazioni()
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub



    Private Sub ActivateCommand(ByVal authenticated As Boolean, ByVal user As String)
        Try
            If (authenticated) Then
                Select Case UCase(user)
                    Case "PREFETTURA"
                        cmdSpoglio.Enabled = False
                        cmdVoti.Enabled = True
                        cmdAffluenze.Enabled = True
                    Case "SUSER", "ADMIN"
                        cmdSpoglio.Enabled = True
                        cmdVoti.Enabled = True
                        cmdAffluenze.Enabled = True
                    Case Else  'OPERATORE
                        cmdSpoglio.Enabled = True
                        cmdVoti.Enabled = False
                        cmdAffluenze.Enabled = False

                End Select
            Else
                cmdSpoglio.Enabled = False
                cmdAffluenze.Enabled = False
                cmdVoti.Enabled = False
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowUserInformation(ByVal user As String)
        Try
            lblUser.Text = "Non Connesso"
            If (Not user Is Nothing AndAlso user <> "") Then
                lblUser.Text = UCase(user)
            End If
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

    Private Sub cboConsultazioni_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboConsultazioni.SelectedIndexChanged
        Try
            Dim consultazione As String = cboConsultazioni.Text
            LoadSedi(consultazione)

            Dim sede As String = cboSedi.Text
            LoadSezioni(sede, consultazione)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadSezioni(ByVal sede As String, ByVal consultazione As String)
        Try
            Dim id_cons As Integer = GetIDConsultazione(consultazione)
            Dim id_sede As Integer = GetIDSede(sede, id_cons)
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataByIDSedeIDConsultazione(id_sede, id_cons)

            cboSezioni.Items.Clear()
            cboSezioni.Text = ""
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                Dim numeroSezione As Integer = sezione.num_sez
                cboSezioni.Items.Add(numeroSezione.ToString)
            Next

            If (cboSezioni.Items.Count >= 1) Then
                cboSezioni.SelectedIndex = 0
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetIDSede(ByVal indirizzo As String, ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sedeTableAdapter
            Dim sedi As EAPModel.soraldo_ele_sedeDataTable = adapter.GetDataBySedeIDConsultazione(indirizzo, id_cons)
            If (sedi.Count >= 1) Then
                Dim sede As EAPModel.soraldo_ele_sedeRow = sedi(0)
                Dim IDSede As Integer = sede.id_sede
                Return IDSede
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Sub LoadSedi(ByVal consultazione As String)
        Try
            Dim id_cons As Integer = GetIDConsultazione(consultazione)
            Dim user As String = Session.Item("user")
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_operatoriTableAdapter
            Dim sediOperatore As EAPModel.soraldo_ele_operatoriDataTable = adapter.GetDataByIDConsultazioneAid(id_cons, user)

            cboSedi.Items.Clear()
            cboSedi.Text = ""
            For Each sedeOperatore As EAPModel.soraldo_ele_operatoriRow In sediOperatore
                Dim id_sede As Integer = sedeOperatore.id_sede
                Dim sede As String = GetSede(id_sede)
                cboSedi.Items.Add(sede)
            Next

            If (cboSedi.Items.Count >= 1) Then
                cboSedi.SelectedIndex = 0
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Function GetIDConsultazione(ByVal descrizione As String) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim consultazioni As EAPModel.soraldo_ele_consultazioneDataTable = adapter.GetDataByConsultazione(descrizione)
            If (consultazioni.Count >= 1) Then
                Dim consultazione As EAPModel.soraldo_ele_consultazioneRow = consultazioni(0)
                Dim id_cons_gen As Integer = consultazione.id_cons_gen
                Dim adapterConsultazioniComune As New EAPModelTableAdapters.soraldo_ele_cons_comuneTableAdapter
                Dim consultazioniComune As EAPModel.soraldo_ele_cons_comuneDataTable = adapterConsultazioniComune.GetDataByIDConsultazioneGenerale(id_cons_gen)
                If (consultazioniComune.Count >= 1) Then
                    Dim consultazioneComune As EAPModel.soraldo_ele_cons_comuneRow = consultazioniComune(0)
                    Dim id_cons As Integer = consultazioneComune.id_cons
                    Return id_cons
                End If
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try

        Return -1

    End Function

    Private Function GetSede(ByVal id_sede As Integer) As String
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sedeTableAdapter
            Dim sedi As EAPModel.soraldo_ele_sedeDataTable = adapter.GetDataByIDSede(id_sede)
            If (sedi.Count >= 1) Then
                Dim sede As EAPModel.soraldo_ele_sedeRow = sedi(0)
                Dim nomeSede As String = sede.indirizzo
                Return nomeSede
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return Nothing

    End Function

    Private Sub ClearCombo()
        Try
            cboConsultazioni.Items.Clear()
            cboSezioni.Items.Clear()
            cboSedi.Items.Clear()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadConsultazioni()
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_consultazioneTableAdapter
            Dim consultazioni As EAPModel.soraldo_ele_consultazioneDataTable = adapter.GetData

            cboConsultazioni.Items.Clear()
            cboConsultazioni.Text = ""
            For Each consultazione As EAPModel.soraldo_ele_consultazioneRow In consultazioni
                Dim tipo As Integer = consultazione.tipo_cons
                If (tipo = 11) Then
                    Dim descrizione As String = consultazione.descrizione
                    cboConsultazioni.Items.Add(descrizione)
                End If
            Next

            If (cboConsultazioni.Items.Count >= 1) Then
                cboConsultazioni.SelectedIndex = 0
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cboSedi_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboSedi.SelectedIndexChanged
        Try
            Dim consultazione As String = cboConsultazioni.Text
            Dim sede As String = cboSedi.Text
            LoadSezioni(sede, consultazione)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub


End Class
