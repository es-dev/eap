Imports Gizmox.WebGUI.Forms


Public Class eStart

    Private Sub cmdMonior_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdMonitor.Click
        Try
            Dim monitor As New MonitorSezioni()
            Context.Transfer(monitor)

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

    Private Sub cmdStatoAffluenze_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdStatoAffluenze.Click
        Try
            Dim rilevazioni As New Affluenze
            Context.Transfer(rilevazioni)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdStatoVoti_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdStatoVoti.Click
        Try
            Dim spoglio As New Scrutinio
            Context.Transfer(spoglio)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            If (UCase(Session.Item("user")) = "EAP") Then
                cmdEnableOperators.Enabled = True
            Else
                cmdEnableOperators.Enabled = False
            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdEnableOperators_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdEnableOperators.Click
        Try
            Dim operators As New Operatori
            Context.Transfer(operators)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
