

Public Class Homepage


    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            txtUser.Focus()
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub



    Private Sub txtUser_GotFocus(ByVal sender As Object, ByVal e As System.EventArgs) Handles txtUser.GotFocus
        Try
            panelInfo.Visible = False

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub cmdLogin_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdLogin.Click
        Try
            Dim user As String = txtUser.Text
            Dim pwd As String = txtPassword.Text
            'Dim adapter As New EAPTableAdapters.soraldo_authorsTableAdapter
            'Dim users As EAP.soraldo_authorsDataTable = adapter.GetDataByUserPwd(user, pwd)
            Dim authenticated As Boolean = ((UCase(user) = "PREFETTURA") And (pwd = "p001d1516")) OrElse ((UCase(user) = "EAP") And (pwd = "eap2014"))
            ShowPanel(Not authenticated)

            Session.Item("user") = Nothing
            If (authenticated) Then
                Session.Item("user") = user
                Dim eStartPage As New eStart
                Context.Transfer(eStartPage)
            End If

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub ShowPanel(ByVal visible As Boolean)
        Try
            panelInfo.Visible = visible
            lblMessage.Visible = visible

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Private Sub txtPassword_EnterKeyDown(ByVal objSender As System.Object, ByVal objArgs As Gizmox.WebGUI.Forms.KeyEventArgs) Handles txtPassword.EnterKeyDown
        Try
            cmdLogin_Click(Nothing, Nothing)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
