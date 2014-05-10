Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common
Imports WorkSpaceContent_Library

Public Class ProiezioniTour

    Private Sub cmdTour_Click(sender As System.Object, e As System.EventArgs) Handles cmdTour.Click
        Try
            If (cmdTour.Text = "Ferma il tour") Then
                timerRefresh.Stop()
                cmdTour.Text = "Avvia il tour"
            Else
                timerRefresh.Start()
                cmdTour.Text = "Ferma il tour"
                indexUrl = 0
                ShowUrl()

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private indexUrl As Integer = 0

    Private Sub timerRefresh_Tick(sender As System.Object, e As System.EventArgs) Handles timerRefresh.Tick
        Try
            ShowUrl()
            indexUrl += 1

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowUrl()
        Try
            If (indexUrl > urls.Count - 1) Then
                indexUrl = 0
            End If

            Dim url = urls(indexUrl)
            htmlBox.Url = url
            lblAggiornamento.Text = "Ultimo aggiornamento " + Now.ToString("dd/MM/yyyy HH.mm") + "  -  Pagina " + (indexUrl + 1).ToString + "/" + urls.Count.ToString

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private urls As New ArrayList
    Public Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            urls.Add("http://elezioni.comune.cosenza.it/eap/client/modules.php?id_cons_gen=3&name=Elezioni&id_comune=74005&file=index&op=affluenze_graf")
            urls.Add("http://elezioni.comune.cosenza.it/eap/client/modules.php?name=Elezioni&op=come&file=index&id_cons_gen=3&id_comune=74005&info=affluenze_sez")
            urls.Add("http://elezioni.comune.cosenza.it/eap/client/modules.php?id_cons_gen=3&name=Elezioni&id_comune=74005&file=index&op=graf_votanti")
            urls.Add("http://elezioni.comune.cosenza.it/eap/client/modules.php?id_cons_gen=3&name=Elezioni&id_comune=74005&file=index&op=graf_gruppo")
            urls.Add("http://elezioni.comune.cosenza.it/eap/client/modules.php?op=gruppo&name=Elezioni&id_comune=74005&file=index&id_cons_gen=3")
            indexUrl = 0
            ShowUrl()


        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdNextPage_Click(sender As System.Object, e As System.EventArgs) Handles cmdNextPage.Click
        Try
            indexUrl += 1
            ShowUrl()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
