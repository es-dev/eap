Imports WorkSpaceContent_Library

Public Class EditingData


    Public Sub New()

        ' This call is required by the Windows Form Designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            Dim user As String = Session.Item("user")
            Dim authenticated As Boolean = (Not user Is Nothing)
            ShowUserInformation(user)
            ActivateCommand(authenticated, user)

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

    Private Sub cmdSpoglio_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cmdSpoglio.Click
        Try
            Dim gestione As New GestioneSpoglio
            Context.Transfer(gestione)
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
