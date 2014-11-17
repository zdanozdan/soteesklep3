USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux2 = insFld(aux1, gFld("Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
insDoc(aux2, gLnk("S","Elektropolerki","/go/_category/?idc=%2258_12380_486%22"))
insDoc(aux2, gLnk("S","Piaskarki, dysze","/go/_category/?idc=%2258_12380_429%22"))
