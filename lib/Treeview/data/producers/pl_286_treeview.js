USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux2 = insFld(aux1, gFld("Urządzenia","/go/_category/?idc=%2258_12380%22"))
insDoc(aux2, gLnk("S","Lampy światłoutwardzalne","/go/_category/?idc=%2258_12380_467%22"))
insDoc(aux2, gLnk("S","Naczynka do wosku","/go/_category/?idc=%2258_12380_423%22"))
insDoc(aux2, gLnk("S","Nożyki elektryczne","/go/_category/?idc=%2258_12380_416%22"))
insDoc(aux2, gLnk("S","Wibrator do gipsu","/go/_category/?idc=%2258_12380_488%22"))
