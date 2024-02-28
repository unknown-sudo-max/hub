Sub ExportToTxt()
    Dim myFile As String
    Dim rng As Range
    Dim cell As Range
    Dim rowText As String
    
    ' Get the current user's profile directory
    Dim userProfile As String
    userProfile = Environ("UserProfile")
    
    ' Specify the path and filename for the output text file
    myFile = userProfile & "\Desktop\output.txt" ' Save to the user's desktop
    
    ' Open the text file for writing
    Open myFile For Output As #1
    
    ' Loop through each row in the specified range (assuming the data is in Sheet1, starting from A1)
    Set rng = ThisWorkbook.Sheets("Sheet1").UsedRange ' Change to UsedRange to include all used cells
    For Each cell In rng.Rows
        ' Construct the text for each row
        rowText = "DSL : " & cell.Cells(1, 2).Value & vbCrLf & _
                  "FCC : " & cell.Cells(1, 4).Value & vbCrLf & _
                  "Problem : " & cell.Cells(1, 8).Value & vbCrLf & _
                  "Pop Name : " & cell.Cells(1, 5).Value & vbCrLf & _
                  "Flag Time : " & cell.Cells(1, 9).Value & vbCrLf & _
                  vbCrLf & "-------------------------------------------------------" & vbCrLf
        
        ' Write the row text to the text file
        Print #1, rowText
    Next cell
    
    ' Close the text file
    Close #1
    
    MsgBox "Export completed successfully!", vbInformation
End Sub


