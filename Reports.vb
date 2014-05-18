Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common

Public Class Reports


    Private Sub Reports_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Try
            Dim pathRoot = UtilityContainer.GetRootPath(Context)
            Dim pathReports = pathRoot + "\Resources\Reports"
            LoadReports(pathReports)

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub

    Private Sub LoadReports(pathReports As String)
        Try
            listReports.Items.Clear()
            Dim files = IO.Directory.GetFiles(pathReports, "*.XLS")
            For Each file As String In files
                Dim fileName = IO.Path.GetFileName(file)
                listReports.Items.Add(fileName)
            Next

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub

    Private Sub cmdClose_Click(sender As Object, e As EventArgs) Handles cmdClose.Click
        Try
            Close()

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)
        End Try

    End Sub

    Private Sub listReports_DoubleClick(sender As Object, e As EventArgs) Handles listReports.DoubleClick
        Try
            If (Not listReports.SelectedItem Is Nothing) Then
                Dim item As String = listReports.SelectedItem
                Dim pos = item.IndexOf(":")
                Dim reportName As String = item
                Dim root = UtilityContainer.GetRootUrl(Context)
                Dim url = root + "/resources/reports/" + reportName
                Link.Open(url)

            End If
        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
