Imports Gizmox.WebGUI.Forms


Public Class eStat

    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            Dim user As String = Session.Item("user")
            Dim authenticated As Boolean = (Not user Is Nothing)
            ShowUserInformation(user)

            LoadStatistiche()

            LoadConsultazioni()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadConsultazioni()
        Try
            cboConsultazione.Items.Clear()
            cboConsultazione.Items.Add("Elezioni Politiche 2008 - Camera")
            cboConsultazione.Items.Add("Elezioni Politiche 2008 - Senato")

            cboConsultazione.Text = "Elezioni Politiche 2008 - Camera"
            panelCamera.Visible = True
            panelSenato.Visible = False


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub LoadStatistiche()
        Try
            Dim id_cons = 6 'CAMERA
            Dim adapterListe As New EAPModelTableAdapters.soraldo_ele_listaTableAdapter
            Dim listeCamera As EAPModel.soraldo_ele_listaDataTable = adapterListe.GetDataByIDConsultazione(id_cons)

            Dim sezioniRilevateCamera As Integer = GetSezioniRilevate(id_cons)
            lblSezioniRilevateCamera.Text = "Sezioni Rilevate " + sezioniRilevateCamera.ToString + " su 82"

            listCamera.Items.Clear()
            For Each lista As EAPModel.soraldo_ele_listaRow In listeCamera
                Dim item As ListViewItem = listCamera.Items.Add(lista.num_lista)
                item.SubItems.Add(lista.descrizione)

                Dim voti As Integer = GetVoti(id_cons, lista.id_lista)
                Dim contestati As Integer = GetContestati(id_cons, lista.id_lista)
                item.SubItems.Add(voti)
                item.SubItems.Add(contestati)
            Next
            txtTotBiancheCamera.Text = GetVotiBianchi(id_cons)
            txtTotContestatiCamera.Text = GetVotiContestati(id_cons)
            txtTotNulleCamera.Text = GetSchedeNulle(id_cons)
            txtTotValidiCamera.Text = GetVotiValidi(id_cons)
            txtTotVotantiCamera.Text = GetVotanti(id_cons)

            id_cons = 7 'SENATO
            Dim sezioniRilevateSenato As Integer = GetSezioniRilevate(id_cons)
            lblSezioniRilevateSenato.Text = "Sezioni Rilevate " + sezioniRilevateSenato.ToString + " su 82"

            Dim listeSenato As EAPModel.soraldo_ele_listaDataTable = adapterListe.GetDataByIDConsultazione(id_cons)

            listSenato.Items.Clear()
            For Each lista As EAPModel.soraldo_ele_listaRow In listeSenato
                Dim item As ListViewItem = listSenato.Items.Add(lista.num_lista)
                item.SubItems.Add(lista.descrizione)

                Dim voti As Integer = GetVoti(id_cons, lista.id_lista)
                Dim contestati As Integer = GetContestati(id_cons, lista.id_lista)
                item.SubItems.Add(voti)
                item.SubItems.Add(contestati)
            Next
            txtTotBiancheSenato.Text = GetVotiBianchi(id_cons)
            txtTotContestatiSenato.Text = GetVotiContestati(id_cons)
            txtTotNulleSenato.Text = GetSchedeNulle(id_cons)
            txtTotValidiSenato.Text = GetVotiValidi(id_cons)
            txtTotVotantiSenato.Text = GetVotanti(id_cons)

        Catch ex As Exception

            UtilityContainer.ErrorLog(ex)


        End Try
    End Sub

    Private Function GetVotiBianchi(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)

            Dim totale As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                totale += sezione.bianchi
            Next

            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiContestati(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)

            Dim totale As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                totale += sezione.contestati
            Next

            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSchedeNulle(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)

            Dim totale As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                totale += sezione.nulli
            Next

            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVotiValidi(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)

            Dim totale As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                totale += sezione.validi
            Next

            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function


    Private Function GetVotanti(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)

            Dim totale As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                totale += sezione.validi + sezione.bianchi + sezione.nulli
            Next

            Return totale

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetSezioniRilevate(ByVal id_cons As Integer) As Integer
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataBySezioniRilevate(id_cons)
            Dim sezioniRilevate As Integer = sezioni.Count

            Return sezioniRilevate

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetVoti(ByVal id_cons As Integer, ByVal id_lista As Integer) As Integer
        Try
            Dim adapterVoti As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            Dim voti As EAPModel.soraldo_ele_voti_listaDataTable = adapterVoti.GetDataByIDConsultazioneIDLista(id_cons, id_lista)
            Dim votiTotali As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_listaRow In voti
                votiTotali += voto.voti
            Next

            Return votiTotali

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

    Private Function GetContestati(ByVal id_cons As Integer, ByVal id_lista As Integer) As Integer
        Try
            Dim adapterVoti As New EAPModelTableAdapters.soraldo_ele_voti_listaTableAdapter
            Dim voti As EAPModel.soraldo_ele_voti_listaDataTable = adapterVoti.GetDataByIDConsultazioneIDLista(id_cons, id_lista)
            Dim votiTotaliContestati As Integer = 0
            For Each voto As EAPModel.soraldo_ele_voti_listaRow In voti
                votiTotaliContestati += 0 'voto.cont
            Next

            Return votiTotaliContestati

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
        Return -1

    End Function

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

    Private Sub cmdLogout_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        Try
            Dim login As New Homepage
            Context.Transfer(login)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cboConsultazione_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cboConsultazione.SelectedIndexChanged
        Try
            Select Case cboConsultazione.Text
                Case "Elezioni Politiche 2008 - Camera"
                    panelCamera.Visible = True
                    panelSenato.Visible = False
                Case Else
                    panelCamera.Visible = False
                    panelSenato.Visible = True

            End Select
            LoadStatistiche()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdRefresh_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdRefresh.Click
        Try
            LoadStatistiche()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub tmrRefresh_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tmrRefresh.Tick
        Try
            LoadStatistiche()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub CalcoloAffluenze()
        Try
            Dim adapter As New EAPModelTableAdapters.soraldo_ele_sezioniTableAdapter
            Dim sezioni As EAPModel.soraldo_ele_sezioniDataTable = adapter.GetDataByIDConsultazione(7)

            Dim maschi As Integer = 0
            Dim femmine As Integer = 0
            For Each sezione As EAPModel.soraldo_ele_sezioniRow In sezioni
                maschi += sezione.maschi
                femmine += sezione.femmine

            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try



    End Sub
End Class
