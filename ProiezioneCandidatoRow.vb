Imports Gizmox.WebGUI.Forms
Imports Gizmox.WebGUI.Common


Public Class ProiezioneCandidatoRow

    Public IDGruppo As Integer = -1
    Public Sub New(IDGruppo As Integer, numero As Integer, nomeCandidato As String)

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Try
            lblNomeCandidato.Text = numero.ToString + " - " + nomeCandidato
            imgCandidato.Image = New Gizmox.WebGUI.Common.Resources.ImageResourceHandle("Candidato" + numero.ToString + ".png")
            MyClass.IDGruppo = IDGruppo

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Voti As Integer = -1
    Public Sub AggiornaVoto(voti As Integer, votiTotali As Integer)
        Try
            If (votiTotali > 0) Then
                Dim percentuale As Double = voti / votiTotali * 100
                lblVotoCandidato.Text = percentuale.ToString("0.00") + "% (" + voti.ToString + ")"
            Else
                lblVotoCandidato.Text = "0% (-)"
            End If
            MyClass.Voti = voti

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub

    Public Sub ZoomImmagine()
        Try
            imgCandidato.Top = 24
            imgCandidato.Left = 94
            imgCandidato.Width = 140
            imgCandidato.Height = 225

            Dim font = lblVotoCandidato.Font
            lblVotoCandidato.Font = New Font(font.FontFamily, 18, FontStyle.Bold)
            lblVotoCandidato.Top = 214
            'errProvider.SetIconAlignment(imgCandidato, ErrorIconAlignment.TopLeft)
            'errProvider.SetError(imgCandidato, "Aggiornamento spoglio elettorale!")

        Catch ex As Exception
            UtilityContainer.ErrorLog(ex)

        End Try
    End Sub
End Class
